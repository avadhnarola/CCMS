/* ============================================================
   CCMS CITIZEN PANEL JAVASCRIPT STATE & DATA STRUCTURE ENGINE
============================================================ */

// Initial Default Sample Complaints
const DEFAULT_COMPLAINTS = [
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
    assignedOfficer: "Insp. A. Verma (Anti-Corruption Bureau)",
    evidence: ["receipt_scan.pdf", "audio_recording.mp3"],
    rating: 5,
    feedback: "Resolved quickly without compromising my identity. Thank you!",
    timeline: [
      { date: "12 July 2026", stage: "Complaint Submitted", desc: "Encrypted report received & anonymous key generated." },
      { date: "13 July 2026", stage: "Assigned to Officer", desc: "Assigned to Insp. A. Verma (Anti-Corruption Desk)." },
      { date: "15 July 2026", stage: "Evidence Verified", desc: "Audio recording and transaction receipt verified authentic." },
      { date: "18 July 2026", stage: "Resolved", desc: "Officer suspended; $500 refunded to public treasury." }
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
    status: "In Progress",
    assignedOfficer: "Director S. Kulkarni",
    evidence: ["tender_doc_v2.pdf"],
    rating: null,
    feedback: null,
    timeline: [
      { date: "01 August 2026", stage: "Complaint Submitted", desc: "Report filed and assigned urgency score 9.2." },
      { date: "02 August 2026", stage: "Assigned to Officer", desc: "Assigned to Director S. Kulkarni for forensic audit." },
      { date: "05 August 2026", stage: "Evidence Verified", desc: "Discrepancy in tender bidding documents confirmed." }
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
    assignedOfficer: "Pending Assignment",
    evidence: ["grant_allocation_sheet.xlsx"],
    rating: null,
    feedback: null,
    timeline: [
      { date: "08 August 2026", stage: "Complaint Submitted", desc: "Encrypted report received. Pending officer assignment." }
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
  name: "Rajesh Kumar",
  email: "rajesh.kumar@example.com",
  phone: "+91 98765 43210",
  nationalId: "IND-8849-2026",
  address: "74 Integrity Avenue, District Center",
  joinedDate: "January 2026",
  avatarText: "RK"
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
  return JSON.parse(data);
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
