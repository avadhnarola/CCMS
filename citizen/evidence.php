<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Evidence Gallery | CCMS</title>

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
          <h1 class="page-title">Evidence Vault Records</h1>
          <p class="page-subtitle">View and verify all attached documents, audio clips, video clips, and photo evidence.</p>
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-sm btn-primary rounded-pill active" onclick="filterGallery('all')">All Media</button>
          <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="filterGallery('doc')">Documents</button>
          <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="filterGallery('audio')">Audio</button>
          <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="filterGallery('video')">Videos</button>
        </div>
      </div>

      <!-- GALLERY GRID -->
      <div class="row g-4" id="galleryGrid">
        <div class="col-lg-4 col-md-6 gallery-item" data-type="doc">
          <div class="card-custom text-center">
            <div class="p-4 rounded bg-subtle mb-3">
              <i class="fas fa-file-pdf fa-3x text-danger"></i>
            </div>
            <h6 class="fw-bold text-heading mb-1">receipt_scan.pdf</h6>
            <div class="text-muted small mb-2">Complaint #CCMS-2026-8902</div>
            <span class="badge bg-success bg-opacity-10 text-success border mb-3">AES-256 Verified</span>
            <div>
              <button class="btn btn-sm btn-outline-primary rounded-pill w-100" onclick="showCcmsModalAlert('Preview File: receipt_scan.pdf', 'Metadata Scrubbed &amp; AES-256 Validated file content loaded securely.', 'info');">
                <i class="fas fa-eye me-1"></i> Preview File
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item" data-type="audio">
          <div class="card-custom text-center">
            <div class="p-4 rounded bg-subtle mb-3">
              <i class="fas fa-file-audio fa-3x text-primary"></i>
            </div>
            <h6 class="fw-bold text-heading mb-1">audio_recording.mp3</h6>
            <div class="text-muted small mb-2">Complaint #CCMS-2026-8902</div>
            <span class="badge bg-success bg-opacity-10 text-success border mb-3">Audio Masked</span>
            <div>
              <button class="btn btn-sm btn-outline-primary rounded-pill w-100" onclick="showCcmsModalAlert('Audio Stream: audio_recording.mp3', 'Voice-masked audio evidence loaded in secure media player.', 'info');">
                <i class="fas fa-play me-1"></i> Play Audio Clip
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item" data-type="doc">
          <div class="card-custom text-center">
            <div class="p-4 rounded bg-subtle mb-3">
              <i class="fas fa-file-word fa-3x text-info"></i>
            </div>
            <h6 class="fw-bold text-heading mb-1">tender_doc_v2.pdf</h6>
            <div class="text-muted small mb-2">Complaint #CCMS-2026-4412</div>
            <span class="badge bg-success bg-opacity-10 text-success border mb-3">AES-256 Verified</span>
            <div>
              <button class="btn btn-sm btn-outline-primary rounded-pill w-100" onclick="showCcmsModalAlert('Preview File: tender_doc_v2.pdf', 'Digital forensic audit logs attached.', 'info');">
                <i class="fas fa-eye me-1"></i> Preview File
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 gallery-item" data-type="doc">
          <div class="card-custom text-center">
            <div class="p-4 rounded bg-subtle mb-3">
              <i class="fas fa-file-excel fa-3x text-success"></i>
            </div>
            <h6 class="fw-bold text-heading mb-1">grant_allocation_sheet.xlsx</h6>
            <div class="text-muted small mb-2">Complaint #CCMS-2026-9920</div>
            <span class="badge bg-success bg-opacity-10 text-success border mb-3">Spreadsheet Encrypted</span>
            <div>
              <button class="btn btn-sm btn-outline-primary rounded-pill w-100" onclick="showCcmsModalAlert('Preview File: grant_allocation_sheet.xlsx', 'Spreadsheet decrypted in sandbox viewer.', 'info');">
                <i class="fas fa-eye me-1"></i> Preview File
              </button>
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
  });

  function filterGallery(type) {
    if (type === 'all') {
      $('.gallery-item').fadeIn();
    } else {
      $('.gallery-item').each(function() {
        if ($(this).data('type') === type) {
          $(this).fadeIn();
        } else {
          $(this).fadeOut();
        }
      });
    }
  }
</script>
</body>
</html>

