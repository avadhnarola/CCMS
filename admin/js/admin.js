/* ============================================================
   CCMS ADMIN PANEL - SUPER ADMIN STATE & GREEDY ENGINE
============================================================ */

// Initial Default Citizens List
const DEFAULT_CITIZENS = [
  { id: 1, name: "Rajesh Kumar", email: "rajesh.kumar@example.com", phone: "+91 98765 43210", city: "Capital City", status: "Active", joined: "2026-01-15" },
  { id: 2, name: "Sneha Sharma", email: "sneha.sharma@contractor.in", phone: "+91 98111 22334", city: "Metro City", status: "Active", joined: "2026-03-20" },
  { id: 3, name: "Arjun Patel", email: "arjun.patel@rti.org", phone: "+91 97222 33445", city: "North District", status: "Active", joined: "2026-05-10" },
  { id: 4, name: "Vikram Singh", email: "vikram.s@test.com", phone: "+91 96333 44556", city: "East Zone", status: "Blocked", joined: "2026-06-01" }
];

// Initial Default Officers List
const DEFAULT_OFFICERS = [
  { id: "OFF-4402", name: "Insp. A. Verma", rank: "Senior Inspector", department: "Land Registration & Revenue", email: "verma.a@vigilance.gov.in", phone: "+91 98000 11111", activeCases: 2 },
  { id: "OFF-5501", name: "Dir. S. Kulkarni", rank: "Vigilance Director", department: "Public Works Dept", email: "kulkarni.s@vigilance.gov.in", phone: "+91 98000 22222", activeCases: 1 },
  { id: "OFF-3309", name: "Insp. M. Sharma", rank: "Inspector", department: "Land Registration & Revenue", email: "sharma.m@vigilance.gov.in", phone: "+91 98000 33333", activeCases: 0 },
  { id: "OFF-7712", name: "Insp. R. Deshmukh", rank: "Senior Inspector", department: "Transport & RTO", email: "deshmukh.r@vigilance.gov.in", phone: "+91 98000 44444", activeCases: 1 },
  { id: "OFF-8823", name: "Insp. P. Mehta", rank: "Inspector", department: "Healthcare & Supplies", email: "mehta.p@vigilance.gov.in", phone: "+91 98000 55555", activeCases: 0 }
];

// Initial Departments List
const DEFAULT_DEPARTMENTS = [
  { id: "DEPT-01", name: "Police & Law Enforcement", code: "POL", head: "Comm. V. Rao", totalCases: 42, resolved: 38 },
  { id: "DEPT-02", name: "Land Registration & Revenue", code: "REV", head: "Dir. K. Joshi", totalCases: 65, resolved: 60 },
  { id: "DEPT-03", name: "Municipality & Public Works", code: "PWD", head: "Eng. R. Gupta", totalCases: 51, resolved: 48 },
  { id: "DEPT-04", name: "Healthcare & Supplies", code: "HLT", head: "Dr. S. Nair", totalCases: 29, resolved: 28 },
  { id: "DEPT-05", name: "Education & Grants", code: "EDU", head: "Prof. T. Sen", totalCases: 34, resolved: 31 },
  { id: "DEPT-06", name: "Transport & Licensing", code: "TRN", head: "RTO P. Gill", totalCases: 38, resolved: 35 }
];

// Initial Categories List
const DEFAULT_CATEGORIES = [
  { id: "CAT-01", name: "Bribery & Cash Demand", icon: "fa-hand-holding-dollar", dept: "Revenue" },
  { id: "CAT-02", name: "Land Scam & Title Fraud", icon: "fa-building-shield", dept: "Revenue" },
  { id: "CAT-03", name: "Road & Construction Scam", icon: "fa-road", dept: "Public Works" },
  { id: "CAT-04", name: "Police Misconduct & Extortion", icon: "fa-shield-cat", dept: "Police" },
  { id: "CAT-05", name: "Procurement & Tender Fraud", icon: "fa-file-signature", dept: "Municipality" }
];

// Initial System Activity Logs
const DEFAULT_ACTIVITY_LOGS = [
  { timestamp: "10 Aug 2026, 09:00 AM", actor: "Super Admin", action: "Admin Login", details: "Super Admin session authenticated successfully." },
  { timestamp: "10 Aug 2026, 10:15 AM", actor: "Super Admin", action: "Officer Added", details: "Added Insp. M. Sharma to Land Registration & Revenue." },
  { timestamp: "10 Aug 2026, 11:30 AM", actor: "Greedy Engine", action: "Complaint Assigned", details: "Assigned #CCMS-2026-9920 to Insp. M. Sharma (Fewest Active Cases: 0)." },
  { timestamp: "10 Aug 2026, 01:45 PM", actor: "Super Admin", action: "Department Updated", details: "Updated Healthcare & Supplies SLA target to 24 hours." }
];

// Initial System Settings
const DEFAULT_SETTINGS = {
  siteName: "CCMS - Corruption Complaint System",
  logoText: "CCMS Admin",
  contactPhone: "1800-11-CCMS",
  contactEmail: "admin@ccms-portal.gov.in",
  smtpServer: "smtp.ccms.gov.in",
  smtpPort: 587
};

