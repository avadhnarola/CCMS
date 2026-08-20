<?php
// Dynamic active page detection
$currentPage = basename($_SERVER['SCRIPT_NAME']);
?>
<!-- SIDEBAR NAVIGATION -->
<aside class="app-sidebar" id="appSidebar">
  <div class="sidebar-header flex-column align-items-start">
    <div class="d-flex align-items-center justify-content-between w-100 mb-1">
      <a href="index.php" class="sidebar-logo">CCMS</a>
      <span class="sidebar-badge">CITIZEN</span>
    </div>
    <div class="text-info small fw-semibold" style="letter-spacing: 1px; font-size: 0.65rem; text-transform: uppercase;">WHISTLEBLOWER PORTAL</div>

    <!-- User Info Badge -->
    <div class="mt-3 p-2 rounded w-100 d-flex align-items-center gap-2" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
      <div class="position-relative">
        <div class="user-avatar-img" id="sideAvatar">NAS</div>
        <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-dark rounded-circle"></span>
      </div>
      <div class="overflow-hidden">
        <div class="fw-bold text-white small text-truncate" id="sideUserName">Narola Avadh Shaileshbhai</div>
        <div class="text-info small" style="font-size:0.7rem;"><i class="fas fa-shield-alt text-info me-1"></i> Verified Citizen</div>
      </div>
    </div>
  </div>

  <div class="sidebar-nav">
    <div class="nav-section-title">MAIN DASHBOARD</div>
    <a href="index.php" class="sidebar-link <?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>"><i class="fas fa-chart-pie"></i> Analytics &amp; Overview</a>
    <a href="file-complaint.php" class="sidebar-link <?php echo ($currentPage == 'file-complaint.php') ? 'active' : ''; ?>"><i class="fas fa-plus-circle"></i> File New Complaint</a>
    <a href="my-complaints.php" class="sidebar-link <?php echo ($currentPage == 'my-complaints.php') ? 'active' : ''; ?>"><i class="fas fa-folder-open"></i> My Complaints</a>
    <a href="track.php" class="sidebar-link <?php echo ($currentPage == 'track.php') ? 'active' : ''; ?>"><i class="fas fa-route"></i> Track Complaint</a>
    <a href="evidence.php" class="sidebar-link <?php echo ($currentPage == 'evidence.php') ? 'active' : ''; ?>"><i class="fas fa-photo-film"></i> Evidence Gallery</a>

    <div class="nav-section-title">ENGAGE &amp; SUPPORT</div>
    <a href="feedback.php" class="sidebar-link <?php echo ($currentPage == 'feedback.php') ? 'active' : ''; ?>"><i class="fas fa-star"></i> Feedback &amp; Rating</a>
    <a href="notifications.php" class="sidebar-link <?php echo ($currentPage == 'notifications.php') ? 'active' : ''; ?>"><i class="fas fa-bell"></i> Notifications <span class="badge bg-danger rounded-pill ms-auto" id="unreadBadgeNav" style="font-size:0.65rem;">3</span></a>
    <a href="help.php" class="sidebar-link <?php echo ($currentPage == 'help.php') ? 'active' : ''; ?>"><i class="fas fa-headset"></i> AI Assistance &amp; Help</a>
    <a href="contact.php" class="sidebar-link <?php echo ($currentPage == 'contact.php') ? 'active' : ''; ?>"><i class="fas fa-envelope"></i> Contact Vigilance</a>

    <div class="nav-section-title">ACCOUNT SETTINGS</div>
    <a href="profile.php" class="sidebar-link <?php echo ($currentPage == 'profile.php') ? 'active' : ''; ?>"><i class="fas fa-user-gear"></i> Citizen Profile</a>
    <a href="login.php" class="sidebar-link text-danger" onclick="localStorage.removeItem('ccms_loggedIn');"><i class="fas fa-arrow-right-from-bracket"></i> Sign Out</a>
  </div>

  <div class="sidebar-footer">
    <div class="text-white small fw-bold"><i class="fas fa-lock text-success me-1"></i> Zero-Knowledge Encryption</div>
    <div class="text-muted" style="font-size:0.7rem;">IP Scrubbed • AES-256 Protocol</div>
  </div>
</aside>
