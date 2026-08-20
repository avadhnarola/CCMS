<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Evidence Gallery | CCMS</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Orbitron:wght@600;700;900&display=swap" rel="stylesheet" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="css/citizen.css" />
</head>
<body>

<div class="app-wrapper">
  <!-- SIDEBAR NAVIGATION -->
  <aside class="app-sidebar" id="appSidebar">
    <div class="sidebar-header flex-column align-items-start">
      <div class="d-flex align-items-center justify-content-between w-100 mb-1">
        <a href="index.php" class="sidebar-logo">CCMS</a>
        <span class="sidebar-badge">Citizen</span>
      </div>
      <div class="text-muted small fw-semibold" style="letter-spacing: 1px; font-size: 0.65rem; text-transform: uppercase;">Whistleblower Portal</div>

      <!-- User Info Badge -->
      <div class="mt-3 p-2 rounded w-100 d-flex align-items-center gap-2" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
        <div class="position-relative">
          <div class="user-avatar-img" id="sideAvatar">RK</div>
          <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-dark rounded-circle"></span>
        </div>
        <div class="overflow-hidden">
          <div class="fw-bold text-white small text-truncate" id="sideUserName">Rajesh Kumar</div>
          <div class="text-muted small" style="font-size:0.7rem;"><i class="fas fa-shield-alt text-info me-1"></i> Verified Citizen</div>
        </div>
      </div>
    </div>

    <div class="sidebar-nav">
      <div class="nav-section-title">Main Dashboard</div>
      <a href="index.php" class="sidebar-link"><i class="fas fa-chart-pie"></i> Analytics &amp; Overview</a>
      <a href="file-complaint.php" class="sidebar-link"><i class="fas fa-plus-circle"></i> File New Complaint</a>
      <a href="my-complaints.php" class="sidebar-link"><i class="fas fa-folder-open"></i> My Complaints</a>
      <a href="track.php" class="sidebar-link"><i class="fas fa-route"></i> Track Complaint</a>
      <a href="evidence.php" class="sidebar-link active"><i class="fas fa-photo-film"></i> Evidence Gallery</a>

      <div class="nav-section-title">Engage &amp; Support</div>
      <a href="feedback.php" class="sidebar-link"><i class="fas fa-star"></i> Feedback &amp; Rating</a>
      <a href="notifications.php" class="sidebar-link"><i class="fas fa-bell"></i> Notifications <span class="badge bg-danger rounded-pill ms-auto" style="font-size:0.65rem;">3</span></a>
      <a href="help.php" class="sidebar-link"><i class="fas fa-headset"></i> AI Assistance &amp; Help</a>
      <a href="contact.php" class="sidebar-link"><i class="fas fa-envelope"></i> Contact Vigilance</a>

      <div class="nav-section-title">Account Settings</div>
      <a href="profile.php" class="sidebar-link"><i class="fas fa-user-gear"></i> Citizen Profile</a>
      <a href="login.php" class="sidebar-link text-danger" onclick="localStorage.removeItem('ccms_loggedIn');"><i class="fas fa-arrow-right-from-bracket"></i> Sign Out</a>
    </div>

    <div class="sidebar-footer">
      <div class="text-white small fw-bold"><i class="fas fa-lock text-success me-1"></i> Zero-Knowledge Encryption</div>
      <div class="text-muted" style="font-size:0.7rem;">IP Scrubbed • AES-256 Protocol</div>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="app-main">
    <header class="app-topbar">
      <div class="d-flex align-items-center gap-3">
        <button class="btn d-lg-none text-heading p-0 fs-4" onclick="$('#appSidebar').toggleClass('show')">
          <i class="fas fa-bars"></i>
        </button>
        <h5 class="fw-bold mb-0 text-heading">Encrypted Evidence Gallery</h5>
      </div>

      <div class="d-flex align-items-center gap-3">
        <button class="theme-toggle-btn" id="themeToggleBtn" onclick="toggleTheme()" title="Toggle Theme">
          <i class="fas fa-moon"></i>
        </button>
        <a href="profile.php" class="user-profile-btn">
          <div class="user-avatar-img" id="topAvatar">RK</div>
          <span class="fw-bold small d-none d-md-inline text-heading" id="topName">Rajesh Kumar</span>
        </a>
      </div>
    </header>

    <div class="app-content">
      <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
          <h1 class="page-title">Evidence Vault Records</h1>
          <p class="page-subtitle">View and verify all attached documents, audio clips, video clips, and photo evidence.</p>
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-sm btn-primary rounded-pill active" onclick="filterGallery('all')">All Media</button>
          <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="filterGallery('doc')">Documents</button>
          <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="filterGallery('audio')">Audio</button>
          <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="filterGallery('video')">Videos</button>
        </div>
      </div>

      <!-- GALLERY GRID -->
      <div class="row g-4" id="galleryGrid">
        <div class="col-lg-4 col-md-6 gallery-item" data-type="doc">
          <div class="card-custom text-center">
            <div class="p-4 rounded bg-subtle mb-3">
              <i class="fas fa-file-pdf fa-3x text-danger"></i>
            </div>
            <h6 class="fw-bold text-heading mb-1">receipt_scan.pdf</h6>
            <div class="text-muted small mb-2">Complaint #CCMS-2026-8902</div>
            <span class="badge bg-success bg-opacity-10 text-success border mb-3">AES-256 Verified</span>
            <div>
              <button class="btn btn-sm btn-outline-primary rounded-pill w-100" onclick="alert('Viewing receipt_scan.pdf (Metadata Scrubbed)');">
                <i class="fas fa-eye me-1"></i> Preview File
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item" data-type="audio">
          <div class="card-custom text-center">
            <div class="p-4 rounded bg-subtle mb-3">
              <i class="fas fa-file-audio fa-3x text-primary"></i>
            </div>
            <h6 class="fw-bold text-heading mb-1">audio_recording.mp3</h6>
            <div class="text-muted small mb-2">Complaint #CCMS-2026-8902</div>
            <span class="badge bg-success bg-opacity-10 text-success border mb-3">Audio Masked</span>
            <div>
              <button class="btn btn-sm btn-outline-primary rounded-pill w-100" onclick="alert('Playing audio recording snippet...');">
                <i class="fas fa-play me-1"></i> Play Audio Clip
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item" data-type="doc">
          <div class="card-custom text-center">
            <div class="p-4 rounded bg-subtle mb-3">
              <i class="fas fa-file-word fa-3x text-info"></i>
            </div>
            <h6 class="fw-bold text-heading mb-1">tender_doc_v2.pdf</h6>
            <div class="text-muted small mb-2">Complaint #CCMS-2026-4412</div>
            <span class="badge bg-success bg-opacity-10 text-success border mb-3">AES-256 Verified</span>
            <div>
              <button class="btn btn-sm btn-outline-primary rounded-pill w-100" onclick="alert('Viewing tender_doc_v2.pdf...');">
                <i class="fas fa-eye me-1"></i> Preview File
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item" data-type="doc">
          <div class="card-custom text-center">
            <div class="p-4 rounded bg-subtle mb-3">
              <i class="fas fa-file-excel fa-3x text-success"></i>
            </div>
            <h6 class="fw-bold text-heading mb-1">grant_allocation_sheet.xlsx</h6>
            <div class="text-muted small mb-2">Complaint #CCMS-2026-9920</div>
            <span class="badge bg-success bg-opacity-10 text-success border mb-3">Spreadsheet Encrypted</span>
            <div>
              <button class="btn btn-sm btn-outline-primary rounded-pill w-100" onclick="alert('Viewing grant allocation sheet...');">
                <i class="fas fa-eye me-1"></i> Preview File
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/citizen.js"></script>
<script>
  $(document).ready(function() {
    const user = getStoredUser();
    $('#topName').text(user.name);
    $('#topAvatar').text(user.avatarText);
  });

  function filterGallery(type) {
    if (type === 'all') {
      $('.gallery-item').fadeIn();
    } else {
      $('.gallery-item').each(function() {
        if ($(this).data('type') === type) {
          $(this).fadeIn();
        } else {
          $(this).fadeOut();
        }
      });
    }
  }
</script>
</body>
</html>

