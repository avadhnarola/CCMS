import os
import pymysql
import pymysql.cursors
from dotenv import load_dotenv
from werkzeug.security import generate_password_hash, check_password_hash

load_dotenv()

MYSQL_HOST = os.getenv("MYSQL_HOST", "127.0.0.1")
MYSQL_PORT = int(os.getenv("MYSQL_PORT", 3306))
MYSQL_USER = os.getenv("MYSQL_USER", "root")
MYSQL_PASSWORD = os.getenv("MYSQL_PASSWORD", "")
MYSQL_DATABASE = os.getenv("MYSQL_DATABASE", "ccms")

def get_db_connection():
    """Create and return a MySQL connection with dictionary cursor."""
    return pymysql.connect(
        host=MYSQL_HOST,
        port=MYSQL_PORT,
        user=MYSQL_USER,
        password=MYSQL_PASSWORD,
        database=MYSQL_DATABASE,
        cursorclass=pymysql.cursors.DictCursor,
        autocommit=True,
        charset='utf8mb4'
    )

def query_db(query, args=(), one=False):
    """Execute a SELECT query and return all or one row."""
    conn = get_db_connection()
    try:
        with conn.cursor() as cursor:
            cursor.execute(query, args)
            result = cursor.fetchall()
            return (result[0] if result else None) if one else result
    finally:
        conn.close()

def execute_db(query, args=()):
    """Execute an INSERT, UPDATE, or DELETE query and return the last row ID or affected rows."""
    conn = get_db_connection()
    try:
        with conn.cursor() as cursor:
            cursor.execute(query, args)
            conn.commit()
            return cursor.lastrowid
    finally:
        conn.close()

def verify_user_password(stored_hash, plain_password):
    """Verify password supporting Werkzeug hashes, PHP bcrypt hashes ($2y$), and plain text fallback."""
    if not stored_hash or not plain_password:
        return False
    
    # 1. Plain text comparison (for initial testing/legacy test entries)
    if stored_hash == plain_password:
        return True
        
    # 2. Werkzeug check_password_hash
    try:
        if check_password_hash(stored_hash, plain_password):
            return True
    except Exception:
        pass

    # 3. PHP bcrypt ($2y$ or $2b$) check
    if stored_hash.startswith("$2y$") or stored_hash.startswith("$2a$") or stored_hash.startswith("$2b$"):
        try:
            import bcrypt
            compat_hash = stored_hash
            if compat_hash.startswith("$2y$"):
                compat_hash = "$2b$" + compat_hash[4:]
            if bcrypt.checkpw(plain_password.encode('utf-8'), compat_hash.encode('utf-8')):
                return True
        except ImportError:
            pass
        except Exception:
            pass

    return False

def hash_user_password(plain_password):
    """Generate secure password hash using Werkzeug."""
    return generate_password_hash(plain_password)

