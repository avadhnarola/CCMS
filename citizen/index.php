<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Citizen Dashboard | CCMS — Corruption Complaint System</title>
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

  <!-- Chart.js CDN for DSA & Python Data Analytics -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

  <style>
    /* Custom page enhancements for Dashboard */
    .stat-card-gradient {
      background: var(--bg-surface);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-lg);
      padding: 24px;
      position: relative;
      overflow: hidden;
      box-shadow: var(--shadow-card);
      transition: var(--transition);
    }
    .stat-card-gradient:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-hover);
      border-color: var(--clr-primary);
    }
    .stat-card-gradient::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; height: 3px;
      background: var(--gradient-brand);
      opacity: 0.8;
    }

    .stat-number-lg {
      font-size: 2.2rem;
      font-weight: 900;
      color: var(--text-heading);
      font-family: 'Orbitron', sans-serif;
      line-height: 1;
    }
    .stat-icon-wrapper {
      width: 52px; height: 52px;
      border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.4rem;
    }

    .trend-indicator {
      font-size: 0.78rem;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      padding: 3px 8px;
      border-radius: 50px;
    }

    .chart-box {
      background: var(--bg-surface);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-lg);
      padding: 24px;
      box-shadow: var(--shadow-card);
      height: 100%;
    }

    /* Status Timeline Stepper */
    .timeline-stepper {
      position: relative;
      padding-left: 28px;
    }
    .timeline-stepper::before {
      content: '';
      position: absolute;
      left: 10px; top: 12px; bottom: 12px;
      width: 2px;
      background: var(--border-color);
    }
    .timeline-item {
      position: relative;
      margin-bottom: 22px;
    }
    .timeline-item:last-child { margin-bottom: 0; }
    .timeline-dot {
      position: absolute;
      left: -28px; top: 3px;
      width: 22px; height: 22px;
      border-radius: 50%;
      background: var(--bg-surface);
      border: 2.5px solid var(--text-muted);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.65rem; color: #fff;
    }
    .timeline-item.active .timeline-dot {
      background: var(--clr-primary);
      border-color: var(--clr-primary);
      box-shadow: 0 0 12px var(--clr-primary);
    }
    .timeline-item.completed .timeline-dot {
      background: var(--clr-success);
      border-color: var(--clr-success);
    }

    /* Quick Action Cards */
    .quick-act-card {
      background: var(--bg-surface);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-lg);
      padding: 20px;
      display: flex;
      align-items: center;
      gap: 16px;
      box-shadow: var(--shadow-card);
      transition: var(--transition);
      cursor: pointer;
      text-decoration: none;
      color: inherit;
    }
    .quick-act-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-hover);
      border-color: var(--clr-primary);
      background: var(--clr-primary-light);
    }
    .quick-act-icon {
      width: 48px; height: 48px;
      border-radius: 12px;
      background: var(--gradient-brand);
      color: #fff;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.3rem; flex-shrink: 0;
    }
  </style>
</head>
<body>

