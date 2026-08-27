/* ============================================================
   CCMS CITIZEN PANEL JAVASCRIPT STATE & DATA STRUCTURE ENGINE
============================================================ */

// Initial Default Sample Complaints
const DEFAULT_COMPLAINTS = [
  {
    id: "CCMS-2026-6775",
    title: "Public Works Department Procurement Embezzlement",
    category: "Bribery & Extortion",
    department: "Public Works & Infrastructure",
    description: "Irregular bidding procedures, forged contractor quotes, and kickback payments in municipal highway contracts.",
    date: "2026-08-10",
    time: "09:15 AM",
    location: "Municipal Infrastructure Commission HQ",
    anonymous: true,
    priority: "High",
    status: "Investigation Active",
    assignedOfficer: "Senior Inspector A. Verma, Anti-Corruption Bureau",
    evidence: ["audit_ledger_2026.pdf", "recorded_wire_call.mp3"],
    rating: null,
    feedback: null,
    timeline: [
      {
        stage: "1. Encrypted Complaint Received",
        desc: "Received via AES-GCM-256 vault. EXIF and IP metadata scrubbed.",
        meta: "Timestamp: 10 Aug 2026, 09:15 AM",
        date: "10 Aug 2026",
        status: "completed"
      },
      {
        stage: "2. AI Priority & Evidence Validation",
        desc: "Evidence files verified authentic. Urgency score calculated: High (8.9/10).",
        meta: "Timestamp: 10 Aug 2026, 11:30 AM",
        date: "10 Aug 2026",
        status: "completed"
      },
      {
        stage: "3. Vigilance Officer Investigation",
        desc: "Assigned to Senior Inspector A. Verma, Anti-Corruption Bureau. Official summons issued to department head.",
        meta: "Status: In Progress (SLA: < 24h remaining)",
        date: "11 Aug 2026",
        status: "active"
      },
      {
        stage: "4. Final Legal Sanction & Audit Log",
        desc: "Execution of disciplinary or criminal proceedings and publication to public audit ledger.",
        meta: "Pending Final Review",
        date: "Pending",
        status: "pending"
      }
    ]
  },
  {
    id: "CCMS-2026-8902",
    title: "Land Registration Title Deed Bribe Extortion",
    category: "Bribery & Extortion",
    department: "Land & Revenue Dept",
    description: "Officer at Zonal Registration Office demanded $500 cash for issuing title transfer certificate.",
    date: "2026-07-12",
    time: "10:30 AM",
    location: "District Revenue Office, Zone 4",
    anonymous: true,
    priority: "High",
    status: "Resolved",
    assignedOfficer: "Senior Inspector A. Verma, Anti-Corruption Bureau",
    evidence: ["receipt_scan.pdf", "audio_recording.mp3"],
    rating: 5,
    feedback: "Resolved quickly without compromising my identity. Thank you!",
    timeline: [
      {
        stage: "1. Encrypted Complaint Received",
        desc: "Received via AES-GCM-256 vault. EXIF and IP metadata scrubbed.",
        meta: "Timestamp: 12 Jul 2026, 10:30 AM",
        date: "12 Jul 2026",
        status: "completed"
      },
      {
        stage: "2. AI Priority & Evidence Validation",
        desc: "Evidence audio & receipt verified authentic. Urgency score: High (9.1/10).",
        meta: "Timestamp: 12 Jul 2026, 01:15 PM",
        date: "12 Jul 2026",
        status: "completed"
      },
      {
        stage: "3. Vigilance Officer Investigation",
        desc: "Assigned to Senior Inspector A. Verma. Sting operation executed; extortion confirmed.",
        meta: "Status: Completed (Disciplinary action initiated)",
        date: "15 Jul 2026",
        status: "completed"
      },
      {
        stage: "4. Final Legal Sanction & Audit Log",
        desc: "Officer suspended; $500 refunded to public treasury. Entry committed to public audit ledger.",
        meta: "Status: Case Closed & Sanction Executed",
        date: "18 Jul 2026",
        status: "completed"
      }
    ]
  },
  {
    id: "CCMS-2026-4412",
    title: "Municipal Road Construction Tender Rigging",
    category: "Procurement Malpractice",
    department: "Public Works Dept",
    description: "Contract tender specifications modified to favor a relative's construction firm.",
    date: "2026-08-01",
    time: "02:15 PM",
    location: "Municipal Corporation HQ",
    anonymous: false,
    priority: "Critical",
    status: "Investigation Active",
    assignedOfficer: "Director S. Kulkarni, Vigilance Special Unit",
    evidence: ["tender_doc_v2.pdf"],
    rating: null,
    feedback: null,
    timeline: [
      {
        stage: "1. Encrypted Complaint Received",
        desc: "Received via AES-GCM-256 vault. Signed by registered citizen account.",
        meta: "Timestamp: 01 Aug 2026, 02:15 PM",
        date: "01 Aug 2026",
        status: "completed"
      },
      {
        stage: "2. AI Priority & Evidence Validation",
        desc: "Discrepancy in tender bidding documents confirmed. Urgency score: Critical (9.4/10).",
        meta: "Timestamp: 01 Aug 2026, 04:45 PM",
        date: "01 Aug 2026",
        status: "completed"
      },
      {
        stage: "3. Vigilance Officer Investigation",
        desc: "Assigned to Director S. Kulkarni for forensic financial audit. Contractor accounts frozen.",
        meta: "Status: In Progress (SLA: < 48h remaining)",
        date: "03 Aug 2026",
        status: "active"
      },
      {
        stage: "4. Final Legal Sanction & Audit Log",
        desc: "Execution of tender cancellation and blacklisting of shell contractors.",
        meta: "Pending Investigation Conclusion",
        date: "Pending",
        status: "pending"
      }
    ]
  },
  {
    id: "CCMS-2026-9920",
    title: "Primary School Digital Grant Misappropriation",
    category: "Embezzlement & Fraud",
    department: "Education & Grants",
    description: "Budget allocated for digital tablet computers siphoned into private accounts.",
    date: "2026-08-08",
    time: "11:00 AM",
    location: "District Education Office",
    anonymous: true,
    priority: "Medium",
    status: "Pending",
    assignedOfficer: "Anti-Corruption Triage Desk",
    evidence: ["grant_allocation_sheet.xlsx"],
    rating: null,
    feedback: null,
    timeline: [
      {
        stage: "1. Encrypted Complaint Received",
        desc: "Received via AES-GCM-256 vault. EXIF and IP metadata scrubbed.",
        meta: "Timestamp: 08 Aug 2026, 11:00 AM",
        date: "08 Aug 2026",
        status: "completed"
      },
      {
        stage: "2. AI Priority & Evidence Validation",
        desc: "Automated OCR scanned financial sheets. Triage Urgency score: Medium (6.8/10).",
        meta: "Status: In Progress (Verification queue #4)",
        date: "08 Aug 2026",
        status: "active"
      },
      {
        stage: "3. Vigilance Officer Investigation",
        desc: "Queueing for assignment to Education Sector Vigilance Officer.",
        meta: "Pending Desk Assignment",
        date: "Pending",
        status: "pending"
      },
      {
        stage: "4. Final Legal Sanction & Audit Log",
        desc: "Execution of disciplinary recovery and publication to public audit ledger.",
        meta: "Pending Investigation",
        date: "Pending",
        status: "pending"
      }
    ]
  }
];

