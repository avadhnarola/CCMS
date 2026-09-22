"""
CCMS Static Datasets
====================
Provides pre-seeded static data records for the Corruption Complaint Management System.
Used for zero-dependency local operation without requiring an external MySQL/PHP backend.
"""
from werkzeug.security import generate_password_hash

# ==============================================================================
# 1. PHASE 1 STATIC DATASETS (Linear Structures)
# ==============================================================================

# Numeric values dataset (for searching, sorting, and benchmarking)
SAMPLE_NUMERIC_DATASET = [10, 25, 42, 55, 78, 99, 120, 150, 200]

# List of vigilance sectors
SAMPLE_SECTORS_DATASET = [
    "Bribery & Cash Demands",
    "Land Scam & Title Fraud",
    "Medical Supply Embezzlement",
    "Police Misconduct & Extortion",
    "Procurement & Tender Fraud",
    "Road & Construction Scam"
]

# Structured complaint records
SAMPLE_COMPLAINT_RECORDS = [
    {
        "id": "CCMS-2026-2237",
        "title": "Bribe Demand for Building Permit Approval",
        "sector": "Municipality & Public Works",
        "severity": "High",
        "status": "Under Investigation",
        "risk_score": 85,
        "timestamp": "2026-09-01 09:15"
    },
    {
        "id": "CCMS-2026-1024",
        "title": "Procurement Tender Bribery in Medical Supplies",
        "sector": "Healthcare & Supplies",
        "severity": "Critical",
        "status": "Pending Verification",
        "risk_score": 95,
        "timestamp": "2026-09-01 10:30"
    },
    {
        "id": "CCMS-2026-1038",
        "title": "Unauthorized Land Title Transfer Kickback",
        "sector": "Land Registration & Revenue",
        "severity": "Medium",
        "status": "Assigned",
        "risk_score": 60,
        "timestamp": "2026-09-01 11:45"
    },
    {
        "id": "CCMS-2026-1049",
        "title": "Embezzlement of Public School Renovation Funds",
        "sector": "Education & Grants",
        "severity": "High",
        "status": "Pending Triage",
        "risk_score": 78,
        "timestamp": "2026-09-01 14:20"
    },
    {
        "id": "CCMS-2026-1055",
        "title": "Extortion at Highway Traffic Checkpoint",
        "sector": "Police & Law Enforcement",
        "severity": "Critical",
        "status": "In Progress",
        "risk_score": 90,
        "timestamp": "2026-09-02 08:00"
    }
]


# ==============================================================================
# 2. PHASE 2 STATIC DATASETS (Structured / Hierarchical / Graphs)
# ==============================================================================

# Hierarchical Tree Data: CCMS Vigilance Directorate Chain of Command
DEPARTMENT_HIERARCHY_TREE_DATA = {
    "name": "Central Vigilance Directorate (HQ)",
    "role": "Chief Vigilance Commissioner",
    "left": {
        "name": "Directorate of Public Works & Infrastructure",
        "role": "Joint Director (PWD)",
        "left": {
            "name": "Civil Works Inspection Bureau",
            "role": "Zonal Inspector",
            "left": None,
            "right": None
        },
        "right": {
            "name": "Public Procurement Audit Cell",
            "role": "Chief Auditor",
            "left": None,
            "right": None
        }
    },
    "right": {
        "name": "Directorate of Revenue & Law Enforcement",
        "role": "Joint Director (Revenue & Police)",
        "left": {
            "name": "Anti-Extortion & Police Oversight Wing",
            "role": "Superintendent of Police",
            "left": None,
            "right": None
        },
        "right": {
            "name": "Land Records & Revenue Intelligence Unit",
            "role": "Deputy Commissioner",
            "left": None,
            "right": None
        }
    }
}

# Graph Adjacency List: Case Escalation & Jurisdictional Routing Network
ESCALATION_GRAPH_DATA = {
    "Citizen Front Desk": ["Triage & Verification Desk"],
    "Triage & Verification Desk": ["Citizen Front Desk", "Special Investigation Bureau", "Forensic Audit Cell"],
    "Special Investigation Bureau": ["Triage & Verification Desk", "Field Inspection Unit", "Legal Prosecution Wing"],
    "Forensic Audit Cell": ["Triage & Verification Desk", "Special Investigation Bureau", "Central Vigilance Directorate"],
    "Field Inspection Unit": ["Special Investigation Bureau", "Legal Prosecution Wing"],
    "Legal Prosecution Wing": ["Special Investigation Bureau", "Field Inspection Unit", "Central Vigilance Directorate"],
    "Central Vigilance Directorate": ["Forensic Audit Cell", "Legal Prosecution Wing", "Disciplinary Tribunal"],
    "Disciplinary Tribunal": ["Central Vigilance Directorate"]
}


