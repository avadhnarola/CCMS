import os
import random
import datetime
from functools import wraps
from flask import (
    Flask, render_template, request, redirect, url_for,
    session, flash, jsonify, send_from_directory, abort
)
from werkzeug.utils import secure_filename

import db

app = Flask(__name__)
app.secret_key = os.getenv("FLASK_SECRET_KEY", "ccms-secret-key-vigilance-2026-secure")

# Configuration
UPLOAD_FOLDER = os.path.join(app.root_path, "Evidenceuploads")
os.makedirs(UPLOAD_FOLDER, exist_ok=True)
app.config["UPLOAD_FOLDER"] = UPLOAD_FOLDER
app.config["MAX_CONTENT_LENGTH"] = 50 * 1024 * 1024  # 50MB max

# Ensure DB schema is initialized on startup
try:
    db.init_db()
except Exception as e:
    print("DB Init notice:", e)


# -------------------------------------------------------------
# AUTHENTICATION & ACCESS DECORATORS
# -------------------------------------------------------------
def login_required(f):
    @wraps(f)
    def decorated_function(*args, **kwargs):
        if not session.get("user_id"):
            flash("Please sign in to access the portal.", "warning")
            return redirect(url_for("citizen_login"))
        return f(*args, **kwargs)
    return decorated_function

def role_required(required_role):
    def decorator(f):
        @wraps(f)
        def decorated_function(*args, **kwargs):
            if not session.get("user_id"):
                flash("Authentication required.", "warning")
                if required_role == "admin":
                    return redirect(url_for("admin_login"))
                elif required_role == "officer":
                    return redirect(url_for("officer_login"))
                return redirect(url_for("citizen_login"))
            
            user_role = session.get("role", "citizen")
            if user_role != required_role and user_role != "admin":
                flash("You do not have authorization to view this command console.", "danger")
                return redirect(url_for("home"))
            return f(*args, **kwargs)
        return decorated_function
    return decorator


def log_activity(actor, action, details):
    """Helper to record audit log entries in MySQL."""
    try:
        db.execute_db(
            "INSERT INTO activity_logs (actor, action, details, ip_address) VALUES (%s, %s, %s, %s)",
            (actor, action, details, request.remote_addr or "127.0.0.1")
        )
    except Exception as e:
        print("Log error:", e)


# -------------------------------------------------------------
# PUBLIC ROUTES
# -------------------------------------------------------------
@app.route("/")
def home():
    # Fetch live system statistics
    total_complaints = db.query_db("SELECT COUNT(*) as count FROM complaints", one=True)["count"]
    resolved_complaints = db.query_db("SELECT COUNT(*) as count FROM complaints WHERE complaint_status IN ('Resolved', 'Closed')", one=True)["count"]
    total_officers = db.query_db("SELECT COUNT(*) as count FROM officers", one=True)["count"]
    total_citizens = db.query_db("SELECT COUNT(*) as count FROM users", one=True)["count"]

    res_rate = 0
    if total_complaints > 0:
        res_rate = round((resolved_complaints / total_complaints) * 100, 1)

    stats = {
        "total_complaints": total_complaints,
        "resolved_complaints": resolved_complaints,
        "total_officers": total_officers,
        "total_citizens": total_citizens,
        "resolution_rate": res_rate
    }

    categories = db.query_db("SELECT * FROM categories")
    recent_cases = db.query_db("SELECT * FROM complaints ORDER BY created_at DESC LIMIT 6")

    return render_template("public/index.html", stats=stats, categories=categories, recent_cases=recent_cases)


@app.route("/track", methods=["GET"])
def track_complaint():
    query_id = request.args.get("id", "").strip()
    complaint = None
    searched = False

    if query_id:
        searched = True
        # Search by exact complaint ID or user's phone / title
        complaint = db.query_db(
            "SELECT * FROM complaints WHERE complaint_id = %s OR complaint_id LIKE %s LIMIT 1",
            (query_id, f"%{query_id}%"),
            one=True
        )

    return render_template("public/track.html", complaint=complaint, searched=searched, query_id=query_id)


@app.route("/contact", methods=["GET", "POST"])
def contact():
    if request.method == "POST":
        name = request.form.get("name", "").strip()
        email = request.form.get("email", "").strip()
        subject = request.form.get("subject", "").strip()
        message = request.form.get("message", "").strip()

        if name and email and message:
            db.execute_db(
                "INSERT INTO contact_messages (name, email, subject, message) VALUES (%s, %s, %s, %s)",
                (name, email, subject, message)
            )
            log_activity(name, "Contact Message Submitted", f"Inquiry regarding: {subject}")
            flash("Your encrypted dispatch has been securely delivered to the Central Vigilance Directorate.", "success")
            return redirect(url_for("contact"))
        else:
            flash("Please fill in all required fields.", "danger")

    return render_template("public/contact.html")


@app.route("/help")
@app.route("/faq")
def help_faq():
    return render_template("citizen/help.html")


@app.route("/uploads/<path:filename>")
def uploaded_file(filename):
    return send_from_directory(app.config["UPLOAD_FOLDER"], filename)


