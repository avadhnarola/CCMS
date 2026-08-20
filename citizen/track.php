<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Track Complaint &amp; Linked List Timeline | CCMS</title>

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
      <!-- Search Input Card -->
      <div class="card-custom mb-4">
        <h5 class="fw-bold text-heading mb-3"><i class="fas fa-magnifying-glass text-primary me-2"></i>Search Complaint by Key</h5>
        <form class="row g-2" onsubmit="event.preventDefault(); trackComplaint();">
          <div class="col-md-9">
            <input type="text" id="trackSearchInput" class="form-control form-control-lg font-monospace" placeholder="Enter 16-digit Complaint ID (e.g. CCMS-2026-8902)" value="CCMS-2026-8902" required />
          </div>
          <div class="col-md-3 d-grid">
            <button type="submit" class="btn btn-primary btn-lg fw-bold" style="background:var(--gradient-brand); border:none;">
              <i class="fas fa-route me-1"></i> Track Progress
            </button>
          </div>
        </form>
      </div>

      <!-- Complaint Details Result Container -->
      <div id="trackResultContainer">
        <!-- Linked List Timeline Visualizer -->
        <div class="card-custom mb-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="fw-bold mb-0 text-heading"><i class="fas fa-diagram-project text-primary me-2"></i>Linked List Case Progression Timeline</h5>
              <p class="text-muted small mb-0">Demonstrating linked timeline data nodes connected via pointer memory addresses (`next`).</p>
            </div>
            <span class="badge bg-primary bg-opacity-10 text-primary border" id="activeStatusBadge">In Progress</span>
          </div>

          <!-- Dynamic Linked List Visualizer -->
          <div id="linkedListVisualizerArea"></div>
        </div>

        <!-- Case Metadata Dossier -->
        <div class="card-custom">
          <h5 class="fw-bold text-heading mb-3"><i class="fas fa-file-invoice text-primary me-2"></i>Complaint Metadata</h5>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="p-3 rounded bg-subtle border">
                <div class="text-muted small">Complaint ID:</div>
                <div class="fw-bold font-monospace text-primary fs-5" id="metaId">CCMS-2026-8902</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded bg-subtle border">
                <div class="text-muted small">Assigned Anti-Corruption Officer:</div>
                <div class="fw-bold text-heading" id="metaOfficer">Insp. A. Verma</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="text-muted small">Department:</div>
              <div class="fw-bold text-heading" id="metaDept">Land &amp; Revenue Dept</div>
            </div>
            <div class="col-md-4">
              <div class="text-muted small">Incident Date:</div>
              <div class="fw-bold text-heading" id="metaDate">12 July 2026</div>
            </div>
            <div class="col-md-4">
              <div class="text-muted small">Location:</div>
              <div class="fw-bold text-heading" id="metaLoc">District Revenue Office</div>
            </div>
            <div class="col-12">
              <div class="text-muted small">Headline:</div>
              <div class="fw-bold text-heading fs-6" id="metaTitle">Land Registration Title Deed Bribe Extortion</div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>
</div>

<!-- FOOTER INCLUDE -->
<?php include 'includes/footer.php'; ?>
<script>
  $(document).ready(function() {
    const user = getStoredUser();
    $('#topName').text(user.name);
    $('#topAvatar').text(user.avatarText);

    // Read URL query parameter ?id=
    const urlParams = new URLSearchParams(window.location.search);
    const searchId = urlParams.get('id');
    if (searchId) {
      $('#trackSearchInput').val(searchId);
    }
    trackComplaint();
  });

  function trackComplaint() {
    const id = $('#trackSearchInput').val().trim();
    const complaints = getStoredComplaints();
    const c = complaints.find(item => item.id.toLowerCase() === id.toLowerCase());

    if (!c) {
      $('#trackResultContainer').html(`
        <div class="card-custom text-center py-5">
          <i class="fas fa-triangle-exclamation fa-3x text-warning mb-3"></i>
          <h5 class="fw-bold text-heading">Complaint ID Not Found</h5>
          <p class="text-muted small">Please verify your 16-digit tracking code and try again.</p>
        </div>
      `);
      return;
    }

    // Populate metadata
    $('#metaId').text(c.id);
    $('#metaTitle').text(c.title);
    $('#metaDept').text(c.department);
    $('#metaDate').text(c.date);
    $('#metaLoc').text(c.location);
    $('#metaOfficer').text(c.assignedOfficer);
    $('#activeStatusBadge').text(c.status);

    // Render Linked List Timeline UI Data Structure
    renderLinkedListTimeline('linkedListVisualizerArea', c.timeline);
  }
</script>
</body>
</html>