# ==============================================================================
# 3. APPLICATION SEED DATASETS (Users, Officers, Complaints, Settings)
# ==============================================================================

# Default password for all seed accounts: "admin123", "officer123", "citizen123"
DEFAULT_ADMIN_PWD_HASH = generate_password_hash("admin123")
DEFAULT_OFFICER_PWD_HASH = generate_password_hash("officer123")
DEFAULT_CITIZEN_PWD_HASH = generate_password_hash("citizen123")

STATIC_USERS = [
    {
        "id": 1,
        "full_name": "Super Admin",
        "email": "admin@ccms.gov.in",
        "mobile_number": "+91 99999 00000",
        "address": "Central Vigilance HQ, New Delhi",
        "password": DEFAULT_ADMIN_PWD_HASH,
        "email_verified": 1,
        "role": "admin",
        "created_at": "2026-01-01 00:00:00"
    },
    {
        "id": 2,
        "full_name": "Rajesh Kumar (Citizen)",
        "email": "citizen@test.com",
        "mobile_number": "+91 98765 43210",
        "address": "Flat 402, Sector 15, Gandhinagar",
        "password": DEFAULT_CITIZEN_PWD_HASH,
        "email_verified": 1,
        "role": "citizen",
        "created_at": "2026-01-15 10:30:00"
    },
    {
        "id": 3,
        "full_name": "Priya Sharma (Citizen)",
        "email": "priya.sharma@example.com",
        "mobile_number": "+91 98111 22334",
        "address": "12/B MG Road, Bangalore",
        "password": DEFAULT_CITIZEN_PWD_HASH,
        "email_verified": 1,
        "role": "citizen",
        "created_at": "2026-02-01 14:20:00"
    }
]

STATIC_DEPARTMENTS = [
    {"dept_id": "DEPT-01", "name": "Police & Law Enforcement", "code": "POL", "head": "Comm. V. Rao", "total_cases": 42, "resolved_cases": 38, "risk_level": "High"},
    {"dept_id": "DEPT-02", "name": "Land Registration & Revenue", "code": "REV", "head": "Dir. K. Joshi", "total_cases": 65, "resolved_cases": 60, "risk_level": "Critical"},
    {"dept_id": "DEPT-03", "name": "Municipality & Public Works", "code": "PWD", "head": "Eng. R. Gupta", "total_cases": 51, "resolved_cases": 48, "risk_level": "High"},
    {"dept_id": "DEPT-04", "name": "Healthcare & Supplies", "code": "HLT", "head": "Dr. S. Nair", "total_cases": 29, "resolved_cases": 28, "risk_level": "Medium"},
    {"dept_id": "DEPT-05", "name": "Education & Grants", "code": "EDU", "head": "Prof. T. Sen", "total_cases": 34, "resolved_cases": 31, "risk_level": "Medium"},
    {"dept_id": "DEPT-06", "name": "Transport & Licensing", "code": "TRN", "head": "RTO P. Gill", "total_cases": 38, "resolved_cases": 35, "risk_level": "High"}
]

STATIC_CATEGORIES = [
    {"category_id": "CAT-01", "name": "Bribery & Cash Demand", "icon": "fa-hand-holding-dollar", "dept": "Land Registration & Revenue", "description": "Direct or indirect solicitation of illegal gratification"},
    {"category_id": "CAT-02", "name": "Land Scam & Title Fraud", "icon": "fa-building-shield", "dept": "Land Registration & Revenue", "description": "Forged registration or unauthorized ownership transfer"},
    {"category_id": "CAT-03", "name": "Road & Construction Scam", "icon": "fa-road", "dept": "Municipality & Public Works", "description": "Substandard materials or fake contractor invoicing"},
    {"category_id": "CAT-04", "name": "Police Misconduct & Extortion", "icon": "fa-shield-halved", "dept": "Police & Law Enforcement", "description": "Illegal detention, coercion, or harassment"},
    {"category_id": "CAT-05", "name": "Procurement & Tender Fraud", "icon": "fa-file-signature", "dept": "Municipality & Public Works", "description": "Rigged public tenders and kickback contracts"},
    {"category_id": "CAT-06", "name": "Medical Supply Embezzlement", "icon": "fa-hospital", "dept": "Healthcare & Supplies", "description": "Diversion of subsidized medicines and hospital stock"}
]

