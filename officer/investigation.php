<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CCMS | Investigation Workspace</title>
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
          <a href="./investigation.php" class="nav-link active"><i class="fa-solid fa-magnifying-glass"></i> <span>Investigation</span></a>
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
                <p class="eyebrow">Case File</p>
                <h1>C-1024 | Bribery Complaint</h1>
              </div>
              <div class="case-header-actions">
                <span class="priority-badge critical">CRITICAL</span>
                <span class="status-tag active">Current Status: Investigation Started</span>
              </div>
            </div>

            <div class="page-content-grid">
              <div class="page-card">
                <h3>Complaint Information</h3>
                <div class="form-grid" style="margin-top:16px;">
                  <div class="form-field"><label>Citizen Name</label><input type="text" value="Rafi M." /></div>
                  <div class="form-field"><label>Department</label><input type="text" value="Procurement Integrity" /></div>
                  <div class="form-field"><label>Incident Date</label><input type="text" value="03 Aug 2026" /></div>
                  <div class="form-field"><label>Location</label><input type="text" value="Dhaka North" /></div>
                  <div class="form-field full"><label>Complaint Description</label><textarea>Alleged bribery in public contract approval related to procurement irregularities and duplicate invoices.</textarea></div>
                </div>
              </div>

              <div class="page-card">
                <h3>Case Summary</h3>
                <div class="detail-list" style="margin-top:16px;">
                  <div class="detail-item"><span>Assigned Officer</span><strong>Asif Rahman</strong></div>
                  <div class="detail-item"><span>Assignment Date</span><strong>08 Aug 2026</strong></div>
                  <div class="detail-item"><span>Priority</span><strong>Critical</strong></div>
                  <div class="detail-item"><span>Resolution Deadline</span><strong>15 Aug 2026</strong></div>
                </div>
              </div>
            </div>

            <div class="page-content-grid">
              <div class="page-card">
                <h3>Investigation Workspace</h3>
                <div class="form-grid" style="margin-top:16px;">
                  <div class="form-field"><button class="primary-button" type="button"><i class="fa-solid fa-play"></i> Start Investigation</button></div>
                  <div class="form-field"><button class="secondary-button" type="button"><i class="fa-solid fa-pen-to-square"></i> Add Investigation Note</button></div>
                  <div class="form-field"><button class="secondary-button" type="button"><i class="fa-solid fa-upload"></i> Upload Evidence</button></div>
                  <div class="form-field"><button class="status-button" type="button" data-modal-trigger="status-modal"><i class="fa-solid fa-arrow-progress"></i> Update Status</button></div>
                </div>
                <div class="timeline" style="margin-top:22px;">
                  <div class="timeline-item">
                    <div class="timeline-date">10 Aug 2026</div>
                    <div class="timeline-content"><strong>Investigation Started</strong></div>
                  </div>
                  <div class="timeline-item">
                    <div class="timeline-date">10 Aug 2026</div>
                    <div class="timeline-content"><strong>Evidence Reviewed</strong></div>
                  </div>
                  <div class="timeline-item">
                    <div class="timeline-date">11 Aug 2026</div>
                    <div class="timeline-content"><strong>Department Officer Interviewed</strong></div>
                  </div>
                </div>
              </div>

              <div class="page-card">
                <h3>Status Workflow</h3>
                <div class="case-stepper">
                  <span class="case-step active">Assigned</span>
                  <span class="case-step active">Investigation Started</span>
                  <span class="case-step">Evidence Collection</span>
                  <span class="case-step">Evidence Verification</span>
                  <span class="case-step">Resolved</span>
                  <span class="case-step">Closed</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>

    <div class="modal-backdrop" id="status-modal" aria-hidden="true">
      <div class="status-modal" role="dialog" aria-modal="true" aria-labelledby="status-modal-title">
        <div class="modal-header">
          <h3 id="status-modal-title">Status Update</h3>
          <button class="close-modal" aria-label="Close status modal">Ã—</button>
        </div>
        <p>Update the current case status to the next investigation stage?</p>
        <div class="modal-actions">
          <button class="secondary-button close-modal-btn">Cancel</button>
          <button class="primary-button confirm-status">Confirm Update</button>
        </div>
      </div>
    </div>

    <script src="./js/officer.js"></script>
  </body>
</html>

