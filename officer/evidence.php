<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CCMS | Evidence Repository</title>
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
          <a href="./evidence.php" class="nav-link active"><i class="fa-solid fa-folder-open"></i> <span>Evidence</span></a>
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
                <p class="eyebrow">Evidence Repository</p>
                <h1>Evidence</h1>
              </div>
              <button class="primary-button"><i class="fa-solid fa-upload"></i> Upload Evidence</button>
            </div>

            <div class="page-card evidence-upload-box">
              <strong>Case File: C-1024 - Bribery Complaint</strong>
              <button class="secondary-button"><i class="fa-solid fa-cloud-arrow-up"></i> Add New Evidence</button>
            </div>

            <div class="evidence-grid">
              <article class="evidence-card">
                <div class="evidence-thumb image"><i class="fa-regular fa-image"></i></div>
                <div class="evidence-body">
                  <h4>invoice_approval.jpg</h4>
                  <div class="meta-row"><span>Type</span><strong>Images</strong></div>
                  <div class="meta-row"><span>Upload Date</span><strong>09 Aug 2026</strong></div>
                  <div class="meta-row"><span>Uploaded By</span><strong>Citizen</strong></div>
                </div>
                <div class="evidence-actions"><button class="mini-button secondary">Preview</button><button class="mini-button primary">Download</button></div>
              </article>

              <article class="evidence-card">
                <div class="evidence-thumb doc"><i class="fa-regular fa-file-lines"></i></div>
                <div class="evidence-body">
                  <h4>contract_audit.pdf</h4>
                  <div class="meta-row"><span>Type</span><strong>Documents</strong></div>
                  <div class="meta-row"><span>Upload Date</span><strong>10 Aug 2026</strong></div>
                  <div class="meta-row"><span>Uploaded By</span><strong>Officer</strong></div>
                </div>
                <div class="evidence-actions"><button class="mini-button secondary">Preview</button><button class="mini-button primary">Download</button></div>
              </article>

              <article class="evidence-card">
                <div class="evidence-thumb audio"><i class="fa-solid fa-microphone-lines"></i></div>
                <div class="evidence-body">
                  <h4>whistleblower_call.mp3</h4>
                  <div class="meta-row"><span>Type</span><strong>Audio</strong></div>
                  <div class="meta-row"><span>Upload Date</span><strong>11 Aug 2026</strong></div>
                  <div class="meta-row"><span>Uploaded By</span><strong>Witness</strong></div>
                </div>
                <div class="evidence-actions"><button class="mini-button secondary">Preview</button><button class="mini-button primary">Download</button></div>
              </article>

              <article class="evidence-card">
                <div class="evidence-thumb video"><i class="fa-solid fa-video"></i></div>
                <div class="evidence-body">
                  <h4>meeting_surveillance.mp4</h4>
                  <div class="meta-row"><span>Type</span><strong>Video</strong></div>
                  <div class="meta-row"><span>Upload Date</span><strong>12 Aug 2026</strong></div>
                  <div class="meta-row"><span>Uploaded By</span><strong>Officer</strong></div>
                </div>
                <div class="evidence-actions"><button class="mini-button secondary">Preview</button><button class="mini-button primary">Download</button></div>
              </article>
            </div>
          </div>
        </div>
      </main>
    </div>
    <script src="./js/officer.js"></script>
  </body>
</html>