// Initial Default Notifications
const DEFAULT_NOTIFICATIONS = [
  { id: 1, text: "Complaint #CCMS-2026-8902 has been marked as RESOLVED.", date: "18 July 2026", unread: true, type: "success" },
  { id: 2, text: "Investigation started for Complaint #CCMS-2026-4412 by Dir. S. Kulkarni.", date: "02 Aug 2026", unread: true, type: "info" },
  { id: 3, text: "Evidence verified for Complaint #CCMS-2026-4412.", date: "05 Aug 2026", unread: false, type: "primary" }
];

// Initial Default User Profile
const DEFAULT_USER = {
  name: "Narola Avadh Shaileshbhai",
  email: "avadh.narola@example.com",
  phone: "+91 98765 43210",
  nationalId: "IND-8849-2026",
  address: "74 Integrity Avenue, District Center",
  joinedDate: "January 2026",
  avatarText: "NAS"
};

// ============================================================
// STATE INITIALIZATION & LOCALSTORAGE MANAGEMENT
// ============================================================
function getStoredComplaints() {
  const data = localStorage.getItem("ccms_complaints");
  if (!data) {
    localStorage.setItem("ccms_complaints", JSON.stringify(DEFAULT_COMPLAINTS));
    return DEFAULT_COMPLAINTS;
  }
  try {
    let parsed = JSON.parse(data);
    // Ensure all default complaints exist in the list
    let updated = false;
    DEFAULT_COMPLAINTS.forEach(def => {
      const idx = parsed.findIndex(c => c.id.toLowerCase() === def.id.toLowerCase());
      if (idx === -1) {
        parsed.unshift(def);
        updated = true;
      } else if (!parsed[idx].timeline || parsed[idx].timeline.length === 0 || !parsed[idx].timeline[0].meta) {
        // Upgrade legacy timeline objects
        parsed[idx].timeline = def.timeline;
        parsed[idx].status = def.status;
        parsed[idx].assignedOfficer = def.assignedOfficer;
        updated = true;
      }
    });
    if (updated) {
      localStorage.setItem("ccms_complaints", JSON.stringify(parsed));
    }
    return parsed;
  } catch (e) {
    localStorage.setItem("ccms_complaints", JSON.stringify(DEFAULT_COMPLAINTS));
    return DEFAULT_COMPLAINTS;
  }
}

