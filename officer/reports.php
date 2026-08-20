<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CCMS | Officer Reports</title>
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
          <a href="./reports.php" class="nav-link active"><i class="fa-solid fa-chart-column"></i> <span>Reports</span></a>
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
                <p class="eyebrow">Performance Metrics</p>
                <h1>Reports</h1>
              </div>
              <button class="primary-button"><i class="fa-solid fa-print"></i> Print Report</button>
            </div>

            <div class="reports-grid">
              <article class="report-card">
                <h3>Cases Completed</h3>
                <strong>76</strong>
                <div class="sparkline"></div>
              </article>
              <article class="report-card">
                <h3>Average Resolution Time</h3>
                <strong>12.4 days</strong>
                <div class="sparkline"></div>
              </article>
              <article class="report-card">
                <h3>Pending Cases</h3>
                <strong>42</strong>
                <div class="sparkline"></div>
              </article>
              <article class="report-card">
                <h3>Cases by Priority</h3>
                <ul class="priority-summary">
                  <li>Critical <span>06</span></li>
                  <li>High <span>18</span></li>
                  <li>Medium <span>32</span></li>
                  <li>Low <span>24</span></li>
                </ul>
              </article>
              <article class="report-card wide">
                <h3>Monthly Performance</h3>
                <div class="monthly-bars">
                  <span style="height: 45%"></span>
                  <span style="height: 60%"></span>
                  <span style="height: 50%"></span>
                  <span style="height: 75%"></span>
                  <span style="height: 88%"></span>
                  <span style="height: 72%"></span>
                </div>
              </article>
            </div>

            <div class="page-card">
              <h3>Summary</h3>
              <div class="report-summary">
                <div class="report-metric"><span>Open Cases</span><strong>18</strong></div>
                <div class="report-metric"><span>Resolved This Month</span><strong>26</strong></div>
                <div class="report-metric"><span>Avg. Case Load</span><strong>14</strong></div>
                <div class="report-metric"><span>Critical Review</span><strong>03</strong></div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <script src="./js/officer.js"></script>
  </body>
</html>