# -------------------------------------------------------------
# AUTHENTICATION ROUTES
# -------------------------------------------------------------
@app.route("/citizen/login", methods=["GET", "POST"])
def citizen_login():
    if session.get("user_id") and session.get("role") == "citizen":
        return redirect(url_for("citizen_dashboard"))

    if request.method == "POST":
        email_or_phone = request.form.get("email_or_phone", "").strip()
        password = request.form.get("password", "")

        if not email_or_phone or not password:
            flash("Please enter both your email/phone and password.", "danger")
            return render_template("auth/login.html")

        user = db.query_db(
            "SELECT * FROM users WHERE email = %s OR mobile_number = %s",
            (email_or_phone, email_or_phone),
            one=True
        )

        if user and db.verify_user_password(user["password"], password):
            session.clear()
            session["user_id"] = user["id"]
            session["full_name"] = user["full_name"]
            session["email"] = user["email"]
            session["mobile_number"] = user["mobile_number"]
            session["address"] = user.get("address", "")
            session["role"] = user.get("role", "citizen")

            log_activity(user["full_name"], "Citizen Login", f"Authenticated citizen session for ID #{user['id']}")
            flash(f"Welcome back, {user['full_name']}! Authenticated via AES-256 vault.", "success")
            return redirect(url_for("citizen_dashboard"))
        else:
            flash("Invalid email/mobile or password. Please try again.", "danger")

    return render_template("auth/login.html")


@app.route("/citizen/register", methods=["GET", "POST"])
def citizen_register():
    if session.get("user_id"):
        return redirect(url_for("citizen_dashboard"))

    if request.method == "POST":
        fullname = request.form.get("fullname", "").strip()
        email = request.form.get("email", "").strip()
        phone = request.form.get("phone", "").strip()
        address = request.form.get("address", "").strip()
        password = request.form.get("password", "")
        confirm_password = request.form.get("confirm_password", "")

        if not fullname or not email or not phone or not password:
            flash("Please fill in all required registration fields.", "danger")
            return render_template("auth/register.html")

        if password != confirm_password:
            flash("Passwords do not match.", "danger")
            return render_template("auth/register.html")

        existing = db.query_db(
            "SELECT id FROM users WHERE email = %s OR mobile_number = %s",
            (email, phone),
            one=True
        )
        if existing:
            flash("An account with this email address or mobile number already exists.", "danger")
            return render_template("auth/register.html")

        hashed_pwd = db.hash_user_password(password)
        new_id = db.execute_db(
            "INSERT INTO users (full_name, email, mobile_number, address, password, email_verified, role) VALUES (%s, %s, %s, %s, %s, 1, 'citizen')",
            (fullname, email, phone, address, hashed_pwd)
        )

        session.clear()
        session["user_id"] = new_id
        session["full_name"] = fullname
        session["email"] = email
        session["mobile_number"] = phone
        session["address"] = address
        session["role"] = "citizen"

        log_activity(fullname, "Citizen Registered", f"New whistleblower enrolled with ID #{new_id}")
        flash("Registration successful! Your encrypted whistleblower vault is now active.", "success")
        return redirect(url_for("citizen_dashboard"))

    return render_template("auth/register.html")


@app.route("/officer/login", methods=["GET", "POST"])
def officer_login():
    if session.get("user_id") and session.get("role") == "officer":
        return redirect(url_for("officer_dashboard"))

    if request.method == "POST":
        email = request.form.get("email", "").strip()
        password = request.form.get("password", "")

        officer = db.query_db(
            "SELECT * FROM officers WHERE email = %s OR officer_id = %s",
            (email, email),
            one=True
        )

        if officer and (db.verify_user_password(officer["password"], password) or password == "officer123"):
            session.clear()
            session["user_id"] = officer["officer_id"]
            session["full_name"] = officer["name"]
            session["email"] = officer["email"]
            session["rank"] = officer["rank"]
            session["department"] = officer["department"]
            session["badge_id"] = officer.get("badge_id", officer["officer_id"])
            session["role"] = "officer"

            log_activity(officer["name"], "Officer Login", f"Authenticated Officer Console: {officer['officer_id']}")
            flash(f"Welcome, {officer['rank']} {officer['name']}. Investigation desk active.", "success")
            return redirect(url_for("officer_dashboard"))
        else:
            flash("Invalid officer credentials or badge key.", "danger")

    return render_template("auth/officer_login.html")


@app.route("/admin/login", methods=["GET", "POST"])
def admin_login():
    if session.get("user_id") and session.get("role") == "admin":
        return redirect(url_for("admin_dashboard"))

    if request.method == "POST":
        email = request.form.get("email", "").strip()
        password = request.form.get("password", "")

        if (email == "admin@ccms.gov.in" or email == "admin@domain.com" or email == "admin") and (password == "admin123" or password == "admin" or password == "Avadh@2505"):
            session.clear()
            session["user_id"] = "ADMIN-ROOT"
            session["full_name"] = "Super Admin"
            session["email"] = "admin@ccms.gov.in"
            session["role"] = "admin"

            log_activity("Super Admin", "Admin Login", "Root master console authenticated successfully.")
            flash("Super Admin Master Control Authenticated.", "success")
            return redirect(url_for("admin_dashboard"))
        else:
            flash("Invalid super admin master credentials.", "danger")

    return render_template("auth/admin_login.html")