function saveComplaints(complaints) {
  localStorage.setItem("ccms_complaints", JSON.stringify(complaints));
}

function getStoredNotifications() {
  const data = localStorage.getItem("ccms_notifications");
  if (!data) {
    localStorage.setItem("ccms_notifications", JSON.stringify(DEFAULT_NOTIFICATIONS));
    return DEFAULT_NOTIFICATIONS;
  }
  return JSON.parse(data);
}

function getStoredUser() {
  const data = localStorage.getItem("ccms_user");
  if (!data) {
    localStorage.setItem("ccms_user", JSON.stringify(DEFAULT_USER));
    return DEFAULT_USER;
  }
  return JSON.parse(data);
}

// ============================================================
// LIGHT / DARK THEME ENGINE
// ============================================================
function initTheme() {
  const savedTheme = localStorage.getItem("ccms_theme") || "light";
  document.documentElement.setAttribute("data-theme", savedTheme);
  updateThemeIcon(savedTheme);
}

function toggleTheme() {
  const currentTheme = document.documentElement.getAttribute("data-theme") || "light";
  const newTheme = currentTheme === "light" ? "dark" : "light";
  document.documentElement.setAttribute("data-theme", newTheme);
  localStorage.setItem("ccms_theme", newTheme);
  updateThemeIcon(newTheme);
}

function updateThemeIcon(theme) {
  const btn = document.getElementById("themeToggleBtn");
  if (btn) {
    if (theme === "dark") {
      btn.innerHTML = '<i class="fas fa-sun text-warning"></i>';
      btn.setAttribute("title", "Switch to Light Theme");
    } else {
      btn.innerHTML = '<i class="fas fa-moon text-primary"></i>';
      btn.setAttribute("title", "Switch to Dark Theme");
    }
  }
}

// Initialize theme immediately
initTheme();

