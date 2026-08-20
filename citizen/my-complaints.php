<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Complaints | CCMS</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Orbitron:wght@600;700;900&display=swap" rel="stylesheet" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="css/citizen.css" />
</head>
<body>

<div class="app-wrapper">
  <!-- SIDEBAR NAVIGATION INCLUDE -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- MAIN CONTENT -->
  <main class="app-main">
    <!-- TOP BAR INCLUDE -->
    <?php include 'includes/topbar.php'; ?>

    <div class="app-content">
      <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
          <h1 class="page-title">Complaint Records</h1>
          <p class="page-subtitle">View complaint details, print official receipts, or withdraw pending cases.</p>
        </div>
        <div class="d-flex gap-2">
          <input type="text" id="filterSearchInput" class="form-control form-control-sm" placeholder="Search by ID or Title..." onkeyup="renderComplaintsTable()" style="max-width:220px;" />
          <select id="filterStatusSelect" class="form-select form-select-sm" onchange="renderComplaintsTable()" style="max-width:160px;">
            <option value="all">All Statuses</option>
            <option value="Pending">Pending</option>
            <option value="In Progress">In Progress</option>
            <option value="Resolved">Resolved</option>
          </select>
        </div>
      </div>

      <div class="card-custom">
        <div class="table-responsive">
          <table class="table table-custom mb-0">
            <thead>
              <tr>
                <th>Complaint ID</th>
                <th>Headline &amp; Dept</th>
                <th>Filing Date</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody id="myComplaintsTbody">
              <!-- Dynamically Rendered -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
</div>

<!-- DETAILS & RECEIPT MODAL -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content card-custom">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="fw-bold text-heading mb-0"><i class="fas fa-file-contract text-primary me-2"></i>Complaint Dossier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4" id="modalDossierBody">
        <!-- Dynamically Rendered -->
      </div>

      <div class="modal-footer border-top-0 pt-0">
        <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm fw-bold rounded-pill" onclick="window.print()">
          <i class="fas fa-print me-1"></i> Print / Save Receipt PDF
        </button>
      </div>
    </div>
  </div>
</div>

<!-- FOOTER INCLUDE -->
<?php include 'includes/footer.php'; ?>
<script>
  $(document).ready(function() {
    const user = getStoredUser();
    $('#topName').text(user.name);
    $('#topAvatar').text(user.avatarText);
    renderComplaintsTable();
  });

  function renderComplaintsTable() {
    const complaints = getStoredComplaints();
    const searchQuery = $('#filterSearchInput').val().toLowerCase();
    const statusFilter = $('#filterStatusSelect').val();

    let filtered = complaints.filter(c => {
      const matchSearch = c.id.toLowerCase().includes(searchQuery) || c.title.toLowerCase().includes(searchQuery) || c.department.toLowerCase().includes(searchQuery);
      const matchStatus = (statusFilter === 'all') || (c.status === statusFilter);
      return matchSearch && matchStatus;
    });

    let html = '';
    if (filtered.length === 0) {
      html = `<tr><td colspan="5" class="text-center text-muted py-4">No matching complaints found.</td></tr>`;
    } else {
      filtered.forEach(c => {
        let badgeClass = 'badge-pending';
        if (c.status === 'In Progress') badgeClass = 'badge-progress';
        if (c.status === 'Resolved') badgeClass = 'badge-resolved';
        if (c.status === 'Rejected') badgeClass = 'badge-rejected';

        // Withdraw button only allowed if status is Pending
        const canWithdraw = (c.status === 'Pending');
        const withdrawBtn = canWithdraw ? 
          `<button class="btn btn-sm btn-outline-danger me-1" onclick="handleWithdraw('${c.id}')" title="Withdraw Complaint"><i class="fas fa-undo"></i> Withdraw</button>` : '';

        html += `
          <tr>
            <td><span class="font-monospace fw-bold text-primary">${c.id}</span></td>
            <td>
              <div class="fw-bold text-heading">${c.title}</div>
              <div class="text-muted small">${c.department} &bull; <span class="fst-italic">${c.anonymous ? 'Anonymous' : 'Public'}</span></div>
            </td>
            <td class="text-muted small">${c.date}</td>
            <td><span class="badge-status ${badgeClass}">${c.status}</span></td>
            <td class="text-end">
              ${withdrawBtn}
              <button class="btn btn-sm btn-subtle text-primary fw-bold me-1" onclick="viewDetails('${c.id}')"><i class="fas fa-file-lines me-1"></i> Dossier</button>
              <a href="track.html?id=${c.id}" class="btn btn-sm btn-primary rounded-pill"><i class="fas fa-route me-1"></i> Track</a>
            </td>
          </tr>
        `;
      });
    }
    $('#myComplaintsTbody').html(html);
  }

  function viewDetails(id) {
    const complaints = getStoredComplaints();
    const c = complaints.find(item => item.id === id);
    if (!c) return;

    let html = `
      <div class="p-3 rounded bg-subtle border mb-3 d-flex justify-content-between align-items-center">
        <div>
          <div class="text-muted small">Tracking Key Reference</div>
          <div class="fs-5 font-monospace fw-bold text-primary">${c.id}</div>
        </div>
        <span class="badge-status ${c.status === 'Resolved' ? 'badge-resolved' : (c.status === 'In Progress' ? 'badge-progress' : 'badge-pending')}">${c.status}</span>
      </div>

      <div class="row g-3 mb-3">
        <div class="col-md-6"><strong class="text-heading small">Headline:</strong> <div class="text-muted small">${c.title}</div></div>
        <div class="col-md-6"><strong class="text-heading small">Department:</strong> <div class="text-muted small">${c.department}</div></div>
        <div class="col-md-6"><strong class="text-heading small">Filing Date &amp; Time:</strong> <div class="text-muted small">${c.date} at ${c.time}</div></div>
        <div class="col-md-6"><strong class="text-heading small">Location:</strong> <div class="text-muted small">${c.location}</div></div>
        <div class="col-md-6"><strong class="text-heading small">Assigned Desk:</strong> <div class="text-muted small">${c.assignedOfficer}</div></div>
        <div class="col-md-6"><strong class="text-heading small">Anonymity Setting:</strong> <div class="text-success small fw-bold">${c.anonymous ? '100% Anonymous (Metadata Scrubbed)' : 'Non-Anonymous'}</div></div>
      </div>

      <div class="mb-3">
        <strong class="text-heading small">Description:</strong>
        <div class="p-3 rounded bg-subtle border text-muted small mt-1">${c.description}</div>
      </div>

      <div>
        <strong class="text-heading small">Attached Evidence Vault Files:</strong>
        <div class="mt-2 d-flex flex-wrap gap-2">
          ${c.evidence.map(f => `<span class="badge bg-light text-dark border p-2"><i class="fas fa-paperclip text-primary me-1"></i> ${f}</span>`).join('')}
        </div>
      </div>
    `;

    $('#modalDossierBody').html(html);
    $('#detailsModal').modal('show');
  }

  function handleWithdraw(id) {
    showCcmsConfirm("Withdraw Complaint", `Are you sure you want to withdraw complaint #${id}? This action cannot be undone.`, function() {
      const result = withdrawComplaint(id);
      showCcmsToast(result.message, result.success ? "success" : "danger", "Complaint Status");
      renderComplaintsTable();
    });
  }
</script>
</body>
</html>

