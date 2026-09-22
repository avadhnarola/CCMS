"""
CCMS Database & Static Data Layer
=================================
Provides a self-contained, zero-dependency SQLite/in-memory data layer initialized
with rich static datasets from static_data.py.
Eliminates all requirements for external MySQL servers and PHP backend.
"""
import os
import sqlite3
import re
from werkzeug.security import generate_password_hash, check_password_hash
import static_data

DB_PATH = os.path.join(os.path.dirname(os.path.abspath(__file__)), "ccms_local.db")


def dict_factory(cursor, row):
    """Convert SQLite row tuples to dictionaries matching MySQL DictCursor behavior."""
    d = {}
    for idx, col in enumerate(cursor.description):
        d[col[0]] = row[idx]
    return d


def get_db_connection():
    """Create and return a SQLite connection with dictionary row factory."""
    conn = sqlite3.connect(DB_PATH, timeout=20.0, check_same_thread=False)
    conn.row_factory = dict_factory
    # Enable foreign keys and WAL mode for better concurrency
    conn.execute("PRAGMA journal_mode=WAL;")
    return conn


def _normalize_query(query, args):
    """
    Normalizes MySQL-style queries to SQLite syntax:
    1. Converts '%s' parameter placeholders to '?'
    2. Converts 'ON DUPLICATE KEY UPDATE setting_value = %s' to SQLite syntax
    """
    # Fix ON DUPLICATE KEY UPDATE for system_settings
    if "ON DUPLICATE KEY UPDATE" in query.upper() and "system_settings" in query.lower():
        query = "INSERT OR REPLACE INTO system_settings (setting_key, setting_value) VALUES (?, ?)"
        # If args had 3 items (key, val, val), trim to 2
        if len(args) == 3:
            args = (args[0], args[1])
        return query, args

    # Convert %s placeholders to ?
    normalized_query = query.replace("%s", "?")
    return normalized_query, args


def query_db(query, args=(), one=False):
    """Execute a SELECT query and return all or one row dictionary."""
    normalized_query, normalized_args = _normalize_query(query, args)
    conn = get_db_connection()
    try:
        cursor = conn.cursor()
        cursor.execute(normalized_query, normalized_args)
        result = cursor.fetchall()
        return (result[0] if result else None) if one else result
    finally:
        conn.close()


def execute_db(query, args=()):
    """Execute an INSERT, UPDATE, or DELETE query and return the last row ID or affected row count."""
    normalized_query, normalized_args = _normalize_query(query, args)
    conn = get_db_connection()
    try:
        cursor = conn.cursor()
        cursor.execute(normalized_query, normalized_args)
        conn.commit()
        return cursor.lastrowid if cursor.lastrowid is not None else cursor.rowcount
    finally:
        conn.close()


def verify_user_password(stored_hash, plain_password):
    """Verify password supporting Werkzeug hashes, PHP bcrypt hashes ($2y$), and plain text fallback."""
    if not stored_hash or not plain_password:
        return False

    # 1. Plain text comparison (for quick testing/legacy test entries)
    if stored_hash == plain_password:
        return True

    # 2. Werkzeug check_password_hash
    try:
        if check_password_hash(stored_hash, plain_password):
            return True
    except Exception:
        pass

    # 3. PHP bcrypt ($2y$ or $2b$) fallback check
    if stored_hash.startswith("$2y$") or stored_hash.startswith("$2a$") or stored_hash.startswith("$2b$"):
        try:
            import bcrypt  # type: ignore
            compat_hash = stored_hash
            if compat_hash.startswith("$2y$"):
                compat_hash = "$2b$" + compat_hash[4:]
            if bcrypt.checkpw(plain_password.encode("utf-8"), compat_hash.encode("utf-8")):
                return True
        except Exception:
            pass

    return False


def hash_user_password(plain_password):
    """Generate secure password hash using Werkzeug."""
    return generate_password_hash(plain_password)


