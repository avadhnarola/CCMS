<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Track Complaint &amp; Linked List Timeline | CCMS</title>

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
      <a href="track.php" class="sidebar-link active"><i class="fas fa-route"></i> Track Complaint</a>
      <a href="evidence.php" class="sidebar-link"><i class="fas fa-photo-film"></i> Evidence Gallery</a>

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
        <h5 class="fw-bold mb-0 text-heading">Track Complaint Lifecycle</h5>
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
      <!-- Search Input Card -->
      <div class="card-custom mb-4">
        <h5 class="fw-bold text-heading mb-3"><i class="fas fa-magnifying-glass text-primary me-2"></i>Search Complaint by Key</h5>
        <form class="row g-2" onsubmit="event.preventDefault(); trackComplaint();">
          <div class="col-md-9">
            <input type="text" id="trackSearchInput" class="form-control form-control-lg font-monospace" placeholder="Enter 16-digit Complaint ID (e.g. CCMS-2026-8902)" value="CCMS-2026-8902" required />
          </div>
          <div class="col-md-3 d-grid">
            <button type="submit" class="btn btn-primary btn-lg fw-bold" style="background:var(--gradient-brand); border:none;">
              <i class="fas fa-route me-1"></i> Track Progress
            </button>
          </div>
        </form>
      </div>

      <!-- Complaint Details Result Container -->
      <div id="trackResultContainer">
        <!-- Linked List Timeline Visualizer -->
        <div class="card-custom mb-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="fw-bold mb-0 text-heading"><i class="fas fa-diagram-project text-primary me-2"></i>Linked List Case Progression Timeline</h5>
              <p class="text-muted small mb-0">Demonstrating linked timeline data nodes connected via pointer memory addresses (`next`).</p>
            </div>
            <span class="badge bg-primary bg-opacity-10 text-primary border" id="activeStatusBadge">In Progress</span>
          </div>

          <!-- Dynamic Linked List Visualizer -->
          <div id="linkedListVisualizerArea"></div>
        </div>

        <!-- Case Metadata Dossier -->
        <div class="card-custom">
          <h5 class="fw-bold text-heading mb-3"><i class="fas fa-file-invoice text-primary me-2"></i>Complaint Metadata</h5>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="p-3 rounded bg-subtle border">
                <div class="text-muted small">Complaint ID:</div>
                <div class="fw-bold font-monospace text-primary fs-5" id="metaId">CCMS-2026-8902</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded bg-subtle border">
                <div class="text-muted small">Assigned Anti-Corruption Officer:</div>
                <div class="fw-bold text-heading" id="metaOfficer">Insp. A. Verma</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="text-muted small">Department:</div>
              <div class="fw-bold text-heading" id="metaDept">Land &amp; Revenue Dept</div>
            </div>
            <div class="col-md-4">
              <div class="text-muted small">Incident Date:</div>
              <div class="fw-bold text-heading" id="metaDate">12 July 2026</div>
            </div>
            <div class="col-md-4">
              <div class="text-muted small">Location:</div>
              <div class="fw-bold text-heading" id="metaLoc">District Revenue Office</div>
            </div>
            <div class="col-12">
              <div class="text-muted small">Headline:</div>
              <div class="fw-bold text-heading fs-6" id="metaTitle">Land Registration Title Deed Bribe Extortion</div>
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

    // Read URL query parameter ?id=
    const urlParams = new URLSearchParams(window.location.search);
    const searchId = urlParams.get('id');
    if (searchId) {
      $('#trackSearchInput').val(searchId);
    }
    trackComplaint();
  });

  function trackComplaint() {
    const id = $('#trackSearchInput').val().trim();
    const complaints = getStoredComplaints();
    const c = complaints.find(item => item.id.toLowerCase() === id.toLowerCase());

    if (!c) {
      $('#trackResultContainer').html(`
        <div class="card-custom text-center py-5">
          <i class="fas fa-triangle-exclamation fa-3x text-warning mb-3"></i>
          <h5 class="fw-bold text-heading">Complaint ID Not Found</h5>
          <p class="text-muted small">Please verify your 16-digit tracking code and try again.</p>
        </div>
      `);
      return;
    }

    // Populate metadata
    $('#metaId').text(c.id);
    $('#metaTitle').text(c.title);
    $('#metaDept').text(c.department);
    $('#metaDate').text(c.date);
    $('#metaLoc').text(c.location);
    $('#metaOfficer').text(c.assignedOfficer);
    $('#activeStatusBadge').text(c.status);

    // Render Linked List Timeline UI Data Structure
    renderLinkedListTimeline('linkedListVisualizerArea', c.timeline);
  }
</script>
</body>
</html>