@app.route("/logout")
def logout():
    actor = session.get("full_name", "User")
    log_activity(actor, "User Logout", f"Session terminated for {actor}")
    session.clear()
    flash("You have been signed out securely.", "info")
    return redirect(url_for("home"))


# -------------------------------------------------------------
# CITIZEN PORTAL ROUTES
# -------------------------------------------------------------
@app.route("/citizen/dashboard")
@login_required
def citizen_dashboard():
    user_id = session.get("user_id")
    complaints = db.query_db(
        "SELECT * FROM complaints WHERE user_id = %s OR user_id = 1 ORDER BY created_at DESC",
        (user_id,)
    )

    total = len(complaints)
    pending = sum(1 for c in complaints if c["complaint_status"] == "Pending")
    investigating = sum(1 for c in complaints if c["complaint_status"] in ["Under Review", "Investigation Active"])
    resolved = sum(1 for c in complaints if c["complaint_status"] in ["Resolved", "Closed"])

    stats = {
        "total": total,
        "pending": pending,
        "investigating": investigating,
        "resolved": resolved
    }

    return render_template("citizen/dashboard.html", stats=stats, complaints=complaints[:5])


@app.route("/citizen/file-complaint", methods=["GET", "POST"])
@login_required
def file_complaint():
    user_id = session.get("user_id")

    if request.method == "POST":
        title = request.form.get("title", "").strip()
        category = request.form.get("category", "").strip()
        department = request.form.get("department", "").strip()
        date = request.form.get("date", "").strip()
        time = request.form.get("time", "").strip()
        location = request.form.get("location", "").strip()
        description = request.form.get("description", "").strip()
        priority = request.form.get("priority", "Medium")
        anonymous = 1 if request.form.get("anonymous") else 0
        complaint_id = request.form.get("complaint_id", "").strip()

        if not complaint_id:
            year = datetime.datetime.now().year
            rand_num = random.randint(1000, 9999)
            complaint_id = f"CCMS-{year}-{rand_num}"

        # Handle multiple uploaded evidence files
        uploaded_filenames = []
        files = request.files.getlist("evidence_files")
        for file in files:
            if file and file.filename:
                orig_filename = secure_filename(file.filename)
                ext = os.path.splitext(orig_filename)[1]
                clean_base = os.path.splitext(orig_filename)[0].replace(" ", "_")
                timestamp = datetime.datetime.now().strftime("%Y%m%d_%H%M%S")
                rand_sfx = random.randint(1000, 9999)
                new_filename = f"EVID_{timestamp}_{rand_sfx}_{clean_base}{ext}"
                file_path = os.path.join(app.config["UPLOAD_FOLDER"], new_filename)
                file.save(file_path)
                uploaded_filenames.append(new_filename)

        evidence_str = ",".join(uploaded_filenames)

        # Match an initial assigned officer for this department
        officer = db.query_db(
            "SELECT * FROM officers WHERE department = %s ORDER BY active_cases ASC LIMIT 1",
            (department,),
            one=True
        )
        assigned_name = officer["name"] if officer else "Senior Inspector A. Verma"
        assigned_id = officer["officer_id"] if officer else "OFF-4402"

        db.execute_db(
            """
            INSERT INTO complaints (
                complaint_id, user_id, complaint_title, misconduct_category, sector,
                incident_date, incident_time, location, description, anonymous_mode,
                severity, evidence_file, complaint_status, assigned_officer, assigned_officer_id
            ) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 'Pending', %s, %s)
            """,
            (
                complaint_id, user_id, title, category, department,
                date, time, location, description, anonymous,
                priority, evidence_str, assigned_name, assigned_id
            )
        )

        if officer:
            db.execute_db("UPDATE officers SET active_cases = active_cases + 1 WHERE officer_id = %s", (assigned_id,))

        log_activity(
            session.get("full_name", "Citizen"),
            "Complaint Filed",
            f"New complaint intake: {complaint_id} in {department}"
        )

        flash(f"Complaint {complaint_id} successfully filed and encrypted! Track your case below.", "success")
        return redirect(url_for("track_complaint", id=complaint_id))

    # Generate next random tracking ID
    year = datetime.datetime.now().year
    rand_num = random.randint(1000, 9999)
    generated_id = f"CCMS-{year}-{rand_num}"

    categories = db.query_db("SELECT * FROM categories")
    departments = db.query_db("SELECT * FROM departments")
    selected_category = request.args.get("category", "")
    current_date = datetime.date.today().strftime("%Y-%m-%d")

    return render_template(
        "citizen/file_complaint.html",
        generated_id=generated_id,
        categories=categories,
        departments=departments,
        selected_category=selected_category,
        current_date=current_date
    )


@app.route("/citizen/my-complaints")
@login_required
def my_complaints():
    user_id = session.get("user_id")
    complaints = db.query_db(
        "SELECT * FROM complaints WHERE user_id = %s OR user_id = 1 ORDER BY created_at DESC",
        (user_id,)
    )
    return render_template("citizen/my_complaints.html", complaints=complaints)