STATIC_OFFICERS = [
    {"officer_id": "OFF-4402", "name": "Senior Inspector A. Verma", "rank": "Senior Inspector", "department": "Land Registration & Revenue", "email": "officer@test.com", "phone": "+91 98000 11111", "password": DEFAULT_OFFICER_PWD_HASH, "active_cases": 2, "status": "Active", "badge_id": "ACB-IND-4402"},
    {"officer_id": "OFF-5501", "name": "Director S. Kulkarni", "rank": "Vigilance Director", "department": "Municipality & Public Works", "email": "kulkarni.s@vigilance.gov.in", "phone": "+91 98000 22222", "password": DEFAULT_OFFICER_PWD_HASH, "active_cases": 1, "status": "Active", "badge_id": "ACB-IND-5501"},
    {"officer_id": "OFF-3309", "name": "Inspector M. Sharma", "rank": "Inspector", "department": "Land Registration & Revenue", "email": "sharma.m@vigilance.gov.in", "phone": "+91 98000 33333", "password": DEFAULT_OFFICER_PWD_HASH, "active_cases": 0, "status": "Active", "badge_id": "ACB-IND-3309"},
    {"officer_id": "OFF-7712", "name": "Senior Inspector R. Deshmukh", "rank": "Senior Inspector", "department": "Transport & Licensing", "email": "deshmukh.r@vigilance.gov.in", "phone": "+91 98000 44444", "password": DEFAULT_OFFICER_PWD_HASH, "active_cases": 1, "status": "Active", "badge_id": "ACB-IND-7712"},
    {"officer_id": "OFF-8823", "name": "Inspector P. Mehta", "rank": "Inspector", "department": "Healthcare & Supplies", "email": "mehta.p@vigilance.gov.in", "phone": "+91 98000 55555", "password": DEFAULT_OFFICER_PWD_HASH, "active_cases": 0, "status": "Active", "badge_id": "ACB-IND-8823"}
]

STATIC_COMPLAINTS = [
    {
        "complaint_id": "CCMS-2026-2237",
        "user_id": 2,
        "complaint_title": "Bribe Demand for Building Permit Approval",
        "misconduct_category": "Bribery & Cash Demand",
        "sector": "Municipality & Public Works",
        "incident_date": "2026-08-25",
        "incident_time": "11:30",
        "location": "Municipal Corporation Office, Ward 4",
        "description": "Assistant Town Planner demanded Rs. 50,000 cash gratification to clear commercial occupancy certificate.",
        "anonymous_mode": 0,
        "severity": "High",
        "evidence_file": None,
        "complaint_status": "Under Investigation",
        "assigned_officer": "Director S. Kulkarni",
        "assigned_officer_id": "OFF-5501",
        "investigation_notes": "Forensic audio recording analysis complete. Subpoena served to department.",
        "rating": None,
        "feedback": None,
        "created_at": "2026-09-01 09:15:00"
    },
    {
        "complaint_id": "CCMS-2026-1024",
        "user_id": 2,
        "complaint_title": "Procurement Tender Bribery in Medical Supplies",
        "misconduct_category": "Procurement & Tender Fraud",
        "sector": "Healthcare & Supplies",
        "incident_date": "2026-08-28",
        "incident_time": "14:00",
        "location": "District Civil Hospital Store",
        "description": "Hospital procurement officer favored an unverified supplier for dialysis units in exchange for kickbacks.",
        "anonymous_mode": 1,
        "severity": "Critical",
        "evidence_file": None,
        "complaint_status": "Pending",
        "assigned_officer": None,
        "assigned_officer_id": None,
        "investigation_notes": None,
        "rating": None,
        "feedback": None,
        "created_at": "2026-09-01 10:30:00"
    },
    {
        "complaint_id": "CCMS-2026-1038",
        "user_id": 3,
        "complaint_title": "Unauthorized Land Title Transfer Kickback",
        "misconduct_category": "Land Scam & Title Fraud",
        "sector": "Land Registration & Revenue",
        "incident_date": "2026-08-20",
        "incident_time": "10:15",
        "location": "Sub-Registrar Office, Taluka 2",
        "description": "Registrar clerk altered boundary survey number 402/1 without original owner signature.",
        "anonymous_mode": 0,
        "severity": "Medium",
        "evidence_file": None,
        "complaint_status": "Assigned",
        "assigned_officer": "Senior Inspector A. Verma",
        "assigned_officer_id": "OFF-4402",
        "investigation_notes": "Land revenue records under forensic audit.",
        "rating": None,
        "feedback": None,
        "created_at": "2026-09-01 11:45:00"
    },
    {
        "complaint_id": "CCMS-2026-1049",
        "user_id": 3,
        "complaint_title": "Embezzlement of Public School Renovation Funds",
        "misconduct_category": "Road & Construction Scam",
        "sector": "Education & Grants",
        "incident_date": "2026-08-15",
        "incident_time": "16:00",
        "location": "Government Higher Secondary School",
        "description": "Contractor billed for laboratory equipment and roof waterproofing that was never installed.",
        "anonymous_mode": 0,
        "severity": "High",
        "evidence_file": None,
        "complaint_status": "Resolved",
        "assigned_officer": "Senior Inspector A. Verma",
        "assigned_officer_id": "OFF-4402",
        "investigation_notes": "Contractor blacklisted and Rs. 4.2 Lakhs recovered to treasury.",
        "rating": 5,
        "feedback": "Prompt and decisive action taken by the vigilance team.",
        "created_at": "2026-08-16 14:20:00"
    },
    {
        "complaint_id": "CCMS-2026-1055",
        "user_id": 2,
        "complaint_title": "Extortion at Highway Traffic Checkpoint",
        "misconduct_category": "Police Misconduct & Extortion",
        "sector": "Police & Law Enforcement",
        "incident_date": "2026-08-30",
        "incident_time": "23:45",
        "location": "National Highway 48 Checkpoint",
        "description": "Night patrol officers extorting illegal transit fees from commercial transport vehicles.",
        "anonymous_mode": 1,
        "severity": "Critical",
        "evidence_file": None,
        "complaint_status": "Assigned",
        "assigned_officer": "Senior Inspector R. Deshmukh",
        "assigned_officer_id": "OFF-7712",
        "investigation_notes": "Checkpoint CCTV footage seized for examination.",
        "rating": None,
        "feedback": None,
        "created_at": "2026-09-02 08:00:00"
    }
]