def init_db():
    """Ensure all required tables and columns exist in the ccms MySQL database and seed initial data."""
    conn = get_db_connection()
    try:
        with conn.cursor() as cur:
            # Ensure users table exists with proper structure
            cur.execute("""
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                full_name VARCHAR(100) NOT NULL,
                email VARCHAR(150) NOT NULL UNIQUE,
                mobile_number VARCHAR(15) NOT NULL UNIQUE,
                address VARCHAR(255) NULL,
                password VARCHAR(255) NOT NULL,
                email_verified TINYINT(1) DEFAULT 1,
                role VARCHAR(20) DEFAULT 'citizen',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            """)

            # Ensure complaints table exists
            cur.execute("""
            CREATE TABLE IF NOT EXISTS complaints (
                complaint_id VARCHAR(30) PRIMARY KEY,
                user_id INT NOT NULL,
                complaint_title VARCHAR(255) NOT NULL,
                misconduct_category VARCHAR(100) NOT NULL,
                sector VARCHAR(100) NOT NULL,
                incident_date DATE NOT NULL,
                incident_time VARCHAR(20) NULL,
                location VARCHAR(255) NOT NULL,
                description TEXT NOT NULL,
                anonymous_mode TINYINT(1) DEFAULT 0,
                severity VARCHAR(50) DEFAULT 'Medium',
                evidence_file TEXT NULL,
                complaint_status VARCHAR(50) DEFAULT 'Pending',
                assigned_officer VARCHAR(150) NULL,
                assigned_officer_id VARCHAR(30) NULL,
                investigation_notes TEXT NULL,
                rating INT NULL,
                feedback TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            """)

            # Add any missing columns to complaints table if it was previously created with fewer columns
            try:
                cur.execute("ALTER TABLE complaints ADD COLUMN assigned_officer VARCHAR(150) NULL")
            except Exception:
                pass
            try:
                cur.execute("ALTER TABLE complaints ADD COLUMN assigned_officer_id VARCHAR(30) NULL")
            except Exception:
                pass
            try:
                cur.execute("ALTER TABLE complaints ADD COLUMN investigation_notes TEXT NULL")
            except Exception:
                pass
            try:
                cur.execute("ALTER TABLE complaints ADD COLUMN rating INT NULL")
            except Exception:
                pass
            try:
                cur.execute("ALTER TABLE complaints ADD COLUMN feedback TEXT NULL")
            except Exception:
                pass
            try:
                cur.execute("ALTER TABLE complaints ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP")
            except Exception:
                pass
            try:
                cur.execute("ALTER TABLE complaints ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP")
            except Exception:
                pass

            # Contact Messages table
            cur.execute("""
            CREATE TABLE IF NOT EXISTS contact_messages (
                contact_id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                subject VARCHAR(200) NULL,
                message TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                is_read TINYINT(1) DEFAULT 0
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            """)

            # Officers table
            cur.execute("""
            CREATE TABLE IF NOT EXISTS officers (
                officer_id VARCHAR(30) PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                rank VARCHAR(100) NOT NULL,
                department VARCHAR(100) NOT NULL,
                email VARCHAR(150) NOT NULL UNIQUE,
                phone VARCHAR(20) NOT NULL,
                password VARCHAR(255) NOT NULL,
                active_cases INT DEFAULT 0,
                status VARCHAR(20) DEFAULT 'Active',
                badge_id VARCHAR(50) NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            """)

            # Departments table
            cur.execute("""
            CREATE TABLE IF NOT EXISTS departments (
                dept_id VARCHAR(30) PRIMARY KEY,
                name VARCHAR(150) NOT NULL,
                code VARCHAR(20) NOT NULL,
                head VARCHAR(100) NOT NULL,
                total_cases INT DEFAULT 0,
                resolved_cases INT DEFAULT 0,
                risk_level VARCHAR(20) DEFAULT 'Medium',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            """)

            # Categories table
            cur.execute("""
            CREATE TABLE IF NOT EXISTS categories (
                category_id VARCHAR(30) PRIMARY KEY,
                name VARCHAR(150) NOT NULL,
                icon VARCHAR(50) DEFAULT 'fa-hand-holding-dollar',
                dept VARCHAR(100) NOT NULL,
                description VARCHAR(255) NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            """)

            # System Activity Logs table
            cur.execute("""
            CREATE TABLE IF NOT EXISTS activity_logs (
                log_id INT AUTO_INCREMENT PRIMARY KEY,
                actor VARCHAR(100) NOT NULL,
                action VARCHAR(100) NOT NULL,
                details TEXT NOT NULL,
                ip_address VARCHAR(50) DEFAULT '127.0.0.1',
                timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            """)

            # Notifications table
            cur.execute("""
            CREATE TABLE IF NOT EXISTS notifications (
                notification_id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NULL,
                recipient_role VARCHAR(30) DEFAULT 'all',
                title VARCHAR(200) NOT NULL,
                message TEXT NOT NULL,
                badge_type VARCHAR(30) DEFAULT 'info',
                is_read TINYINT(1) DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            """)

            # System Settings table
            cur.execute("""
            CREATE TABLE IF NOT EXISTS system_settings (
                setting_key VARCHAR(100) PRIMARY KEY,
                setting_value TEXT NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            """)

            # Seed default departments if empty
            cur.execute("SELECT COUNT(*) as count FROM departments")
            if cur.fetchone()['count'] == 0:
                departments_data = [
                    ("DEPT-01", "Police & Law Enforcement", "POL", "Comm. V. Rao", 42, 38, "High"),
                    ("DEPT-02", "Land Registration & Revenue", "REV", "Dir. K. Joshi", 65, 60, "Critical"),
                    ("DEPT-03", "Municipality & Public Works", "PWD", "Eng. R. Gupta", 51, 48, "High"),
                    ("DEPT-04", "Healthcare & Supplies", "HLT", "Dr. S. Nair", 29, 28, "Medium"),
                    ("DEPT-05", "Education & Grants", "EDU", "Prof. T. Sen", 34, 31, "Medium"),
                    ("DEPT-06", "Transport & Licensing", "TRN", "RTO P. Gill", 38, 35, "High")
                ]
                cur.executemany("INSERT INTO departments (dept_id, name, code, head, total_cases, resolved_cases, risk_level) VALUES (%s, %s, %s, %s, %s, %s, %s)", departments_data)

            # Seed default categories if empty
            cur.execute("SELECT COUNT(*) as count FROM categories")
            if cur.fetchone()['count'] == 0:
                categories_data = [
                    ("CAT-01", "Bribery & Cash Demand", "fa-hand-holding-dollar", "Land Registration & Revenue", "Direct or indirect solicitation of illegal gratification"),
                    ("CAT-02", "Land Scam & Title Fraud", "fa-building-shield", "Land Registration & Revenue", "Forged registration or unauthorized ownership transfer"),
                    ("CAT-03", "Road & Construction Scam", "fa-road", "Municipality & Public Works", "Substandard materials or fake contractor invoicing"),
                    ("CAT-04", "Police Misconduct & Extortion", "fa-shield-halved", "Police & Law Enforcement", "Illegal detention, coercion, or harassment"),
                    ("CAT-05", "Procurement & Tender Fraud", "fa-file-signature", "Municipality & Public Works", "Rigged public tenders and kickback contracts"),
                    ("CAT-06", "Medical Supply Embezzlement", "fa-hospital", "Healthcare & Supplies", "Diversion of subsidized medicines and hospital stock")
                ]
                cur.executemany("INSERT INTO categories (category_id, name, icon, dept, description) VALUES (%s, %s, %s, %s, %s)", categories_data)

            # Seed default officers if empty
            cur.execute("SELECT COUNT(*) as count FROM officers")
            if cur.fetchone()['count'] == 0:
                default_officer_pwd = generate_password_hash("officer123")
                officers_data = [
                    ("OFF-4402", "Senior Inspector A. Verma", "Senior Inspector", "Land Registration & Revenue", "verma.a@vigilance.gov.in", "+91 98000 11111", default_officer_pwd, 2, "Active", "ACB-IND-4402"),
                    ("OFF-5501", "Director S. Kulkarni", "Vigilance Director", "Municipality & Public Works", "kulkarni.s@vigilance.gov.in", "+91 98000 22222", default_officer_pwd, 1, "Active", "ACB-IND-5501"),
                    ("OFF-3309", "Inspector M. Sharma", "Inspector", "Land Registration & Revenue", "sharma.m@vigilance.gov.in", "+91 98000 33333", default_officer_pwd, 0, "Active", "ACB-IND-3309"),
                    ("OFF-7712", "Senior Inspector R. Deshmukh", "Senior Inspector", "Transport & Licensing", "deshmukh.r@vigilance.gov.in", "+91 98000 44444", default_officer_pwd, 1, "Active", "ACB-IND-7712"),
                    ("OFF-8823", "Inspector P. Mehta", "Inspector", "Healthcare & Supplies", "mehta.p@vigilance.gov.in", "+91 98000 55555", default_officer_pwd, 0, "Active", "ACB-IND-8823")
                ]
                cur.executemany("INSERT INTO officers (officer_id, name, rank, department, email, phone, password, active_cases, status, badge_id) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", officers_data)

            # Seed default activity logs if empty
            cur.execute("SELECT COUNT(*) as count FROM activity_logs")
            if cur.fetchone()['count'] == 0:
                logs_data = [
                    ("Super Admin", "Master System Boot", "CCMS Core System initialized with Zero-Knowledge Encryption.", "127.0.0.1"),
                    ("Super Admin", "Greedy Engine Ready", "Auto-assignment greedy dispatch engine synchronized with active vigilance officers.", "127.0.0.1"),
                    ("System", "Database Health Check", "All MySQL tables verified and indexed successfully.", "127.0.0.1")
                ]
                cur.executemany("INSERT INTO activity_logs (actor, action, details, ip_address) VALUES (%s, %s, %s, %s)", logs_data)

            # Seed default notifications if empty
            cur.execute("SELECT COUNT(*) as count FROM notifications")
            if cur.fetchone()['count'] == 0:
                notif_data = [
                    (None, "all", "System Security Update", "All whistleblower complaints are protected using AES-256 and IP addresses are automatically scrubbed.", "success"),
                    (None, "officer", "High Priority Queue Active", "Check your priority queue for cases with urgency scores exceeding 8.5/10.", "warning"),
                    (None, "citizen", "Fast Tracking Enabled", "You can now track your complaint status in real-time with full officer milestone timeline.", "info")
                ]
                cur.executemany("INSERT INTO notifications (user_id, recipient_role, title, message, badge_type) VALUES (%s, %s, %s, %s, %s)", notif_data)

            # Seed default settings if empty
            cur.execute("SELECT COUNT(*) as count FROM system_settings")
            if cur.fetchone()['count'] == 0:
                settings_data = [
                    ("site_name", "CCMS - Anti-Corruption & Vigilance Command System"),
                    ("contact_phone", "1800-11-CCMS (2267)"),
                    ("contact_email", "whistleblower@ccms.gov.in"),
                    ("encryption_protocol", "AES-256-GCM Military Grade"),
                    ("auto_assignment_mode", "Greedy Workload Optimization"),
                    ("sla_hours_high", "24"),
                    ("sla_hours_medium", "72"),
                    ("sla_hours_low", "168")
                ]
                cur.executemany("INSERT INTO system_settings (setting_key, setting_value) VALUES (%s, %s)", settings_data)

            conn.commit()
    finally:
        conn.close()

if __name__ == "__main__":
    init_db()
    print("Database initialized successfully!")