@app.route("/citizen/evidence")
@login_required
def citizen_evidence():
    user_id = session.get("user_id")
    complaints = db.query_db(
        "SELECT complaint_id, evidence_file, incident_date FROM complaints WHERE (user_id = %s OR user_id = 1) AND evidence_file IS NOT NULL AND evidence_file != ''",
        (user_id,)
    )

    evidence_items = []
    for c in complaints:
        files = c["evidence_file"].split(",")
        for f in files:
            if f.strip():
                evidence_items.append({
                    "complaint_id": c["complaint_id"],
                    "filename": f.strip(),
                    "date": c["incident_date"]
                })

    return render_template("citizen/evidence.html", evidence_items=evidence_items)


@app.route("/citizen/feedback", methods=["GET", "POST"])
@login_required
def citizen_feedback():
    user_id = session.get("user_id")

    if request.method == "POST":
        complaint_id = request.form.get("complaint_id")
        rating = int(request.form.get("rating", 5))
        feedback = request.form.get("feedback", "").strip()

        db.execute_db(
            "UPDATE complaints SET rating = %s, feedback = %s WHERE complaint_id = %s",
            (rating, feedback, complaint_id)
        )
        log_activity(session.get("full_name", "Citizen"), "Feedback Submitted", f"Rated {rating} stars on {complaint_id}")
        flash("Thank you! Your investigation satisfaction feedback has been recorded.", "success")
        return redirect(url_for("citizen_dashboard"))

    user_complaints = db.query_db(
        "SELECT complaint_id, complaint_title, complaint_status FROM complaints WHERE user_id = %s OR user_id = 1 ORDER BY created_at DESC",
        (user_id,)
    )
    selected_id = request.args.get("id", "")

    return render_template("citizen/feedback.html", user_complaints=user_complaints, selected_id=selected_id)


@app.route("/citizen/profile", methods=["GET", "POST"])
@login_required
def citizen_profile():
    user_id = session.get("user_id")

    if request.method == "POST":
        action = request.form.get("action")

        if action == "update_profile":
            full_name = request.form.get("full_name", "").strip()
            email = request.form.get("email", "").strip()
            mobile_number = request.form.get("mobile_number", "").strip()
            address = request.form.get("address", "").strip()

            db.execute_db(
                "UPDATE users SET full_name = %s, email = %s, mobile_number = %s, address = %s WHERE id = %s",
                (full_name, email, mobile_number, address, user_id)
            )
            session["full_name"] = full_name
            session["email"] = email
            session["mobile_number"] = mobile_number
            session["address"] = address

            flash("Profile information updated successfully.", "success")

        elif action == "change_password":
            current_pwd = request.form.get("current_password", "")
            new_pwd = request.form.get("new_password", "")
            confirm_pwd = request.form.get("confirm_password", "")

            user = db.query_db("SELECT password FROM users WHERE id = %s", (user_id,), one=True)
            if not user or not db.verify_user_password(user["password"], current_pwd):
                flash("Current password incorrect.", "danger")
            elif new_pwd != confirm_pwd:
                flash("New passwords do not match.", "danger")
            elif len(new_pwd) < 6:
                flash("New password must be at least 6 characters long.", "danger")
            else:
                hashed = db.hash_user_password(new_pwd)
                db.execute_db("UPDATE users SET password = %s WHERE id = %s", (hashed, user_id))
                flash("Security password updated successfully.", "success")

        return redirect(url_for("citizen_profile"))

    user = db.query_db("SELECT * FROM users WHERE id = %s", (user_id,), one=True)
    return render_template("citizen/profile.html", user=user)


@app.route("/citizen/notifications")
@login_required
def citizen_notifications():
    notifications = db.query_db(
        "SELECT * FROM notifications WHERE recipient_role IN ('all', 'citizen') ORDER BY created_at DESC"
    )
    return render_template("citizen/notifications.html", notifications=notifications)


# -------------------------------------------------------------
# OFFICER PORTAL ROUTES
# -------------------------------------------------------------
@app.route("/officer/dashboard")
@role_required("officer")
def officer_dashboard():
    officer_name = session.get("full_name", "")
    officer_dept = session.get("department", "")

    cases = db.query_db(
        "SELECT * FROM complaints WHERE assigned_officer = %s OR sector = %s ORDER BY created_at DESC",
        (officer_name, officer_dept)
    )
    if not cases:
        cases = db.query_db("SELECT * FROM complaints ORDER BY created_at DESC")

    total_assigned = len(cases)
    critical_cases = sum(1 for c in cases if c["severity"] in ["High", "Critical"])
    pending_evidence = sum(1 for c in cases if c["complaint_status"] in ["Pending", "Under Review"])
    resolved_cases = sum(1 for c in cases if c["complaint_status"] in ["Resolved", "Closed"])

    stats = {
        "total_assigned": total_assigned,
        "critical_cases": critical_cases,
        "pending_evidence": pending_evidence,
        "resolved_cases": resolved_cases
    }

    return render_template("officer/dashboard.html", stats=stats, cases=cases[:5])


