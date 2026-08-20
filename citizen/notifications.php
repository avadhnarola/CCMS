<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Notifications &amp; Activity Alerts | CCMS</title>
  <link rel="icon" type="image/png" href="../logo.png" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Orbitron:wght@600;700;800;900&display=swap" rel="stylesheet" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/citizen.css" />

  <style>
    .filter-tab-btn {
      background: var(--bg-surface);
      border: 1px solid var(--border-color);
      color: var(--text-muted);
      font-size: 0.85rem;
      font-weight: 700;
      padding: 8px 18px;
      border-radius: 50px;
      transition: var(--transition);
      cursor: pointer;
    }
    .filter-tab-btn.active,
    .filter-tab-btn:hover {
      background: var(--gradient-brand);
      color: #fff;
      border-color: transparent;
      box-shadow: var(--shadow-hover);
    }
  </style>
</head>
<body>

<div class="app-wrapper">

  <!-- SIDEBAR NAVIGATION INCLUDE -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- MAIN CONTENT -->
  <main class="app-main">
    <!-- TOP BAR INCLUDE -->
    <?php include 'includes/topbar.php'; ?>

    <div class="app-content">

      <!-- PAGE HEADER -->
      <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
          <h1 class="page-title mb-1">Live Activity Alerts</h1>
          <p class="page-subtitle">Real-time status updates, officer assignments, and whistleblower security alerts.</p>
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-outline-primary fw-bold rounded-pill px-3" onclick="markAllAsRead()">
            <i class="fas fa-check-double me-1"></i> Mark All as Read
          </button>
          <button class="btn btn-subtle text-danger fw-bold rounded-pill px-3" onclick="clearAllNotifications()">
            <i class="fas fa-trash-can me-1"></i> Clear Feed
          </button>
        </div>
      </div>

      <!-- ALERT BANNER DEMO -->
      <div class="ccms-alert ccms-alert-info">
        <div class="ccms-alert-icon bg-info bg-opacity-10 text-info">
          <i class="fas fa-shield-cat"></i>
        </div>
        <div class="flex-grow-1">
          <div class="fw-bold text-heading small">Encrypted Vigilance Feed Active</div>
          <div class="text-muted small">All notifications are encrypted with your zero-knowledge key. No third-party tracking allowed.</div>
        </div>
        <button class="btn-close btn-close-sm" onclick="this.parentElement.remove()"></button>
      </div>

      <!-- FILTER TABS -->
      <div class="d-flex flex-wrap gap-2 mb-4">
        <button class="filter-tab-btn active" onclick="filterNotifs('all', this)">
          <i class="fas fa-layer-group me-1"></i> All Alerts
        </button>
        <button class="filter-tab-btn" onclick="filterNotifs('unread', this)">
          <i class="fas fa-bell me-1"></i> Unread Only
        </button>
        <button class="filter-tab-btn" onclick="filterNotifs('success', this)">
          <i class="fas fa-circle-check me-1"></i> Resolutions
        </button>
        <button class="filter-tab-btn" onclick="filterNotifs('info', this)">
          <i class="fas fa-user-shield me-1"></i> Officer Actions
        </button>
      </div>

      <!-- NOTIFICATION LIST CONTAINER -->
      <div id="fullNotificationFeed" class="d-flex flex-column gap-3">
        <!-- Dynamically Rendered via JS -->
      </div>

    </div>
  </main>
</div>

<!-- FOOTER INCLUDE -->
<?php include 'includes/footer.php'; ?>