<div class="app-wrapper">

  <!-- SIDEBAR NAVIGATION INCLUDE -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- MAIN CONTENT AREA -->
  <main class="app-main">

    <!-- TOP BAR INCLUDE -->
    <?php include 'includes/topbar.php'; ?>

    <!-- CONTENT BODY -->
    <div class="app-content">

      <!-- PAGE HEADER -->
      <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
          <h1 class="page-title mb-1">
            Welcome back, <span class="text-gradient" id="welcomeName">Rajesh</span> 👋
          </h1>
          <p class="page-subtitle">Real-time whistleblower vigilance dashboard &amp; algorithmic complaint analytics.</p>
        </div>
        <div class="d-flex gap-2">
          <a href="track.php" class="btn btn-outline-primary fw-bold rounded-pill px-3">
            <i class="fas fa-magnifying-glass me-1"></i> Quick Track
          </a>
          <a href="file-complaint.php" class="btn btn-primary fw-bold rounded-pill px-4" style="background:var(--gradient-brand); border:none; box-shadow: var(--shadow-hover);">
            <i class="fas fa-shield-halved me-1"></i> File Complaint
          </a>
        </div>
      </div>

      <!-- 4 STATS METRICS CARDS -->
      <div class="row g-4 mb-4">

        <!-- Total Complaints -->
        <div class="col-xl-3 col-md-6">
          <div class="stat-card-gradient">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div>
                <div class="stat-label text-muted">Total Complaints</div>
                <div class="stat-number-lg mt-1" id="statTotal">7</div>
              </div>
              <div class="stat-icon-wrapper" style="background: rgba(6, 182, 212, 0.12); color: #0891b2;">
                <i class="fas fa-folder-open"></i>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-3 pt-2 border-top border-light-subtle">
              <span class="trend-indicator bg-success-subtle text-success">
                <i class="fas fa-arrow-trend-up"></i> +12% this month
              </span>
              <span class="text-muted small">Updated live</span>
            </div>
          </div>
        </div>

        <!-- Pending -->
        <div class="col-xl-3 col-md-6">
          <div class="stat-card-gradient">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div>
                <div class="stat-label text-muted">Pending Review</div>
                <div class="stat-number-lg text-warning mt-1" id="statPending">2</div>
              </div>
              <div class="stat-icon-wrapper" style="background: rgba(217, 119, 6, 0.12); color: #d97706;">
                <i class="fas fa-hourglass-half"></i>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-3 pt-2 border-top border-light-subtle">
              <span class="trend-indicator bg-warning-subtle text-warning">
                <i class="fas fa-clock"></i> SLA &lt; 24 hrs
              </span>
              <span class="text-muted small">Triage queue</span>
            </div>
          </div>
        </div>

        <!-- In Progress -->
        <div class="col-xl-3 col-md-6">
          <div class="stat-card-gradient">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div>
                <div class="stat-label text-muted">Under Investigation</div>
                <div class="stat-number-lg text-info mt-1" id="statProgress">3</div>
              </div>
              <div class="stat-icon-wrapper" style="background: rgba(99, 102, 241, 0.12); color: #6366f1;">
                <i class="fas fa-spinner fa-spin-pulse"></i>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-3 pt-2 border-top border-light-subtle">
              <span class="trend-indicator bg-info-subtle text-info">
                <i class="fas fa-user-shield"></i> Active inquiry
              </span>
              <span class="text-muted small">Vigilance team</span>
            </div>
          </div>
        </div>

        <!-- Resolved -->
        <div class="col-xl-3 col-md-6">
          <div class="stat-card-gradient">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div>
                <div class="stat-label text-muted">Resolved &amp; Closed</div>
                <div class="stat-number-lg text-success mt-1" id="statResolved">2</div>
              </div>
              <div class="stat-icon-wrapper" style="background: rgba(5, 150, 105, 0.12); color: #059669;">
                <i class="fas fa-circle-check"></i>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-3 pt-2 border-top border-light-subtle">
              <span class="trend-indicator bg-success-subtle text-success">
                <i class="fas fa-check"></i> 100% Verified
              </span>
              <span class="text-muted small">Action Taken</span>
            </div>
          </div>
        </div>

      </div>

      <!-- VIGILANCE ANALYTICS SECTION (CHARTS FOR PYTHON DSA INTEGRATION) -->
      <div class="row g-4 mb-4">
        <!-- Monthly Filing & Resolution Trends -->
        <div class="col-lg-8">
          <div class="chart-box">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div>
                <h5 class="fw-bold mb-0 text-heading">
                  <i class="fas fa-chart-line text-primary me-2"></i>Complaint Resolution &amp; Filing Analytics
                </h5>
                <div class="text-muted small">Algorithmic SLA Tracking &amp; Python DSA Data Feed</div>
              </div>
              <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill">
                <i class="fas fa-brain me-1"></i> DSA Algorithmic Model
              </span>
            </div>
            <div style="height: 270px; position: relative;">
              <canvas id="trendChart"></canvas>
            </div>
          </div>
        </div>

        <!-- Category Distribution Doughnut -->
        <div class="col-lg-4">
          <div class="chart-box">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div>
                <h5 class="fw-bold mb-0 text-heading">
                  <i class="fas fa-chart-pie text-accent me-2"></i>Sector Breakdown
                </h5>
                <div class="text-muted small">Classification Metrics</div>
              </div>
            </div>
            <div style="height: 230px; position: relative;" class="d-flex justify-content-center">
              <canvas id="sectorChart"></canvas>
            </div>
            <div class="text-center mt-2 text-muted small">
              <i class="fas fa-circle text-info me-1"></i> Revenue
              <i class="fas fa-circle text-warning ms-2 me-1"></i> Municipal
              <i class="fas fa-circle text-primary ms-2 me-1"></i> Police
            </div>
          </div>
        </div>
      </div>

      <!-- MAIN CONTENT SPLIT: TABLE & LIVE STATUS TRACKER -->
      <div class="row g-4 mb-4">

        <!-- Recent Complaints Table -->
        <div class="col-lg-8">
          <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="fw-bold mb-0 text-heading">
                <i class="fas fa-history text-primary me-2"></i>My Recent Complaints
              </h5>
              <a href="my-complaints.php" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All</a>
            </div>

            <div class="table-responsive">
              <table class="table table-custom">
                <thead>
                  <tr>
                    <th>Complaint ID</th>
                    <th>Title &amp; Sector</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="dashboardComplaintsTable">
                  <!-- Dynamically Rendered via JS -->
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Active Complaint Status Timeline Tracker -->
        <div class="col-lg-4">
          <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="fw-bold mb-0 text-heading">
                <i class="fas fa-route text-primary me-2"></i>Active Case Tracker
              </h5>
              <span class="badge bg-info bg-opacity-10 text-info font-monospace">CCMS-8902</span>
            </div>

            <div class="timeline-stepper py-2">
              <div class="timeline-item completed">
                <div class="timeline-dot"><i class="fas fa-check"></i></div>
                <div class="fw-bold text-heading small">Complaint Received</div>
                <div class="text-muted" style="font-size:0.75rem;">Encryption validated &amp; ID assigned</div>
              </div>

              <div class="timeline-item completed">
                <div class="timeline-dot"><i class="fas fa-check"></i></div>
                <div class="fw-bold text-heading small">Initial Triage &amp; Evidence Review</div>
                <div class="text-muted" style="font-size:0.75rem;">Assigned to Vigilance Officer #402</div>
              </div>

              <div class="timeline-item active">
                <div class="timeline-dot"><i class="fas fa-spinner fa-spin"></i></div>
                <div class="fw-bold text-primary small">Field Investigation Underway</div>
                <div class="text-muted" style="font-size:0.75rem;">Statement verification in progress</div>
              </div>

              <div class="timeline-item">
                <div class="timeline-dot"><i class="fas fa-circle"></i></div>
                <div class="fw-bold text-muted small">Final Resolution &amp; Prosecution</div>
                <div class="text-muted" style="font-size:0.75rem;">Estimated SLA: &lt; 48 hours</div>
              </div>
            </div>

            <div class="mt-3 pt-3 border-top text-center">
              <a href="track.php?id=CCMS-8902" class="btn btn-sm btn-subtle text-primary fw-bold w-100 rounded-pill">
                Full Investigation Timeline <i class="fas fa-arrow-right ms-1"></i>
              </a>
            </div>
          </div>
        </div>

      </div>

      <!-- QUICK ACTIONS SHORTCUT ROW -->
      <div class="row g-4">
        <div class="col-md-4">
          <a href="file-complaint.php" class="quick-act-card">
            <div class="quick-act-icon"><i class="fas fa-file-signature"></i></div>
            <div>
              <div class="fw-bold text-heading">File New Complaint</div>
              <div class="text-muted small">Submit encrypted report with evidence</div>
            </div>
          </a>
        </div>

        <div class="col-md-4">
          <a href="track.php" class="quick-act-card">
            <div class="quick-act-icon"><i class="fas fa-magnifying-glass-location"></i></div>
            <div>
              <div class="fw-bold text-heading">Track Live Inquiry</div>
              <div class="text-muted small">Check 16-digit case progress status</div>
            </div>
          </a>
        </div>

        <div class="col-md-4">
          <a href="evidence.php" class="quick-act-card">
            <div class="quick-act-icon"><i class="fas fa-vault"></i></div>
            <div>
              <div class="fw-bold text-heading">Evidence Vault</div>
              <div class="text-muted small">Manage photos, audio &amp; PDF files</div>
            </div>
          </a>
        </div>
      </div>

    </div>
  </main>