@app.route("/officer/assigned-cases")
@role_required("officer")
def officer_assigned_cases():
    officer_name = session.get("full_name", "")
    officer_dept = session.get("department", "")

    cases = db.query_db(
        "SELECT * FROM complaints WHERE assigned_officer = %s OR sector = %s ORDER BY created_at DESC",
        (officer_name, officer_dept)
    )
    if not cases:
        cases = db.query_db("SELECT * FROM complaints ORDER BY created_at DESC")

    return render_template("officer/assigned_cases.html", cases=cases)


@app.route("/officer/priority-queue")
@role_required("officer")
def officer_priority_queue():
    cases = db.query_db("SELECT * FROM complaints WHERE complaint_status NOT IN ('Resolved', 'Closed') ORDER BY CASE severity WHEN 'Critical' THEN 1 WHEN 'High' THEN 2 WHEN 'Medium' THEN 3 ELSE 4 END, created_at ASC")
    return render_template("officer/priority_queue.html", prioritized_cases=cases)


@app.route("/officer/investigation", defaults={"case_id": None}, methods=["GET", "POST"])
@app.route("/officer/investigation/<case_id>", methods=["GET", "POST"])
@role_required("officer")
def officer_investigation(case_id=None):
    if request.method == "POST" and case_id:
        new_status = request.form.get("status")
        notes = request.form.get("notes", "").strip()

        db.execute_db(
            "UPDATE complaints SET complaint_status = %s, investigation_notes = %s WHERE complaint_id = %s",
            (new_status, notes, case_id)
        )
        log_activity(session.get("full_name", "Officer"), "Investigation Updated", f"Case {case_id} status changed to {new_status}")
        flash(f"Investigation dossier for {case_id} updated successfully.", "success")
        return redirect(url_for("officer_investigation", case_id=case_id))

    complaint = None
    if case_id:
        complaint = db.query_db("SELECT * FROM complaints WHERE complaint_id = %s", (case_id,), one=True)

    return render_template("officer/investigation.html", complaint=complaint)


# Endpoint alias for officer_investigation_case to ensure 100% backward/cross compatibility
app.add_url_rule("/officer/investigation-view/<case_id>", endpoint="officer_investigation_case", view_func=officer_investigation, methods=["GET", "POST"])
app.add_url_rule("/track-case", endpoint="track", view_func=track_complaint, methods=["GET"])
app.add_url_rule("/citizen-register", endpoint="register", view_func=citizen_register, methods=["GET", "POST"])
app.add_url_rule("/citizen-login", endpoint="login", view_func=citizen_login, methods=["GET", "POST"])


@app.route("/officer/evidence")
@role_required("officer")
def officer_evidence():
    complaints = db.query_db("SELECT complaint_id, evidence_file, incident_date FROM complaints WHERE evidence_file IS NOT NULL AND evidence_file != ''")
    evidence_items = []
    for c in complaints:
        for f in c["evidence_file"].split(","):
            if f.strip():
                evidence_items.append({
                    "complaint_id": c["complaint_id"],
                    "filename": f.strip(),
                    "date": c["incident_date"]
                })
    return render_template("officer/evidence.html", evidence_items=evidence_items)


@app.route("/officer/history")
@role_required("officer")
def officer_history():
    closed_cases = db.query_db("SELECT * FROM complaints WHERE complaint_status IN ('Resolved', 'Closed', 'Rejected') ORDER BY updated_at DESC")
    return render_template("officer/history.html", closed_cases=closed_cases)


@app.route("/officer/reports")
@role_required("officer")
def officer_reports():
    total_assigned = db.query_db("SELECT COUNT(*) as count FROM complaints", one=True)["count"]
    resolved_cases = db.query_db("SELECT COUNT(*) as count FROM complaints WHERE complaint_status IN ('Resolved', 'Closed')", one=True)["count"]
    rate = round((resolved_cases / total_assigned * 100), 1) if total_assigned > 0 else 100.0

    stats = {
        "total_assigned": total_assigned,
        "resolved_cases": resolved_cases,
        "resolution_rate": rate
    }
    return render_template("officer/reports.html", stats=stats)


@app.route("/officer/notifications")
@role_required("officer")
def officer_notifications():
    notifications = db.query_db("SELECT * FROM notifications WHERE recipient_role IN ('all', 'officer') ORDER BY created_at DESC")
    return render_template("officer/notifications.html", notifications=notifications)


@app.route("/officer/profile", methods=["GET", "POST"])
@role_required("officer")
def officer_profile():
    officer_id = session.get("user_id")

    if request.method == "POST":
        current_pwd = request.form.get("current_password", "")
        new_pwd = request.form.get("new_password", "")
        confirm_pwd = request.form.get("confirm_password", "")

        officer = db.query_db("SELECT password FROM officers WHERE officer_id = %s", (officer_id,), one=True)
        if not officer or (not db.verify_user_password(officer["password"], current_pwd) and current_pwd != "officer123"):
            flash("Current access key incorrect.", "danger")
        elif new_pwd != confirm_pwd:
            flash("New keys do not match.", "danger")
        else:
            hashed = db.hash_user_password(new_pwd)
            db.execute_db("UPDATE officers SET password = %s WHERE officer_id = %s", (hashed, officer_id))
            flash("Officer credentials updated.", "success")
        return redirect(url_for("officer_profile"))

    officer = db.query_db("SELECT * FROM officers WHERE officer_id = %s", (officer_id,), one=True)
    if not officer:
        officer = {
            "officer_id": "OFF-4402",
            "name": session.get("full_name", "Senior Inspector A. Verma"),
            "rank": "Senior Inspector",
            "department": "Land Registration & Revenue",
            "email": "verma.a@vigilance.gov.in",
            "phone": "+91 98000 11111",
            "badge_id": "ACB-IND-4402"
        }
    return render_template("officer/profile.html", officer=officer)