<script>
  let currentFilter = 'all';

  $(document).ready(function() {
    const user = getStoredUser();
    $('#topName, #sideUserName').text(user.name);
    $('#topAvatar, #sideAvatar').text(user.avatarText);
    renderNotifications();
  });

  function renderNotifications() {
    const notifications = getStoredNotifications();
    
    // Default rich sample notifications if empty initially
    if (notifications.length === 0 && !localStorage.getItem("ccms_notif_cleared")) {
      const defaultRich = [
        { id: 1, text: "Complaint #CCMS-2026-8902 has been marked as RESOLVED by Anti-Corruption Bureau.", date: "Just now", unread: true, type: "success", tag: "Resolution" },
        { id: 2, text: "Field Officer Insp. A. Verma has been assigned to inquiry #CCMS-2026-4412.", date: "2 hours ago", unread: true, type: "info", tag: "Assignment" },
        { id: 3, text: "Evidence document 'tender_doc_v2.pdf' successfully verified with digital signature.", date: "1 day ago", unread: true, type: "warning", tag: "Evidence Verified" },
        { id: 4, text: "Security Alert: Zero-Knowledge keys backed up securely for your citizen account.", date: "3 days ago", unread: false, type: "primary", tag: "Security Protocol" }
      ];
      localStorage.setItem("ccms_notifications", JSON.stringify(defaultRich));
      return renderNotifications();
    }

    let filtered = notifications;
    if (currentFilter === 'unread') filtered = notifications.filter(n => n.unread);
    if (currentFilter === 'success') filtered = notifications.filter(n => n.type === 'success');
    if (currentFilter === 'info') filtered = notifications.filter(n => n.type === 'info' || n.type === 'primary');

    const unreadCount = notifications.filter(n => n.unread).length;
    $('#unreadBadgeNav').text(unreadCount);

    let html = '';
    if (filtered.length === 0) {
      html = `
        <div class="card-custom text-center py-5">
          <div class="p-3 rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex mb-3 fs-2">
            <i class="fas fa-bell-slash"></i>
          </div>
          <h5 class="fw-bold text-heading">No notifications found</h5>
          <p class="text-muted small mb-0">You're all caught up! New case updates and vigilance alerts will appear here.</p>
        </div>
      `;
    } else {
      filtered.forEach(n => {
        const typeClass = n.type || 'info';
        const icons = {
          success: 'fas fa-circle-check',
          info: 'fas fa-user-shield',
          warning: 'fas fa-triangle-exclamation',
          primary: 'fas fa-shield-halved',
          danger: 'fas fa-circle-exclamation'
        };

        const badgeStyle = {
          success: 'bg-success-subtle text-success border border-success-subtle',
          info: 'bg-info-subtle text-info border border-info-subtle',
          warning: 'bg-warning-subtle text-warning border border-warning-subtle',
          primary: 'bg-primary-subtle text-primary border border-primary-subtle',
          danger: 'bg-danger-subtle text-danger border border-danger-subtle'
        };

        html += `
          <div class="notif-card-premium ${n.unread ? 'unread' : ''}" id="notif-item-${n.id}">
            <div class="notif-icon-ring ${typeClass}">
              <i class="${icons[typeClass] || icons.info}"></i>
            </div>
            
            <div class="flex-grow-1 overflow-hidden">
              <div class="d-flex align-items-center gap-2 mb-1">
                <span class="notif-badge-pill ${badgeStyle[typeClass] || badgeStyle.info}">
                  ${n.tag || 'System Update'}
                </span>
                ${n.unread ? '<span class="badge bg-primary rounded-pill" style="font-size:0.6rem;">NEW</span>' : ''}
                <span class="text-muted ms-auto" style="font-size:0.75rem;"><i class="far fa-clock me-1"></i>${n.date}</span>
              </div>

              <div class="fw-bold text-heading ${n.unread ? 'fs-6' : 'small'} mb-2">${n.text}</div>

              <div class="d-flex gap-2">
                <a href="track.php" class="btn btn-sm btn-subtle text-primary fw-bold py-1 px-3">
                  <i class="fas fa-eye me-1"></i> View Case Details
                </a>
                ${n.unread ? `
                  <button class="btn btn-sm btn-light text-muted fw-bold py-1 px-3" onclick="markSingleRead(${n.id})">
                    <i class="fas fa-check me-1"></i> Mark Read
                  </button>
                ` : ''}
              </div>
            </div>
          </div>
        `;
      });
    }
    $('#fullNotificationFeed').html(html);
  }

  function filterNotifs(type, btn) {
    currentFilter = type;
    $('.filter-tab-btn').removeClass('active');
    $(btn).addClass('active');
    renderNotifications();
  }

  function markSingleRead(id) {
    const notifications = getStoredNotifications();
    const target = notifications.find(n => n.id === id);
    if (target) {
      target.unread = false;
      localStorage.setItem("ccms_notifications", JSON.stringify(notifications));
      renderNotifications();
      showCcmsToast("Notification marked as read", "success");
    }
  }

  function markAllAsRead() {
    const notifications = getStoredNotifications();
    notifications.forEach(n => n.unread = false);
    localStorage.setItem("ccms_notifications", JSON.stringify(notifications));
    renderNotifications();
    showCcmsToast("All notifications marked as read", "success", "Feed Updated");
  }

  function clearAllNotifications() {
    showCcmsConfirm("Clear Notification History", "Are you sure you want to clear your entire notification history?", function() {
      localStorage.setItem("ccms_notifications", JSON.stringify([]));
      localStorage.setItem("ccms_notif_cleared", "true");
      renderNotifications();
      showCcmsToast("Notification feed cleared", "info", "Feed Cleared");
    });
  }
</script>
</body>
</html>
