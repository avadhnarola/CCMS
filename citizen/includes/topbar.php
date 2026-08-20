<!-- TOP BAR INCLUDE -->
<header class="app-topbar">
  <div class="d-flex align-items-center gap-3">
    <button class="btn d-lg-none text-heading p-0 fs-4" onclick="$('#appSidebar').toggleClass('show')">
      <i class="fas fa-bars"></i>
    </button>
    <div class="position-relative d-none d-sm-block" style="width: 280px;">
      <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 0.85rem;"></i>
      <input type="text" class="form-control rounded-pill ps-5 bg-subtle border-0" placeholder="Search complaint ID or department..." style="font-size: 0.85rem;" />
    </div>
  </div>

  <div class="d-flex align-items-center gap-3">
    <!-- Theme Switcher Button -->
    <button class="theme-toggle-btn" id="themeToggleBtn" onclick="toggleTheme()" title="Toggle Theme">
      <i class="fas fa-moon"></i>
    </button>

    <!-- Notifications Quick Link -->
    <a href="notifications.php" class="position-relative text-heading p-2 fs-5" title="Notifications">
      <i class="far fa-bell"></i>
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem;">3</span>
    </a>

    <!-- User Profile Button -->
    <a href="profile.php" class="user-profile-btn ms-1">
      <div class="user-avatar-img" id="topAvatar">NAS</div>
      <span class="fw-bold small d-none d-md-inline text-heading me-1" id="topName">Narola Avadh Shaileshbhai</span>
      <i class="fas fa-chevron-down text-muted small"></i>
    </a>
  </div>
</header>