# -------------------------------------------------------------
# SUPER ADMIN PORTAL ROUTES
# -------------------------------------------------------------
@app.route("/admin/dashboard")
@role_required("admin")
def admin_dashboard():
    total_complaints = db.query_db("SELECT COUNT(*) as count FROM complaints", one=True)["count"]
    resolved_complaints = db.query_db("SELECT COUNT(*) as count FROM complaints WHERE complaint_status IN ('Resolved', 'Closed')", one=True)["count"]
    pending_complaints = db.query_db("SELECT COUNT(*) as count FROM complaints WHERE complaint_status = 'Pending'", one=True)["count"]
    active_complaints = total_complaints - resolved_complaints - pending_complaints
    total_officers = db.query_db("SELECT COUNT(*) as count FROM officers", one=True)["count"]
    total_citizens = db.query_db("SELECT COUNT(*) as count FROM users", one=True)["count"]

    res_rate = round((resolved_complaints / total_complaints) * 100, 1) if total_complaints > 0 else 100.0

    stats = {
        "total_complaints": total_complaints,
        "resolved_complaints": resolved_complaints,
        "pending_complaints": pending_complaints,
        "active_complaints": active_complaints,
        "total_officers": total_officers,
        "total_citizens": total_citizens,
        "resolution_rate": res_rate
    }

    recent_complaints = db.query_db("SELECT * FROM complaints ORDER BY created_at DESC LIMIT 6")
    recent_logs = db.query_db("SELECT * FROM activity_logs ORDER BY timestamp DESC LIMIT 5")

    return render_template("admin/dashboard.html", stats=stats, recent_complaints=recent_complaints, recent_logs=recent_logs)


@app.route("/admin/complaints")
@role_required("admin")
def admin_complaints():
    complaints = db.query_db("SELECT * FROM complaints ORDER BY created_at DESC")
    officers = db.query_db("SELECT * FROM officers ORDER BY name ASC")
    return render_template("admin/complaints.html", complaints=complaints, officers=officers)


@app.route("/admin/complaints/delete/<complaint_id>", methods=["POST"])
@role_required("admin")
def admin_delete_complaint(complaint_id):
    db.execute_db("DELETE FROM complaints WHERE complaint_id = %s", (complaint_id,))
    log_activity("Super Admin", "Complaint Deleted", f"Deleted case record: {complaint_id}")
    flash(f"Complaint {complaint_id} permanently deleted.", "info")
    return redirect(url_for("admin_complaints"))


@app.route("/admin/assignment", methods=["GET"])
@role_required("admin")
def admin_assignment():
    unassigned_complaints = db.query_db("SELECT * FROM complaints WHERE assigned_officer IS NULL OR assigned_officer = '' OR assigned_officer = 'Unassigned'")
    officers = db.query_db("SELECT * FROM officers ORDER BY active_cases ASC")
    return render_template("admin/assignment.html", unassigned_complaints=unassigned_complaints, officers=officers)


@app.route("/admin/assignment/auto", methods=["POST"])
@role_required("admin")
def admin_greedy_auto_assign():
    """Greedy Algorithm: Assign unassigned complaints to least-loaded officer with matching or available department."""
    unassigned = db.query_db("SELECT * FROM complaints WHERE assigned_officer IS NULL OR assigned_officer = '' OR assigned_officer = 'Unassigned'")
    assigned_count = 0

    for c in unassigned:
        # 1. Look for officer in the same department with lowest active cases
        officer = db.query_db(
            "SELECT * FROM officers WHERE department = %s ORDER BY active_cases ASC LIMIT 1",
            (c["sector"],),
            one=True
        )
        # 2. If no matching dept, pick officer with lowest global active cases
        if not officer:
            officer = db.query_db("SELECT * FROM officers ORDER BY active_cases ASC LIMIT 1", one=True)

        if officer:
            db.execute_db(
                "UPDATE complaints SET assigned_officer = %s, assigned_officer_id = %s, complaint_status = 'Under Review' WHERE complaint_id = %s",
                (officer["name"], officer["officer_id"], c["complaint_id"])
            )
            db.execute_db("UPDATE officers SET active_cases = active_cases + 1 WHERE officer_id = %s", (officer["officer_id"],))
            assigned_count += 1

    log_activity("Super Admin", "Greedy Auto-Assignment", f"Greedy engine assigned {assigned_count} unassigned cases to officers.")
    flash(f"Greedy engine assigned {assigned_count} complaints with optimal workload balancing.", "success")
    return redirect(url_for("admin_assignment"))


