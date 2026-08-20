<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Resolution Feedback &amp; Rating | CCMS</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Orbitron:wght@600;700;900&display=swap" rel="stylesheet" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="css/citizen.css" />

  <style>
    .star-rating i {
      font-size: 2rem;
      color: #cbd5e1;
      cursor: pointer;
      transition: color 0.2s;
    }
    .star-rating i.selected, .star-rating i:hover {
      color: #f59e0b;
    }
  </style>
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
      <a href="evidence.php" class="sidebar-link"><i class="fas fa-photo-film"></i> Evidence Gallery</a>

      <div class="nav-section-title">Engage &amp; Support</div>
      <a href="feedback.php" class="sidebar-link active"><i class="fas fa-star"></i> Feedback &amp; Rating</a>
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
        <h5 class="fw-bold mb-0 text-heading">Resolution Feedback</h5>
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
      <div class="page-header">
        <h1 class="page-title">Citizen Satisfaction Feedback</h1>
        <p class="page-subtitle">Rate the resolution efficiency and vigilance officer response for your closed cases.</p>
      </div>

      <div class="row g-4">
        <!-- Left Feedback Submission Form -->
        <div class="col-lg-6">
          <div class="card-custom">
            <h5 class="fw-bold text-heading mb-3"><i class="fas fa-pen-to-square text-primary me-2"></i>Submit Feedback</h5>
            <form onsubmit="submitFeedback(event)">
              <div class="mb-3">
                <label class="form-label small fw-bold text-heading">Select Resolved Complaint</label>
                <select class="form-select" id="feedbackComplaintSelect" required>
                  <option value="CCMS-2026-8902">CCMS-2026-8902 (Land Registration Title Deed Bribe Extortion)</option>
                </select>
              </div>

              <div class="mb-3 text-center p-3 rounded bg-subtle border">
                <label class="form-label small fw-bold text-heading d-block mb-2">Overall Satisfaction Rating</label>
                <div class="star-rating d-flex justify-content-center gap-2" id="starRatingGroup">
                  <i class="fas fa-star selected" data-value="1"></i>
                  <i class="fas fa-star selected" data-value="2"></i>
                  <i class="fas fa-star selected" data-value="3"></i>
                  <i class="fas fa-star selected" data-value="4"></i>
                  <i class="fas fa-star selected" data-value="5"></i>
                </div>
                <div class="text-muted small mt-2 fw-bold" id="ratingTextDisplay">5 - Excellent Resolution</div>
              </div>

              <div class="mb-3">
                <label class="form-label small fw-bold text-heading">Feedback &amp; Officer Comments</label>
                <textarea class="form-control" id="feedbackComments" rows="4" placeholder="Share your experience regarding SLA timeliness, confidentiality, and officer professionalism..." required>Resolved quickly without compromising my identity. Thank you!</textarea>
              </div>

              <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill" style="background:var(--gradient-brand); border:none;">
                Submit Rating &amp; Review <i class="fas fa-paper-plane ms-1"></i>
              </button>
            </form>
          </div>
        </div>

        <!-- Right Submitted Feedback Preview -->
        <div class="col-lg-6">
          <div class="card-custom">
            <h5 class="fw-bold text-heading mb-3"><i class="fas fa-comments text-primary me-2"></i>My Recent Reviews</h5>
            <div id="reviewsList">
              <div class="p-3 rounded bg-subtle border mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="font-monospace fw-bold text-primary">#CCMS-2026-8902</span>
                  <div class="text-warning small"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                </div>
                <p class="text-muted small mb-1">"Resolved quickly without compromising my identity. Thank you!"</p>
                <div class="text-muted" style="font-size:0.75rem;">Submitted on: 18 July 2026</div>
              </div>
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
  let selectedRating = 5;

  $(document).ready(function() {
    const user = getStoredUser();
    $('#topName').text(user.name);
    $('#topAvatar').text(user.avatarText);

    // Interactive Star Hover & Select
    $('.star-rating i').click(function() {
      selectedRating = $(this).data('value');
      $('.star-rating i').each(function() {
        if ($(this).data('value') <= selectedRating) {
          $(this).addClass('selected');
        } else {
          $(this).removeClass('selected');
        }
      });
      const texts = ["", "1 - Poor", "2 - Fair", "3 - Average", "4 - Good", "5 - Excellent Resolution"];
      $('#ratingTextDisplay').text(texts[selectedRating]);
    });
  });

  function submitFeedback(e) {
    e.preventDefault();
    const complaintId = $('#feedbackComplaintSelect').val();
    const comments = $('#feedbackComments').val();

    const complaints = getStoredComplaints();
    const c = complaints.find(item => item.id === complaintId);
    if (c) {
      c.rating = selectedRating;
      c.feedback = comments;
      saveComplaints(complaints);
    }

    alert("Thank you for your feedback!");
    window.location.reload();
  }
</script>
</body>
</html>

