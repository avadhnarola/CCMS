<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CCMS | Officer Dashboard</title>
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
          <div class="brand-copy">
            <span>Officer Portal</span>
          </div>
        </div>

        <nav class="officer-nav" aria-label="Officer main navigation">
          <a href="./dashboard.php" class="nav-link active"><i class="fa-solid fa-gauge"></i> <span>Dashboard</span></a>
          <a href="./assigned-cases.php" class="nav-link"><i class="fa-solid fa-briefcase"></i> <span>Assigned Cases</span></a>
          <a href="./priority-queue.php" class="nav-link"><i class="fa-solid fa-list-ol"></i> <span>Priority Queue</span></a>
          <a href="./investigation.php" class="nav-link"><i class="fa-solid fa-magnifying-glass"></i> <span>Investigation</span></a>
          <a href="./evidence.php" class="nav-link"><i class="fa-solid fa-folder-open"></i> <span>Evidence</span></a>
          <a href="./history.php" class="nav-link"><i class="fa-solid fa-clock-rotate-left"></i> <span>Investigation History</span></a>
          <a href="./reports.php" class="nav-link"><i class="fa-solid fa-chart-column"></i> <span>Reports</span></a>
          <a href="./notifications.php" class="nav-link"><i class="fa-solid fa-bell"></i> <span>Notifications</span></a>
          <a href="./profile.php" class="nav-link"><i class="fa-solid fa-user"></i> <span>My Profile</span></a>
          <a href="../index.php" class="nav-link logout-link"><i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span></a>
        </nav>

        <div class="sidebar-status-card">
          <div class="status-row">
            <span class="mini-label">Availability</span>
            <span class="status-pill online">Available</span>
          </div>
          <div class="status-row">
            <span class="mini-label">Department</span>
            <strong>Anti-Corruption Wing</strong>
          </div>
        </div>
      </aside>

      <main class="officer-main">
        <header class="officer-topbar">
          <div class="topbar-search-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Global complaint search..." aria-label="Global complaint search" />
          </div>

          <div class="topbar-actions">
            <button class="icon-button" aria-label="Notifications">
              <i class="fa-solid fa-bell"></i>
              <span class="badge-dot">3</span>
            </button>

            <div class="user-summary">
              <div class="user-avatar">AR</div>
              <div class="user-meta">
                <strong>Asif Rahman</strong>
                <span>Senior Investigating Officer</span>
              </div>
            </div>

            <div class="dept-pill">
              <span class="dept-label">Department</span>
              <strong>Procurement Integrity</strong>
            </div>
          </div>
        </header>

        <div class="officer-workspace">
          <section class="panel-section dashboard-section">
            <div class="section-header">
              <div>
                <p class="eyebrow">Operational Overview</p>
                <h1>Investigation Dashboard</h1>
              </div>
              <a href="./assigned-cases.php" class="primary-button"><i class="fa-solid fa-plus"></i> New Case Review</a>
            </div>

            <div class="stats-grid">
              <article class="stat-card">
                <div class="stat-icon blue"><i class="fa-solid fa-clipboard-check"></i></div>
                <div>
                  <span class="stat-label">Assigned Cases</span>
                  <strong>128</strong>
                </div>
              </article>
              <article class="stat-card">
                <div class="stat-icon amber"><i class="fa-solid fa-hourglass-half"></i></div>
                <div>
                  <span class="stat-label">Pending Investigation</span>
                  <strong>42</strong>
                </div>
              </article>
              <article class="stat-card">
                <div class="stat-icon red"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div>
                  <span class="stat-label">High Priority</span>
                  <strong>18</strong>
                </div>
              </article>
              <article class="stat-card">
                <div class="stat-icon dark"><i class="fa-solid fa-skull-crossbones"></i></div>
                <div>
                  <span class="stat-label">Critical Cases</span>
                  <strong>06</strong>
                </div>
              </article>
              <article class="stat-card">
                <div class="stat-icon green"><i class="fa-solid fa-circle-check"></i></div>
                <div>
                  <span class="stat-label">Resolved Cases</span>
                  <strong>76</strong>
                </div>
              </article>
            </div>

            <div class="dashboard-grid">
              <div class="panel-card workload-panel">
                <div class="panel-card-header">
                  <h3>Current Workload</h3>
                  <span class="muted-tag">This week</span>
                </div>
                <div class="workload-visual">
                  <div class="workload-ring">
                    <div class="ring-inner">
                      <strong>68%</strong>
                      <span>Load</span>
                    </div>
                  </div>
                  <div class="workload-breakdown">
                    <div class="workload-row"><span class="dot active"></span> Active Cases <strong>34</strong></div>
                    <div class="workload-row"><span class="dot done"></span> Completed Cases <strong>22</strong></div>
                    <div class="workload-row"><span class="dot pending"></span> Pending Cases <strong>19</strong></div>
                  </div>
                </div>
              </div>

              <div class="panel-card queue-panel">
                <div class="panel-card-header">
                  <h3>Priority Queue</h3>
                  <a href="./priority-queue.php" class="secondary-button">Process Next Case</a>
                </div>
                <div class="queue-stack">
                  <div class="queue-line critical"><span>CRITICAL</span></div>
                  <div class="queue-line high"><span>HIGH</span></div>
                  <div class="queue-line medium"><span>MEDIUM</span></div>
                  <div class="queue-line low"><span>LOW</span></div>
                </div>
                <div class="priority-list">
                  <div class="priority-item active">
                    <div>
                      <span class="complaint-id">C-1024</span>
                      <h4>Bribery Complaint</h4>
                    </div>
                    <span class="priority-badge critical">CRITICAL</span>
                  </div>
                  <div class="priority-item">
                    <div>
                      <span class="complaint-id">C-1032</span>
                      <h4>Tender Fraud</h4>
                    </div>
                    <span class="priority-badge high">HIGH</span>
                  </div>
                  <div class="priority-item">
                    <div>
                      <span class="complaint-id">C-1038</span>
                      <h4>Misconduct</h4>
                    </div>
                    <span class="priority-badge medium">MEDIUM</span>
                  </div>
                  <div class="priority-item">
                    <div>
                      <span class="complaint-id">C-1041</span>
                      <h4>Procurement Delay</h4>
                    </div>
                    <span class="priority-badge low">LOW</span>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </main>
    </div>
    <script src="./js/officer.js"></script>
  </body>
</html>