def init_db(force_reseed=False):
    """
    Initialize SQLite tables and populate with rich static datasets from static_data.py.
    Runs automatically on startup with zero external database configuration.
    """
    conn = get_db_connection()
    try:
        cur = conn.cursor()

        # 1. Users Table
        cur.execute("""
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            full_name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            mobile_number TEXT NOT NULL UNIQUE,
            address TEXT,
            password TEXT NOT NULL,
            email_verified INTEGER DEFAULT 1,
            role TEXT DEFAULT 'citizen',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        """)

        # 2. Complaints Table
        cur.execute("""
        CREATE TABLE IF NOT EXISTS complaints (
            complaint_id TEXT PRIMARY KEY,
            user_id INTEGER NOT NULL,
            complaint_title TEXT NOT NULL,
            misconduct_category TEXT NOT NULL,
            sector TEXT NOT NULL,
            incident_date TEXT NOT NULL,
            incident_time TEXT,
            location TEXT NOT NULL,
            description TEXT NOT NULL,
            anonymous_mode INTEGER DEFAULT 0,
            severity TEXT DEFAULT 'Medium',
            evidence_file TEXT,
            complaint_status TEXT DEFAULT 'Pending',
            assigned_officer TEXT,
            assigned_officer_id TEXT,
            investigation_notes TEXT,
            rating INTEGER,
            feedback TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        """)

        # 3. Contact Messages Table
        cur.execute("""
        CREATE TABLE IF NOT EXISTS contact_messages (
            contact_id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            subject TEXT,
            message TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            is_read INTEGER DEFAULT 0
        );
        """)

        # 4. Officers Table
        cur.execute("""
        CREATE TABLE IF NOT EXISTS officers (
            officer_id TEXT PRIMARY KEY,
            name TEXT NOT NULL,
            rank TEXT NOT NULL,
            department TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            phone TEXT NOT NULL,
            password TEXT NOT NULL,
            active_cases INTEGER DEFAULT 0,
            status TEXT DEFAULT 'Active',
            badge_id TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        """)

        # 5. Departments Table
        cur.execute("""
        CREATE TABLE IF NOT EXISTS departments (
            dept_id TEXT PRIMARY KEY,
            name TEXT NOT NULL,
            code TEXT NOT NULL,
            head TEXT NOT NULL,
            total_cases INTEGER DEFAULT 0,
            resolved_cases INTEGER DEFAULT 0,
            risk_level TEXT DEFAULT 'Medium',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        """)

        # 6. Categories Table
        cur.execute("""
        CREATE TABLE IF NOT EXISTS categories (
            category_id TEXT PRIMARY KEY,
            name TEXT NOT NULL,
            icon TEXT DEFAULT 'fa-hand-holding-dollar',
            dept TEXT NOT NULL,
            description TEXT
        );
        """)

        # 7. Activity Logs Table
        cur.execute("""
        CREATE TABLE IF NOT EXISTS activity_logs (
            log_id INTEGER PRIMARY KEY AUTOINCREMENT,
            actor TEXT NOT NULL,
            action TEXT NOT NULL,
            details TEXT NOT NULL,
            ip_address TEXT DEFAULT '127.0.0.1',
            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        """)

        # 8. Notifications Table
        cur.execute("""
        CREATE TABLE IF NOT EXISTS notifications (
            notification_id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            recipient_role TEXT DEFAULT 'all',
            title TEXT NOT NULL,
            message TEXT NOT NULL,
            badge_type TEXT DEFAULT 'info',
            is_read INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        """)

        # 9. System Settings Table
        cur.execute("""
        CREATE TABLE IF NOT EXISTS system_settings (
            setting_key TEXT PRIMARY KEY,
            setting_value TEXT NOT NULL
        );
        """)

        conn.commit()

        # Seed Users
        cur.execute("SELECT COUNT(*) as count FROM users;")
        if force_reseed or cur.fetchone()["count"] == 0:
            for u in static_data.STATIC_USERS:
                cur.execute(
                    "INSERT OR IGNORE INTO users (id, full_name, email, mobile_number, address, password, email_verified, role, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                    (u["id"], u["full_name"], u["email"], u["mobile_number"], u["address"], u["password"], u["email_verified"], u["role"], u["created_at"])
                )

        # Seed Departments
        cur.execute("SELECT COUNT(*) as count FROM departments;")
        if force_reseed or cur.fetchone()["count"] == 0:
            for d in static_data.STATIC_DEPARTMENTS:
                cur.execute(
                    "INSERT OR IGNORE INTO departments (dept_id, name, code, head, total_cases, resolved_cases, risk_level) VALUES (?, ?, ?, ?, ?, ?, ?)",
                    (d["dept_id"], d["name"], d["code"], d["head"], d["total_cases"], d["resolved_cases"], d["risk_level"])
                )

        # Seed Categories
        cur.execute("SELECT COUNT(*) as count FROM categories;")
        if force_reseed or cur.fetchone()["count"] == 0:
            for c in static_data.STATIC_CATEGORIES:
                cur.execute(
                    "INSERT OR IGNORE INTO categories (category_id, name, icon, dept, description) VALUES (?, ?, ?, ?, ?)",
                    (c["category_id"], c["name"], c["icon"], c["dept"], c["description"])
                )

        # Seed Officers
        cur.execute("SELECT COUNT(*) as count FROM officers;")
        if force_reseed or cur.fetchone()["count"] == 0:
            for o in static_data.STATIC_OFFICERS:
                cur.execute(
                    "INSERT OR IGNORE INTO officers (officer_id, name, rank, department, email, phone, password, active_cases, status, badge_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                    (o["officer_id"], o["name"], o["rank"], o["department"], o["email"], o["phone"], o["password"], o["active_cases"], o["status"], o["badge_id"])
                )

        # Seed Complaints
        cur.execute("SELECT COUNT(*) as count FROM complaints;")
        if force_reseed or cur.fetchone()["count"] == 0:
            for cp in static_data.STATIC_COMPLAINTS:
                cur.execute(
                    """INSERT OR IGNORE INTO complaints 
                    (complaint_id, user_id, complaint_title, misconduct_category, sector, incident_date, incident_time, location, description, anonymous_mode, severity, evidence_file, complaint_status, assigned_officer, assigned_officer_id, investigation_notes, rating, feedback, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)""",
                    (cp["complaint_id"], cp["user_id"], cp["complaint_title"], cp["misconduct_category"], cp["sector"], cp["incident_date"], cp["incident_time"], cp["location"], cp["description"], cp["anonymous_mode"], cp["severity"], cp["evidence_file"], cp["complaint_status"], cp["assigned_officer"], cp["assigned_officer_id"], cp["investigation_notes"], cp["rating"], cp["feedback"], cp["created_at"])
                )

        # Seed Activity Logs
        cur.execute("SELECT COUNT(*) as count FROM activity_logs;")
        if force_reseed or cur.fetchone()["count"] == 0:
            for l in static_data.STATIC_ACTIVITY_LOGS:
                cur.execute(
                    "INSERT INTO activity_logs (actor, action, details, ip_address, timestamp) VALUES (?, ?, ?, ?, ?)",
                    (l["actor"], l["action"], l["details"], l["ip_address"], l["timestamp"])
                )

        # Seed Notifications
        cur.execute("SELECT COUNT(*) as count FROM notifications;")
        if force_reseed or cur.fetchone()["count"] == 0:
            for n in static_data.STATIC_NOTIFICATIONS:
                cur.execute(
                    "INSERT INTO notifications (user_id, recipient_role, title, message, badge_type, is_read, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)",
                    (n["user_id"], n["recipient_role"], n["title"], n["message"], n["badge_type"], n["is_read"], n["created_at"])
                )

        # Seed System Settings
        cur.execute("SELECT COUNT(*) as count FROM system_settings;")
        if force_reseed or cur.fetchone()["count"] == 0:
            for s in static_data.STATIC_SYSTEM_SETTINGS:
                cur.execute(
                    "INSERT OR REPLACE INTO system_settings (setting_key, setting_value) VALUES (?, ?)",
                    (s["setting_key"], s["setting_value"])
                )

        conn.commit()
    finally:
        conn.close()


if __name__ == "__main__":
    init_db(force_reseed=True)
    print("Self-contained CCMS SQLite database initialized successfully with static data!")
