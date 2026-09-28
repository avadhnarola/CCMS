/* ============================================================
   CCMS - CORRUPTION COMPLAINT MANAGEMENT SYSTEM
   UNIFIED CLIENT SCRIPT & INTERACTION ENGINE (MAIN.JS)
============================================================ */

// 1. Theme Management (Light  ↔  Dark Green)
function initTheme() {
  const savedTheme = localStorage.getItem('ccms_theme') || 'light';
  // Only allow 'light' or 'dark-green' — reject any other value
  const safeTheme = savedTheme === 'dark-green' ? 'dark-green' : 'light';
  applyTheme(safeTheme);

  document.querySelectorAll('.theme-toggle-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
      const newTheme = currentTheme === 'dark-green' ? 'light' : 'dark-green';
      applyTheme(newTheme);
      localStorage.setItem('ccms_theme', newTheme);
    });
  });
}

function applyTheme(theme) {
  document.documentElement.setAttribute('data-theme', theme);
  const icons = document.querySelectorAll('.theme-toggle-btn i');
  icons.forEach(icon => {
    if (theme === 'dark-green') {
      icon.className = 'fas fa-leaf';
      icon.style.color = '#34d399';
    } else {
      icon.className = 'fas fa-sun';
      icon.style.color = '#d97706';
    }
  });
}

// 2. Multilingual Support
const TRANSLATIONS = {
  en: {
    hero_title: "Zero-Tolerance Anti-Corruption Command System",
    hero_sub: "Report corruption securely with military-grade AES-256 encryption. Track investigation progress in real time with complete whistleblower protection.",
    file_btn: "File Encrypted Complaint",
    track_btn: "Track Complaint Status",
    stats_total: "Complaints Registered",
    stats_resolved: "Resolved & Sanctioned",
    stats_officers: "Active Vigilance Officers",
    stats_rate: "Resolution Rate"
  },
  hi: {
    hero_title: "भ्रष्टाचार मुक्त भारत - सतर्कता एवं शिकायत कमान प्रणाली",
    hero_sub: "सैन्य स्तर के AES-256 एन्क्रिप्शन के साथ भ्रष्टाचार की सुरक्षित रिपोर्ट करें। पूर्ण व्हिसलब्लोअर सुरक्षा के साथ जांच की प्रगति को ट्रैक करें।",
    file_btn: "सुरक्षित शिकायत दर्ज करें",
    track_btn: "शिकायत की स्थिति ट्रैक करें",
    stats_total: "कुल पंजीकृत शिकायतें",
    stats_resolved: "सफलतापूर्वक हल की गईं",
    stats_officers: "सक्रिय सतर्कता अधिकारी",
    stats_rate: "निवारण दर"
  },
  gu: {
    hero_title: "ભ્રષ્ટાચાર મુક્ત શાસન - તકેદારી અને ફરિયાદ વ્યવસ્થાપન સિસ્ટમ",
    hero_sub: "સંપૂર્ણ ગુપ્તતા અને AES-256 એન્ક્રિપ્શન સાથે ભ્રષ્ટાચારની ફરિયાદ નોંધાવો અને લાઇવ કેસ ટ્રેકિંગ મેળવો.",
    file_btn: "નવી ફરિયાદ નોંધાવો",
    track_btn: "ફરિયાદ સ્થિતિ તપાસો",
    stats_total: "કુલ ફરિયાદો નોંધાઈ",
    stats_resolved: "ઉકેલાયેલ કેસો",
    stats_officers: "તકેદારી અધિકારીઓ",
    stats_rate: "નિરાકરણ દર"
  }
};

function initLanguage() {
  const langSelect = document.getElementById('langSelect');
  if (!langSelect) return;

  const savedLang = localStorage.getItem('ccms_lang') || 'en';
  langSelect.value = savedLang;
  applyLanguage(savedLang);

  langSelect.addEventListener('change', (e) => {
    const lang = e.target.value;
    localStorage.setItem('ccms_lang', lang);
    applyLanguage(lang);
  });
}