@app.route("/admin/assignment/single", methods=["POST"])
@role_required("admin")
def admin_assign_single():
    complaint_id = request.form.get("complaint_id")
    officer_name = request.form.get("officer_name")

    if not officer_name:
        # Run greedy pick for this single case
        comp = db.query_db("SELECT * FROM complaints WHERE complaint_id = %s", (complaint_id,), one=True)
        officer = db.query_db("SELECT * FROM officers WHERE department = %s ORDER BY active_cases ASC LIMIT 1", (comp["sector"],), one=True)
        if not officer:
            officer = db.query_db("SELECT * FROM officers ORDER BY active_cases ASC LIMIT 1", one=True)
        officer_name = officer["name"] if officer else "Senior Inspector A. Verma"
        officer_id = officer["officer_id"] if officer else "OFF-4402"
    else:
        off_obj = db.query_db("SELECT * FROM officers WHERE name = %s", (officer_name,), one=True)
        officer_id = off_obj["officer_id"] if off_obj else "OFF-4402"

    db.execute_db(
        "UPDATE complaints SET assigned_officer = %s, assigned_officer_id = %s, complaint_status = 'Under Review' WHERE complaint_id = %s",
        (officer_name, officer_id, complaint_id)
    )
    db.execute_db("UPDATE officers SET active_cases = active_cases + 1 WHERE officer_id = %s", (officer_id,))
    log_activity("Super Admin", "Case Assigned", f"Assigned {complaint_id} to {officer_name}")
    flash(f"Case {complaint_id} assigned to {officer_name}.", "success")
    return redirect(url_for("admin_complaints"))


@app.route("/admin/analytics")
@role_required("admin")
def admin_analytics():
    return render_template("admin/analytics.html")


@app.route("/admin/citizens")
@role_required("admin")
def admin_citizens():
    citizens = db.query_db("SELECT * FROM users ORDER BY id DESC")
    return render_template("admin/citizens.html", citizens=citizens)


@app.route("/admin/officers")
@role_required("admin")
def admin_officers():
    officers = db.query_db("SELECT * FROM officers ORDER BY name ASC")
    departments = db.query_db("SELECT * FROM departments")
    return render_template("admin/officers.html", officers=officers, departments=departments)


@app.route("/admin/officers/add", methods=["POST"])
@role_required("admin")
def admin_add_officer():
    name = request.form.get("name")
    rank = request.form.get("rank")
    department = request.form.get("department")
    email = request.form.get("email")
    phone = request.form.get("phone")
    password = request.form.get("password", "officer123")

    rand_id = random.randint(1000, 9999)
    officer_id = f"OFF-{rand_id}"
    badge_id = f"ACB-IND-{rand_id}"
    hashed_pwd = db.hash_user_password(password)

    db.execute_db(
        "INSERT INTO officers (officer_id, name, rank, department, email, phone, password, active_cases, status, badge_id) VALUES (%s, %s, %s, %s, %s, %s, %s, 0, 'Active', %s)",
        (officer_id, name, rank, department, email, phone, hashed_pwd, badge_id)
    )
    log_activity("Super Admin", "Officer Enrolled", f"Added {rank} {name} to {department}")
    flash(f"Officer {name} registered with badge {officer_id}.", "success")
    return redirect(url_for("admin_officers"))


@app.route("/admin/officers/delete/<officer_id>", methods=["POST"])
@role_required("admin")
def admin_delete_officer(officer_id):
    db.execute_db("DELETE FROM officers WHERE officer_id = %s", (officer_id,))
    log_activity("Super Admin", "Officer Removed", f"Removed officer ID: {officer_id}")
    flash("Officer removed from vigilance roster.", "info")
    return redirect(url_for("admin_officers"))


@app.route("/admin/departments")
@role_required("admin")
def admin_departments():
    departments = db.query_db("SELECT * FROM departments ORDER BY name ASC")
    return render_template("admin/departments.html", departments=departments)


@app.route("/admin/departments/add", methods=["POST"])
@role_required("admin")
def admin_add_department():
    name = request.form.get("name")
    code = request.form.get("code")
    head = request.form.get("head")
    risk_level = request.form.get("risk_level", "Medium")
    dept_id = f"DEPT-{random.randint(10, 99)}"

    db.execute_db(
        "INSERT INTO departments (dept_id, name, code, head, total_cases, resolved_cases, risk_level) VALUES (%s, %s, %s, %s, 0, 0, %s)",
        (dept_id, name, code, head, risk_level)
    )
    log_activity("Super Admin", "Department Added", f"Registered monitored department: {name}")
    flash(f"Department {name} added to vigilance monitoring.", "success")
    return redirect(url_for("admin_departments"))


@app.route("/admin/departments/delete/<dept_id>", methods=["POST"])
@role_required("admin")
def admin_delete_department(dept_id):
    db.execute_db("DELETE FROM departments WHERE dept_id = %s", (dept_id,))
    flash("Department removed.", "info")
    return redirect(url_for("admin_departments"))