// ============================================================
// STATE ACCESSORS
// ============================================================
function getCitizens() {
  const data = localStorage.getItem("ccms_admin_citizens");
  if (!data) { localStorage.setItem("ccms_admin_citizens", JSON.stringify(DEFAULT_CITIZENS)); return DEFAULT_CITIZENS; }
  return JSON.parse(data);
}
function saveCitizens(list) { localStorage.setItem("ccms_admin_citizens", JSON.stringify(list)); }

function getOfficers() {
  const data = localStorage.getItem("ccms_admin_officers");
  if (!data) { localStorage.setItem("ccms_admin_officers", JSON.stringify(DEFAULT_OFFICERS)); return DEFAULT_OFFICERS; }
  return JSON.parse(data);
}
function saveOfficers(list) { localStorage.setItem("ccms_admin_officers", JSON.stringify(list)); }

function getDepartments() {
  const data = localStorage.getItem("ccms_admin_depts");
  if (!data) { localStorage.setItem("ccms_admin_depts", JSON.stringify(DEFAULT_DEPARTMENTS)); return DEFAULT_DEPARTMENTS; }
  return JSON.parse(data);
}
function saveDepartments(list) { localStorage.setItem("ccms_admin_depts", JSON.stringify(list)); }

function getCategories() {
  const data = localStorage.getItem("ccms_admin_cats");
  if (!data) { localStorage.setItem("ccms_admin_cats", JSON.stringify(DEFAULT_CATEGORIES)); return DEFAULT_CATEGORIES; }
  return JSON.parse(data);
}
function saveCategories(list) { localStorage.setItem("ccms_admin_cats", JSON.stringify(list)); }

function getActivityLogs() {
  const data = localStorage.getItem("ccms_admin_logs");
  if (!data) { localStorage.setItem("ccms_admin_logs", JSON.stringify(DEFAULT_ACTIVITY_LOGS)); return DEFAULT_ACTIVITY_LOGS; }
  return JSON.parse(data);
}
function logAdminActivity(action, details, actor = "Super Admin") {
  const logs = getActivityLogs();
  const timestampStr = new Date().toLocaleString('en-GB', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
  logs.unshift({ timestamp: timestampStr, actor: actor, action: action, details: details });
  localStorage.setItem("ccms_admin_logs", JSON.stringify(logs));
}

// ============================================================
// GREEDY ALGORITHM COMPLAINT ASSIGNMENT ENGINE
// ============================================================
/**
 * Greedy Choice Property:
 * Assign complaint to the officer in the target department who currently has
 * the MINIMUM number of active assigned cases.
 */
function greedyAssignComplaint(complaintId) {
  const complaints = JSON.parse(localStorage.getItem("ccms_complaints") || "[]");
  const targetComplaint = complaints.find(c => c.id === complaintId);

  if (!targetComplaint) return { success: false, message: "Complaint not found." };

  const officers = getOfficers();
  // Filter officers matching department (or get all officers if no direct match)
  let deptOfficers = officers.filter(o => o.department.includes(targetComplaint.department) || targetComplaint.department.includes(o.department));
  if (deptOfficers.length === 0) deptOfficers = officers; // Fallback to all officers

  // GREEDY CHOICE: Select officer with minimum active cases
  deptOfficers.sort((a, b) => a.activeCases - b.activeCases);
  const selectedOfficer = deptOfficers[0];

  // Apply assignment
  targetComplaint.status = "Assigned";
  targetComplaint.assignedOfficer = selectedOfficer.name;
  localStorage.setItem("ccms_complaints", JSON.stringify(complaints));

  // Increment officer active count
  selectedOfficer.activeCases += 1;
  saveOfficers(officers);

  // Log activity
  logAdminActivity("Complaint Assigned (Greedy)", `Assigned complaint #${complaintId} to ${selectedOfficer.name} (Greedy Choice: ${selectedOfficer.activeCases} active cases).`, "Greedy Algorithm Engine");

  return {
    success: true,
    assignedOfficer: selectedOfficer.name,
    activeCases: selectedOfficer.activeCases,
    message: `Greedy Choice Successful! Complaint #${complaintId} assigned to ${selectedOfficer.name} (Active Workload: ${selectedOfficer.activeCases} cases).`
  };
}

// ============================================================
// THEME ENGINE
// ============================================================
function initAdminTheme() {
  const savedTheme = localStorage.getItem("ccms_admin_theme") || "light";
  document.documentElement.setAttribute("data-theme", savedTheme);
  updateAdminThemeIcon(savedTheme);
}

function toggleAdminTheme() {
  const currentTheme = document.documentElement.getAttribute("data-theme") || "light";
  const newTheme = currentTheme === "light" ? "dark" : "light";
  document.documentElement.setAttribute("data-theme", newTheme);
  localStorage.setItem("ccms_admin_theme", newTheme);
  updateAdminThemeIcon(newTheme);
}

function updateAdminThemeIcon(theme) {
  const btn = document.getElementById("themeToggleBtn");
  if (btn) {
    btn.innerHTML = theme === "dark" ? '<i class="fas fa-sun text-warning"></i>' : '<i class="fas fa-moon text-primary"></i>';
  }
}

initAdminTheme();
