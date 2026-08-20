<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CCMS | Officer Profile</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Orbitron:wght@600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/officer.css" />
  </head>
  <body>
    <div class="officer-app">
      <aside class="officer-sidebar">
        <div class="officer-sidebar-header">
          <div class="brand-mark">CCMS</div>
          <div class="brand-copy"><span>Officer Portal</span></div>
        </div>
        <nav class="officer-nav">
          <a href="./dashboard.php" class="nav-link"><i class="fa-solid fa-gauge"></i> <span>Dashboard</span></a>
          <a href="./assigned-cases.php" class="nav-link"><i class="fa-solid fa-briefcase"></i> <span>Assigned Cases</span></a>
          <a href="./priority-queue.php" class="nav-link"><i class="fa-solid fa-list-ol"></i> <span>Priority Queue</span></a>
          <a href="./investigation.php" class="nav-link"><i class="fa-solid fa-magnifying-glass"></i> <span>Investigation</span></a>
          <a href="./evidence.php" class="nav-link"><i class="fa-solid fa-folder-open"></i> <span>Evidence</span></a>
          <a href="./history.php" class="nav-link"><i class="fa-solid fa-clock-rotate-left"></i> <span>Investigation History</span></a>
          <a href="./reports.php" class="nav-link"><i class="fa-solid fa-chart-column"></i> <span>Reports</span></a>
          <a href="./notifications.php" class="nav-link"><i class="fa-solid fa-bell"></i> <span>Notifications</span></a>
          <a href="./profile.php" class="nav-link active"><i class="fa-solid fa-user"></i> <span>My Profile</span></a>
          <a href="../index.php" class="nav-link logout-link"><i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span></a>
        </nav>
      </aside>

      <main class="officer-main">
        <header class="officer-topbar">
          <div class="topbar-search-wrap"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Global complaint search..." /></div>
          <div class="topbar-actions">
            <button class="icon-button"><i class="fa-solid fa-bell"></i><span class="badge-dot">3</span></button>
            <div class="user-summary"><div class="user-avatar">AR</div><div class="user-meta"><strong>Asif Rahman</strong><span>Senior Investigating Officer</span></div></div>
            <div class="dept-pill"><span class="dept-label">Department</span><strong>Procurement Integrity</strong></div>
          </div>
        </header>

        <div class="officer-workspace">
          <div class="page-shell">
            <div class="page-header">
              <div>
                <p class="eyebrow">Account</p>
                <h1>My Profile</h1>
              </div>
              <button class="secondary-button"><i class="fa-solid fa-pen-to-square"></i> Edit Profile</button>
            </div>

            <div class="page-card">
              <div class="profile-card-compact">
                <div class="profile-avatar-large">AR</div>
                <div>
                  <h3 style="color:#0f172a; margin-bottom:6px;">Asif Rahman</h3>
                  <p style="color:#64748b; font-weight:600;">Senior Investigating Officer</p>
                </div>
              </div>

              <div class="profile-details" style="margin-top:20px;">
                <div class="form-field"><label>Officer ID</label><input type="text" value="OFF-1042" /></div>
                <div class="form-field"><label>Department</label><input type="text" value="Procurement Integrity" /></div>
                <div class="form-field"><label>Designation</label><input type="text" value="Senior Investigation Officer" /></div>
                <div class="form-field"><label>Email</label><input type="email" value="asif.rahman@ccms.gov" /></div>
                <div class="form-field"><label>Phone</label><input type="text" value="+880 1712 998877" /></div>
                <div class="form-field"><label>Password</label><input type="password" value="password123" /></div>
              </div>

              <div class="form-actions">
                <button class="secondary-button">Cancel</button>
                <button class="primary-button">Save Changes</button>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <script src="./js/officer.js"></script>
  </body>
</html>