</div>

<!-- FOOTER INCLUDE -->
<?php include 'includes/footer.php'; ?>

<script>
  $(document).ready(function() {
    renderDashboard();
    initCharts();
  });

  function renderDashboard() {
    const user = getStoredUser();
    $('#welcomeName').text(user.name.split(' ')[0]);
    $('#userNameText, #sideUserName').text(user.name);
    $('#userAvatarText, #sideAvatar').text(user.avatarText);

    const complaints = getStoredComplaints();
    
    // Stats
    const total = complaints.length || 7;
    const pending = complaints.filter(c => c.status === "Pending").length || 2;
    const progress = complaints.filter(c => c.status === "In Progress").length || 3;
    const resolved = complaints.filter(c => c.status === "Resolved").length || 2;

    $('#statTotal').text(total);
    $('#statPending').text(pending);
    $('#statProgress').text(progress);
    $('#statResolved').text(resolved);

    // Table
    let tableHtml = '';
    if (complaints.length === 0) {
      // Demo defaults for rich layout display
      const demoData = [
        { id: 'CCMS-8902', title: 'Bribery Demanded for Land Survey', department: 'Revenue & Taxation', date: 'Aug 18, 2026', status: 'In Progress' },
        { id: 'CCMS-7410', title: 'PDS Grain Siphoning at Local Depot', department: 'Civil Supplies', date: 'Aug 14, 2026', status: 'Pending' },
        { id: 'CCMS-6523', title: 'Rigged Tender Awarding in PWD Road', department: 'Public Works (PWD)', date: 'Aug 02, 2026', status: 'Resolved' },
        { id: 'CCMS-4109', title: 'Hospital Medicines Extortion Scheme', department: 'Health Services', date: 'Jul 28, 2026', status: 'Resolved' }
      ];
      demoData.forEach(c => {
        let badgeClass = 'badge-pending';
        if (c.status === 'In Progress') badgeClass = 'badge-progress';
        if (c.status === 'Resolved') badgeClass = 'badge-resolved';

        tableHtml += `
          <tr>
            <td><span class="font-monospace fw-bold text-primary">${c.id}</span></td>
            <td>
              <div class="fw-bold text-heading">${c.title}</div>
              <div class="text-muted small">${c.department}</div>
            </td>
            <td class="text-muted small">${c.date}</td>
            <td><span class="badge-status ${badgeClass}">${c.status}</span></td>
            <td>
              <a href="track.php?id=${c.id}" class="btn btn-sm btn-subtle text-primary fw-bold" title="Track Case">
                <i class="fas fa-eye me-1"></i> Track
              </a>
            </td>
          </tr>
        `;
      });
    } else {
      complaints.slice(0, 5).forEach(c => {
        let badgeClass = 'badge-pending';
        if (c.status === 'In Progress') badgeClass = 'badge-progress';
        if (c.status === 'Resolved') badgeClass = 'badge-resolved';
        if (c.status === 'Rejected') badgeClass = 'badge-rejected';

        tableHtml += `
          <tr>
            <td><span class="font-monospace fw-bold text-primary">${c.id}</span></td>
            <td>
              <div class="fw-bold text-heading">${c.title}</div>
              <div class="text-muted small">${c.department}</div>
            </td>
            <td class="text-muted small">${c.date}</td>
            <td><span class="badge-status ${badgeClass}">${c.status}</span></td>
            <td>
              <a href="track.php?id=${c.id}" class="btn btn-sm btn-subtle text-primary fw-bold" title="Track Case">
                <i class="fas fa-eye me-1"></i> Track
              </a>
            </td>
          </tr>
        `;
      });
    }
    $('#dashboardComplaintsTable').html(tableHtml);
  }

  // CHART.JS INITIALIZATION FOR FUTURE PYTHON / DSA BACKEND DATA
  function initCharts() {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const textColor = isDark ? '#cbd5e1' : '#475569';
    const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.05)';

    // Trend Line Chart
    const ctxTrend = document.getElementById('trendChart').getContext('2d');
    const gradCyan = ctxTrend.createLinearGradient(0, 0, 0, 250);
    gradCyan.addColorStop(0, 'rgba(6, 182, 212, 0.35)');
    gradCyan.addColorStop(1, 'rgba(6, 182, 212, 0.0)');

    new Chart(ctxTrend, {
      type: 'line',
      data: {
        labels: ['Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
        datasets: [
          {
            label: 'Complaints Filed',
            data: [4, 6, 8, 5, 9, 12],
            borderColor: '#06b6d4',
            backgroundColor: gradCyan,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#06b6d4',
            pointRadius: 4
          },
          {
            label: 'Resolved Cases',
            data: [3, 5, 7, 4, 8, 10],
            borderColor: '#6366f1',
            borderDash: [4, 4],
            fill: false,
            tension: 0.4,
            pointBackgroundColor: '#6366f1',
            pointRadius: 3
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { labels: { color: textColor, font: { family: 'Inter', size: 12 } } }
        },
        scales: {
          x: { grid: { color: gridColor }, ticks: { color: textColor } },
          y: { grid: { color: gridColor }, ticks: { color: textColor } }
        }
      }
    });

    // Sector Doughnut Chart
    const ctxSector = document.getElementById('sectorChart').getContext('2d');
    new Chart(ctxSector, {
      type: 'doughnut',
      data: {
        labels: ['Revenue', 'Municipal', 'Police', 'Others'],
        datasets: [{
          data: [40, 25, 20, 15],
          backgroundColor: ['#0284c7', '#d97706', '#0891b2', '#6366f1'],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        },
        cutout: '70%'
      }
    });
  }
</script>
</body>
</html>
