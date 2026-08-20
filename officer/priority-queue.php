<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CCMS | Priority Queue</title>
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
          <a href="./priority-queue.php" class="nav-link active"><i class="fa-solid fa-list-ol"></i> <span>Priority Queue</span></a>
          <a href="./investigation.php" class="nav-link"><i class="fa-solid fa-magnifying-glass"></i> <span>Investigation</span></a>
          <a href="./evidence.php" class="nav-link"><i class="fa-solid fa-folder-open"></i> <span>Evidence</span></a>
          <a href="./history.php" class="nav-link"><i class="fa-solid fa-clock-rotate-left"></i> <span>Investigation History</span></a>
          <a href="./reports.php" class="nav-link"><i class="fa-solid fa-chart-column"></i> <span>Reports</span></a>
          <a href="./notifications.php" class="nav-link"><i class="fa-solid fa-bell"></i> <span>Notifications</span></a>
          <a href="./profile.php" class="nav-link"><i class="fa-solid fa-user"></i> <span>My Profile</span></a>
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
                <p class="eyebrow">Queue Management</p>
                <h1>Priority Queue</h1>
              </div>
              <button class="primary-button process-next"><i class="fa-solid fa-arrow-right"></i> Process Next Case</button>
            </div>

            <div class="page-content-grid">
              <div class="page-card">
                <div class="queue-stack">
                  <div class="queue-line critical"><span>CRITICAL</span></div>
                  <div class="queue-line high"><span>HIGH</span></div>
                  <div class="queue-line medium"><span>MEDIUM</span></div>
                  <div class="queue-line low"><span>LOW</span></div>
                </div>
                <div class="queue-card-list">
                  <div class="queue-card highlight">
                    <div>
                      <div class="queue-title">C-1024 | Bribery Complaint</div>
                      <div class="queue-meta">Department: Procurement Integrity Â· Submitted: 08 Aug 2026</div>
                    </div>
                    <span class="priority-badge critical">CRITICAL</span>
                  </div>
                  <div class="queue-card">
                    <div>
                      <div class="queue-title">C-1032 | Tender Fraud</div>
                      <div class="queue-meta">Department: Finance Audit Â· Submitted: 05 Aug 2026</div>
                    </div>
                    <span class="priority-badge high">HIGH</span>
                  </div>
                  <div class="queue-card">
                    <div>
                      <div class="queue-title">C-1038 | Misconduct</div>
                      <div class="queue-meta">Department: Ethics Desk Â· Submitted: 02 Aug 2026</div>
                    </div>
                    <span class="priority-badge medium">MEDIUM</span>
                  </div>
                  <div class="queue-card">
                    <div>
                      <div class="queue-title">C-1041 | Procurement Delay</div>
                      <div class="queue-meta">Department: Administration Â· Submitted: 28 Jul 2026</div>
                    </div>
                    <span class="priority-badge low">LOW</span>
                  </div>
                </div>
              </div>

              <div class="page-card">
                <h3>Queue Summary</h3>
                <div class="case-meta-list" style="margin-top:16px;">
                  <div class="case-meta-item"><span>Critical</span><strong>06</strong></div>
                  <div class="case-meta-item"><span>High</span><strong>18</strong></div>
                  <div class="case-meta-item"><span>Medium</span><strong>32</strong></div>
                  <div class="case-meta-item"><span>Low</span><strong>24</strong></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <script src="./js/officer.js"></script>
  </body>
</html>