// ============================================================
// COMPLAINT CRUD OPERATIONS
// ============================================================
function fileNewComplaint(formData) {
  const complaints = getStoredComplaints();
  
  // Generate random Complaint ID
  const randomNum = Math.floor(1000 + Math.random() * 9000);
  const newId = `CCMS-2026-${randomNum}`;
  const todayStr = new Date().toISOString().split('T')[0];

  const newComplaint = {
    id: newId,
    title: formData.title,
    category: formData.category,
    department: formData.department,
    description: formData.description,
    date: formData.date || todayStr,
    time: formData.time || "12:00 PM",
    location: formData.location || "City Center",
    anonymous: formData.anonymous,
    priority: formData.priority || "Medium",
    status: "Pending",
    assignedOfficer: "Pending Assignment",
    evidence: formData.evidenceList || ["evidence_file.pdf"],
    rating: null,
    feedback: null,
    timeline: [
      { date: `${new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })}`, stage: "Complaint Submitted", desc: "Report filed and encrypted client-side." }
    ]
  };

  complaints.unshift(newComplaint);
  saveComplaints(complaints);

  // Add Notification
  const notifications = getStoredNotifications();
  notifications.unshift({
    id: Date.now(),
    text: `Complaint #${newId} submitted successfully.`,
    date: "Just Now",
    unread: true,
    type: "primary"
  });
  localStorage.setItem("ccms_notifications", JSON.stringify(notifications));

  return newId;
}

function withdrawComplaint(complaintId) {
  let complaints = getStoredComplaints();
  const target = complaints.find(c => c.id === complaintId);

  if (!target) return { success: false, message: "Complaint not found." };
  if (target.status !== "Pending") {
    return { success: false, message: "Complaint cannot be withdrawn once assigned or under investigation." };
  }

  complaints = complaints.filter(c => c.id !== complaintId);
  saveComplaints(complaints);

  return { success: true, message: `Complaint #${complaintId} has been withdrawn successfully.` };
}

// ============================================================
// LINKED LIST DATA STRUCTURE IMPLEMENTATION
// ============================================================
class ListNode {
  constructor(data) {
    this.data = data; // { date, stage, desc }
    this.next = null; // Pointer to next timeline node
    this.memoryAddress = '0x' + Math.floor(Math.random() * 0xFFFFFF).toString(16).toUpperCase();
  }
}

class LinkedList {
  constructor() {
    this.head = null;
    this.tail = null;
    this.size = 0;
  }

  append(data) {
    const newNode = new ListNode(data);
    if (!this.head) {
      this.head = newNode;
      this.tail = newNode;
    } else {
      this.tail.next = newNode;
      this.tail = newNode;
    }
    this.size++;
    return newNode;
  }
}

// Render Linked List Timeline UI
function renderLinkedListTimeline(containerId, timelineArray) {
  const container = document.getElementById(containerId);
  if (!container) return;

  // Build Linked List from timeline data
  const list = new LinkedList();
  timelineArray.forEach(item => list.append(item));

  let html = `<div class="linked-list-container">`;
  let current = list.head;
  let stepIndex = 1;

  while (current !== null) {
    const isLast = (current.next === null);
    const nodeClass = isLast ? "linked-list-node active" : "linked-list-node";
    const nextAddress = current.next ? current.next.memoryAddress : "0x000000 (NULL)";

    html += `
      <div class="${nodeClass}">
        <div class="node-header">
          <span>NODE #${stepIndex}</span>
          <span class="text-primary">${current.memoryAddress}</span>
        </div>
        <div class="node-data">
          <div class="fw-bold mb-1">${current.data.stage}</div>
          <div class="text-muted small mb-1"><i class="far fa-calendar me-1"></i>${current.data.date}</div>
          <div class="text-muted" style="font-size:0.78rem;">${current.data.desc}</div>
        </div>
        <div class="node-ptr">
          <span>next &#8594; </span><strong class="${current.next ? 'text-primary' : 'text-danger'}">${nextAddress}</strong>
        </div>
      </div>
    `;

    if (!isLast) {
      html += `<div class="node-arrow"><i class="fas fa-arrow-right"></i></div>`;
    }

    current = current.next;
    stepIndex++;
  }

  html += `</div>`;
  container.innerHTML = html;
}