function applyLanguage(lang) {
  const dict = TRANSLATIONS[lang] || TRANSLATIONS['en'];
  document.querySelectorAll('[data-i18n]').forEach(elem => {
    const key = elem.getAttribute('data-i18n');
    if (dict[key]) {
      elem.textContent = dict[key];
    }
  });
}

// 3. Universal Table Filter
function initTableFilter(searchInputId, tableId) {
  const searchInput = document.getElementById(searchInputId);
  const table = document.getElementById(tableId);
  if (!searchInput || !table) return;

  searchInput.addEventListener('keyup', () => {
    const query = searchInput.value.toLowerCase();
    const rows = table.querySelectorAll('tbody tr');

    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(query) ? '' : 'none';
    });
  });
}

// 4. Drag & Drop File Upload with Preview
function initFileDropzone() {
  const dropzone = document.getElementById('fileDropzone');
  const fileInput = document.getElementById('evidenceFileInput');
  const fileListContainer = document.getElementById('fileListPreview');

  if (!dropzone || !fileInput) return;

  ['dragenter', 'dragover'].forEach(eventName => {
    dropzone.addEventListener(eventName, (e) => {
      e.preventDefault();
      dropzone.classList.add('dragover');
    }, false);
  });

  ['dragleave', 'drop'].forEach(eventName => {
    dropzone.addEventListener(eventName, (e) => {
      e.preventDefault();
      dropzone.classList.remove('dragover');
    }, false);
  });

  dropzone.addEventListener('drop', (e) => {
    const dt = e.dataTransfer;
    const files = dt.files;
    fileInput.files = files;
    renderFilePreviews(files, fileListContainer);
  });

  fileInput.addEventListener('change', () => {
    renderFilePreviews(fileInput.files, fileListContainer);
  });
}

function renderFilePreviews(files, container) {
  if (!container) return;
  container.innerHTML = '';
  if (!files || files.length === 0) return;

  Array.from(files).forEach((file, index) => {
    const fileCard = document.createElement('div');
    fileCard.className = 'd-flex align-items-center justify-content-between p-2 mb-2 rounded bg-subtle border';
    fileCard.style.fontSize = '0.85rem';

    const sizeKB = (file.size / 1024).toFixed(1);
    let iconClass = 'fa-file-lines';
    if (file.type.includes('image')) iconClass = 'fa-file-image text-primary';
    else if (file.type.includes('audio')) iconClass = 'fa-file-audio text-warning';
    else if (file.type.includes('video')) iconClass = 'fa-file-video text-danger';
    else if (file.type.includes('pdf')) iconClass = 'fa-file-pdf text-danger';

    fileCard.innerHTML = `
      <div class="d-flex align-items-center gap-2 overflow-hidden">
        <i class="fas ${iconClass} fs-5"></i>
        <div class="text-truncate">
          <div class="fw-bold text-heading text-truncate">${file.name}</div>
          <span class="text-muted" style="font-size:0.75rem;">${sizeKB} KB</span>
        </div>
      </div>
      <span class="badge bg-success-subtle text-success border border-success-subtle">Ready</span>
    `;
    container.appendChild(fileCard);
  });
}

// 5. Printable Receipt / Case Dossier Generator
function printComplaintSlip(complaintId) {
  window.print();
}

// 6. DOM Initialization on Load
document.addEventListener('DOMContentLoaded', () => {
  initTheme();
  initLanguage();
  initFileDropzone();

  // Initialize generic table filters if elements exist
  initTableFilter('searchComplaintsInput', 'complaintsTable');
  initTableFilter('searchOfficersInput', 'officersTable');
  initTableFilter('searchCitizensInput', 'citizensTable');

  // Flash alerts auto-dismiss after 5s
  setTimeout(() => {
    document.querySelectorAll('.alert-dismissible').forEach(alert => {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    });
  }, 5000);
});
