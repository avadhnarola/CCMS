<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CCMS | Assigned Cases</title>
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
          <a href="./assigned-cases.php" class="nav-link active"><i class="fa-solid fa-briefcase"></i> <span>Assigned Cases</span></a>
          <a href="./priority-queue.php" class="nav-link"><i class="fa-solid fa-list-ol"></i> <span>Priority Queue</span></a>
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
                <p class="eyebrow">Case Management</p>
                <h1>Assigned Cases</h1>
              </div>
              <button class="primary-button"><i class="fa-solid fa-file-circle-plus"></i> Create New Case</button>
            </div>

            <div class="page-card">
              <div class="page-toolbar">
                <div class="toolbar-search">
                  <i class="fa-solid fa-magnifying-glass"></i>
                  <input type="text" placeholder="Search complaint..." />
                </div>
                <div class="toolbar-group">
                  <select><option>Priority</option><option>Critical</option><option>High</option><option>Medium</option><option>Low</option></select>
                  <select><option>Status</option><option>Assigned</option><option>Investigation Started</option><option>Evidence Verification</option><option>Resolved</option></select>
                  <select><option>Department</option><option>Procurement</option><option>Education</option><option>Health</option><option>Urban Planning</option></select>
                </div>
              </div>
            </div>

            <div class="table-wrap page-card">
              <table class="cases-table tight-table">
                <thead>
                  <tr>
                    <th>Complaint ID</th>
                    <th>Complaint Title</th>
                    <th>Category</th>
                    <th>Citizen</th>
                    <th>Location</th>
                    <th>Priority</th>
                    <th>Assigned Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>C-1024</td>
                    <td>Bribery Complaint</td>
                    <td>Corruption</td>
                    <td>Rafi M.</td>
                    <td>Dhaka</td>
                    <td><span class="priority-badge critical">CRITICAL</span></td>
                    <td>08 Aug 2026</td>
                    <td><span class="status-tag active">Investigation Started</span></td>
                    <td><a href="./investigation.php" class="table-button">View Case</a></td>
                  </tr>
                  <tr>
                    <td>C-1032</td>
                    <td>Tender Fraud</td>
                    <td>Procurement</td>
                    <td>Shamima K.</td>
                    <td>Chattogram</td>
                    <td><span class="priority-badge high">HIGH</span></td>
                    <td>05 Aug 2026</td>
                    <td><span class="status-tag pending">Evidence Collection</span></td>
                    <td><a href="./investigation.php" class="table-button">View Case</a></td>
                  </tr>
                  <tr>
                    <td>C-1038</td>
                    <td>Misconduct</td>
                    <td>Ethics</td>
                    <td>Nazmul R.</td>
                    <td>Khulna</td>
                    <td><span class="priority-badge medium">MEDIUM</span></td>
                    <td>02 Aug 2026</td>
                    <td><span class="status-tag review">Evidence Verification</span></td>
                    <td><a href="./investigation.php" class="table-button">View Case</a></td>
                  </tr>
                  <tr>
                    <td>C-1044</td>
                    <td>Procurement Delay</td>
                    <td>Administrative</td>
                    <td>Jannat A.</td>
                    <td>Rajshahi</td>
                    <td><span class="priority-badge low">LOW</span></td>
                    <td>28 Jul 2026</td>
                    <td><span class="status-tag done">Resolved</span></td>
                    <td><a href="./investigation.php" class="table-button">View Case</a></td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="table-footer">
              <span>Showing 1-4 of 128</span>
              <div class="pagination">
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn">Next</button>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <script src="./js/officer.js"></script>
  </body>
</html>