// ============================================================
// AI CHATBOT RESPONSE ENGINE
// ============================================================
function getAIChatbotResponse(userMessage) {
  const msg = userMessage.toLowerCase();

  if (msg.includes("anonymous") || msg.includes("identity") || msg.includes("safe")) {
    return "Yes! When you enable Anonymous Mode during complaint filing, all IP addresses, EXIF file metadata, and personal identities are completely stripped. Your report is encrypted with AES-256.";
  } else if (msg.includes("track") || msg.includes("status") || msg.includes("key")) {
    return "You can track your complaint anytime on the 'Track Complaint' page using your unique 16-digit Complaint ID (e.g., CCMS-2026-8902). No login is required.";
  } else if (msg.includes("withdraw") || msg.includes("cancel")) {
    return "You can withdraw your complaint from the 'My Complaints' page as long as its status is still 'Pending' (before officer assignment).";
  } else if (msg.includes("evidence") || msg.includes("file") || msg.includes("upload")) {
    return "CCMS supports evidence in PDF, DOCX, MP3, WAV, JPG, PNG, and MP4 formats up to 50MB. All files are encrypted client-side.";
  } else if (msg.includes("legal") || msg.includes("whistleblower") || msg.includes("reward")) {
    return "Whistleblowers are protected under national immunity laws against retaliation. High-value fraud reports may also qualify for up to 10% financial reward upon asset recovery.";
  } else {
    return "I am the CCMS AI Vigilance Assistant. You can ask me about anonymous filing, tracking keys, evidence upload rules, withdrawing complaints, or legal protection!";
  }
}

// ============================================================
// GLOBAL FLOATING TOAST NOTIFICATION HELPER
// ============================================================
function showCcmsToast(message, type = 'info', title = '') {
  let container = document.getElementById('ccmsToastContainer');
  if (!container) {
    container = document.createElement('div');
    container.id = 'ccmsToastContainer';
    document.body.appendChild(container);
  }

  const icons = {
    info: 'fas fa-info-circle text-info',
    success: 'fas fa-check-circle text-success',
    warning: 'fas fa-triangle-exclamation text-warning',
    danger: 'fas fa-circle-exclamation text-danger'
  };

  const toastTitle = title || (type.charAt(0).toUpperCase() + type.slice(1));
  const toast = document.createElement('div');
  toast.className = 'ccms-toast';
  toast.innerHTML = `
    <div class="fs-4 ${icons[type] || icons.info}"></div>
    <div class="flex-grow-1 overflow-hidden">
      <div class="fw-bold text-heading small">${toastTitle}</div>
      <div class="text-muted small text-truncate">${message}</div>
    </div>
    <button type="button" class="btn-close btn-close-sm ms-2" onclick="this.parentElement.remove()"></button>
    <div class="ccms-toast-progress"></div>
  `;

  container.appendChild(toast);
  setTimeout(() => {
    toast.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
    toast.style.opacity = '0';
    toast.style.transform = 'translateX(100%)';
    setTimeout(() => toast.remove(), 400);
  }, 4000);
}

// ============================================================
// SWEETALERT2 INTEGRATION & GLOBAL MODAL POPUP HELPERS
// ============================================================
(function loadSweetAlert2() {
  if (typeof Swal === 'undefined') {
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
    document.head.appendChild(script);
  }
})();

window.showCcmsModalAlert = function(title, message, icon = 'info', confirmText = 'OK') {
  if (typeof Swal !== 'undefined') {
    return Swal.fire({
      title: title,
      text: message,
      icon: icon,
      confirmButtonText: confirmText,
      customClass: { popup: 'swal2-popup' }
    });
  } else {
    showCcmsToast(message, icon === 'error' ? 'danger' : icon, title);
  }
};

window.showCcmsConfirm = function(title, message, callback) {
  if (typeof Swal !== 'undefined') {
    Swal.fire({
      title: title,
      text: message,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, Proceed',
      cancelButtonText: 'Cancel',
      customClass: { popup: 'swal2-popup' }
    }).then((result) => {
      if (result.isConfirmed && typeof callback === 'function') {
        callback();
      }
    });
  } else {
    showCcmsToast(message, 'warning', title);
  }
};

// Automatic Interception of Native Browser Popups
window.alert = function(msg) {
  window.showCcmsModalAlert('CCMS Notification', String(msg), 'info');
};