STATIC_ACTIVITY_LOGS = [
    {"actor": "Super Admin", "action": "Master System Boot", "details": "CCMS Static Core Engine initialized with Zero-Knowledge Encryption.", "ip_address": "127.0.0.1", "timestamp": "2026-09-01 08:00:00"},
    {"actor": "Super Admin", "action": "Greedy Engine Ready", "details": "Auto-assignment greedy dispatch engine synchronized with active vigilance officers.", "ip_address": "127.0.0.1", "timestamp": "2026-09-01 08:15:00"},
    {"actor": "OFF-4402", "action": "Case Investigation Started", "details": "Inspector Verma assigned to case CCMS-2026-1038.", "ip_address": "127.0.0.1", "timestamp": "2026-09-01 12:00:00"},
    {"actor": "Citizen (Rajesh)", "action": "New Complaint Filed", "details": "Filed complaint CCMS-2026-2237 regarding PWD bribe solicitation.", "ip_address": "127.0.0.1", "timestamp": "2026-09-01 09:15:00"}
]

STATIC_NOTIFICATIONS = [
    {"user_id": None, "recipient_role": "all", "title": "System Security Active", "message": "All whistleblower complaints are protected with AES-256 encryption. Zero external server dependencies required.", "badge_type": "success", "is_read": 0, "created_at": "2026-09-01 08:00:00"},
    {"user_id": None, "recipient_role": "officer", "title": "High Priority Queue Active", "message": "Check your priority queue for cases with urgency scores exceeding 8.5/10.", "badge_type": "warning", "is_read": 0, "created_at": "2026-09-01 08:30:00"},
    {"user_id": None, "recipient_role": "citizen", "title": "Real-time Tracking Enabled", "message": "You can now track your complaint status in real-time with full officer milestone timeline.", "badge_type": "info", "is_read": 0, "created_at": "2026-09-01 09:00:00"},
    {"user_id": 2, "recipient_role": "citizen", "title": "Case Update: CCMS-2026-2237", "message": "Your complaint has moved to 'Under Investigation' status under Director S. Kulkarni.", "badge_type": "primary", "is_read": 0, "created_at": "2026-09-01 10:00:00"}
]

STATIC_SYSTEM_SETTINGS = [
    {"setting_key": "site_name", "setting_value": "CCMS - Anti-Corruption & Vigilance Command System"},
    {"setting_key": "contact_phone", "setting_value": "1800-11-CCMS (2267)"},
    {"setting_key": "contact_email", "setting_value": "whistleblower@ccms.gov.in"},
    {"setting_key": "encryption_protocol", "setting_value": "AES-256-GCM Military Grade"},
    {"setting_key": "auto_assignment_mode", "setting_value": "Greedy Workload Optimization"},
    {"setting_key": "sla_hours_high", "setting_value": "24"},
    {"setting_key": "sla_hours_medium", "setting_value": "72"},
    {"setting_key": "sla_hours_low", "setting_value": "168"}
]
