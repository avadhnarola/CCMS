<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Complaint Management | CCMS Admin</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Orbitron:wght@600;700;900&display=swap" rel="stylesheet" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="css/admin.css" />
</head>
<body>

<div class="admin-wrapper">
  <!-- SIDEBAR NAVIGATION -->
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar-header">
      <a href="index.php" class="admin-logo">CCMS</a>
      <span class="admin-badge-tag"><i class="fas fa-user-shield me-1"></i> Super Admin</span>
    </div>

    <div class="admin-sidebar-nav">
      <div class="admin-nav-title">Main Control</div>
      <a href="index.php" class="admin-link"><i class="fas fa-chart-pie"></i> Dashboard</a>
      <a href="complaints.php" class="admin-link active"><i class="fas fa-folder-tree"></i> Complaints Mgmt</a>
      <a href="assignment.php" class="admin-link"><i class="fas fa-diagram-project"></i> Greedy Assignment</a>
      <a href="analytics.php" class="admin-link"><i class="fas fa-chart-line"></i> Analytics Graphs</a>

      <div class="admin-nav-title">Users &amp; Officers</div>
      <a href="citizens.php" class="admin-link"><i class="fas fa-users"></i> Citizen Management</a>
      <a href="officers.php" class="admin-link"><i class="fas fa-user-gear"></i> Officer Management</a>

      <div class="admin-nav-title">Structure &amp; Rules</div>
      <a href="departments.php" class="admin-link"><i class="fas fa-building-columns"></i> Departments</a>
      <a href="categories.php" class="admin-link"><i class="fas fa-tags"></i> Categories</a>

      <div class="admin-nav-title">Audit &amp; Tools</div>
      <a href="reports.php" class="admin-link"><i class="fas fa-file-invoice"></i> Reports &amp; Exports</a>
      <a href="search.php" class="admin-link"><i class="fas fa-search"></i> Search &amp; Sort</a>
      <a href="activity-logs.php" class="admin-link"><i class="fas fa-list-check"></i> Activity Logs</a>
      <a href="notifications.php" class="admin-link"><i class="fas fa-bullhorn"></i> Broadcast Notices</a>
      <a href="settings.php" class="admin-link"><i class="fas fa-sliders"></i> System Settings</a>
      <a href="login.php" class="admin-link text-danger"><i class="fas fa-arrow-right-from-bracket"></i> Logout</a>
    </div>
  </aside>

  <!-- MAIN PANEL -->
  <main class="admin-main">
    <header class="admin-topbar">
      <div class="d-flex align-items-center gap-3">
        <button class="btn d-lg-none text-heading p-0 fs-4" onclick="$('#adminSidebar').toggleClass('show')">
          <i class="fas fa-bars"></i>
        </button>
        <h5 class="fw-bold mb-0 text-heading">Complaint Management Module</h5>
      </div>

      <div class="d-flex align-items-center gap-3">
        <button class="theme-toggle-btn" id="themeToggleBtn" onclick="toggleAdminTheme()" title="Toggle Theme">
          <i class="fas fa-moon"></i>
        </button>
        <a href="settings.php" class="d-flex align-items-center gap-2 p-1.5 px-3 rounded-pill bg-subtle border text-heading">
          <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center" style="width:32px; height:32px; font-size:0.8rem;">SA</div>
          <span class="fw-bold small d-none d-md-inline">Super Admin</span>
        </a>
      </div>
    </header>

    <div class="admin-content">
      <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
          <h1 class="h3 fw-bold text-heading mb-1">Master Complaints Table</h1>
          <p class="text-muted small mb-0">View all reported cases, assign officers via Greedy algorithm, or export reports.</p>
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-sm btn-outline-danger rounded-pill" onclick="alert('Exporting PDF Report...');">
            <i class="fas fa-file-pdf me-1"></i> Export PDF
          </button>
          <button class="btn btn-sm btn-outline-success rounded-pill" onclick="alert('Exporting Excel (.csv) Spreadsheet...');">
            <i class="fas fa-file-excel me-1"></i> Export Excel
          </button>
        </div>
      </div>

      <div class="admin-card">
        <div class="table-responsive">
          <table class="table table-custom mb-0">
            <thead>
              <tr>
                <th>Complaint ID</th>
                <th>Headline &amp; Department</th>
                <th>Assigned Officer</th>
                <th>Priority</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody id="adminComplaintsTbody">
              <!-- Dynamically Rendered -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
</div>

<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/admin.js"></script>
<script>
  $(document).ready(function() {
    renderAdminComplaintsTable();
  });

  function renderAdminComplaintsTable() {
    const complaints = JSON.parse(localStorage.getItem("ccms_complaints") || "[]");
    let html = '';
    if (complaints.length === 0) {
      html = `<tr><td colspan="6" class="text-center text-muted py-4">No complaints recorded.</td></tr>`;
    } else {
      complaints.forEach(c => {
        html += `
          <tr>
            <td><span class="font-monospace fw-bold text-primary">${c.id}</span></td>
            <td>
              <div class="fw-bold text-heading">${c.title}</div>
              <div class="text-muted small">${c.department}</div>
            </td>
            <td><span class="fw-semibold text-heading">${c.assignedOfficer || 'Unassigned'}</span></td>
            <td><span class="badge bg-subtle text-heading border">${c.priority || 'Medium'}</span></td>
            <td><span class="badge bg-primary bg-opacity-10 text-primary border">${c.status}</span></td>
            <td class="text-end">
              <button class="btn btn-sm btn-outline-primary me-1" onclick="runGreedyAssign('${c.id}')" title="Greedy Auto-Assign"><i class="fas fa-bolt"></i> Assign</button>
              <button class="btn btn-sm btn-outline-danger" onclick="deleteComplaint('${c.id}')" title="Delete Case"><i class="fas fa-trash"></i></button>
            </td>
          </tr>
        `;
      });
    }
    $('#adminComplaintsTbody').html(html);
  }

  function runGreedyAssign(id) {
    const result = greedyAssignComplaint(id);
    alert(result.message);
    renderAdminComplaintsTable();
  }

  function deleteComplaint(id) {
    if (confirm(`Delete complaint #${id}?`)) {
      let complaints = JSON.parse(localStorage.getItem("ccms_complaints") || "[]");
      complaints = complaints.filter(c => c.id !== id);
      localStorage.setItem("ccms_complaints", JSON.stringify(complaints));
      logAdminActivity("Delete Complaint", `Deleted complaint #${id}`);
      renderAdminComplaintsTable();
    }
  }
</script>
</body>
</html>