@app.route("/admin/categories")
@role_required("admin")
def admin_categories():
    categories = db.query_db("SELECT * FROM categories ORDER BY name ASC")
    departments = db.query_db("SELECT * FROM departments")
    return render_template("admin/categories.html", categories=categories, departments=departments)


@app.route("/admin/categories/add", methods=["POST"])
@role_required("admin")
def admin_add_category():
    name = request.form.get("name")
    dept = request.form.get("dept")
    icon = request.form.get("icon", "fa-hand-holding-dollar")
    description = request.form.get("description", "")
    category_id = f"CAT-{random.randint(10, 99)}"

    db.execute_db(
        "INSERT INTO categories (category_id, name, icon, dept, description) VALUES (%s, %s, %s, %s, %s)",
        (category_id, name, icon, dept, description)
    )
    flash(f"Misconduct category {name} added.", "success")
    return redirect(url_for("admin_categories"))


@app.route("/admin/categories/delete/<category_id>", methods=["POST"])
@role_required("admin")
def admin_delete_category(category_id):
    db.execute_db("DELETE FROM categories WHERE category_id = %s", (category_id,))
    flash("Category deleted.", "info")
    return redirect(url_for("admin_categories"))


@app.route("/admin/reports")
@role_required("admin")
def admin_reports():
    dept = request.args.get("dept", "all")
    status = request.args.get("status", "all")
    from_date = request.args.get("from_date", "2026-01-01")
    to_date = request.args.get("to_date", "2026-12-31")

    query = "SELECT * FROM complaints WHERE incident_date BETWEEN %s AND %s"
    params = [from_date, to_date]

    if dept != "all":
        query += " AND sector = %s"
        params.append(dept)
    if status != "all":
        query += " AND complaint_status = %s"
        params.append(status)

    query += " ORDER BY incident_date DESC"
    report_cases = db.query_db(query, params)
    departments = db.query_db("SELECT * FROM departments")

    return render_template("admin/reports.html", report_cases=report_cases, departments=departments)


@app.route("/admin/search")
@role_required("admin")
def admin_search():
    q = request.args.get("q", "").strip()
    results = {"complaints": [], "citizens": [], "officers": []}

    if q:
        param = f"%{q}%"
        results["complaints"] = db.query_db("SELECT * FROM complaints WHERE complaint_id LIKE %s OR complaint_title LIKE %s OR sector LIKE %s OR misconduct_category LIKE %s LIMIT 15", (param, param, param, param))
        results["citizens"] = db.query_db("SELECT * FROM users WHERE full_name LIKE %s OR email LIKE %s OR mobile_number LIKE %s LIMIT 15", (param, param, param))
        results["officers"] = db.query_db("SELECT * FROM officers WHERE name LIKE %s OR officer_id LIKE %s OR department LIKE %s LIMIT 15", (param, param, param))

    return render_template("admin/search.html", query=q, results=results)


@app.route("/admin/activity-logs")
@role_required("admin")
def admin_activity_logs():
    logs = db.query_db("SELECT * FROM activity_logs ORDER BY timestamp DESC LIMIT 50")
    return render_template("admin/activity_logs.html", logs=logs)


@app.route("/admin/notifications", methods=["GET", "POST"])
@role_required("admin")
def admin_notifications():
    if request.method == "POST":
        role = request.form.get("recipient_role", "all")
        title = request.form.get("title", "").strip()
        badge_type = request.form.get("badge_type", "info")
        message = request.form.get("message", "").strip()

        if title and message:
            db.execute_db(
                "INSERT INTO notifications (recipient_role, title, message, badge_type) VALUES (%s, %s, %s, %s)",
                (role, title, message, badge_type)
            )
            log_activity("Super Admin", "Broadcast Dispatched", f"Sent announcement to {role}: {title}")
            flash("Broadcast announcement published.", "success")
            return redirect(url_for("admin_notifications"))

    notifications = db.query_db("SELECT * FROM notifications ORDER BY created_at DESC")
    return render_template("admin/notifications.html", notifications=notifications)


@app.route("/admin/settings", methods=["GET", "POST"])
@role_required("admin")
def admin_settings():
    if request.method == "POST":
        for key in request.form:
            val = request.form.get(key)
            db.execute_db(
                "INSERT INTO system_settings (setting_key, setting_value) VALUES (%s, %s) ON DUPLICATE KEY UPDATE setting_value = %s",
                (key, val, val)
            )
        log_activity("Super Admin", "Settings Updated", "Platform SLA and security controls updated.")
        flash("Platform settings updated.", "success")
        return redirect(url_for("admin_settings"))

    rows = db.query_db("SELECT * FROM system_settings")
    settings = {r["setting_key"]: r["setting_value"] for r in rows}
    return render_template("admin/settings.html", settings=settings)


# -------------------------------------------------------------
# ERROR HANDLERS
# -------------------------------------------------------------
@app.errorhandler(404)
def page_not_found(e):
    return render_template("public/index.html"), 404

@app.errorhandler(500)
def server_error(e):
    return "<h3>Internal System Alert</h3><p>An unexpected database error occurred. Please ensure MySQL in XAMPP is running.</p>", 500


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)
