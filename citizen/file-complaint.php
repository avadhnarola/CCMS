<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>File New Complaint | CCMS</title>

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
      <div class="page-header">
        <h1 class="page-title">Submit Confidential Report</h1>
        <p class="page-subtitle">Fill out the incident details below. All submissions are encrypted with client-side AES-256 keys.</p>
      </div>

      <div class="card-custom">
        <form id="fileComplaintForm" onsubmit="handleFormSubmission(event)">
          <div class="row g-3">

            <!-- Title -->
            <div class="col-12">
              <label class="form-label fw-bold text-heading small">Complaint Title / Headline <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="cTitle" placeholder="e.g. Demanding $500 cash bribe for issuing property registration certificate" required />
            </div>

            <!-- Category & Department -->
            <div class="col-md-6">
              <label class="form-label fw-bold text-heading small">Misconduct Category <span class="text-danger">*</span></label>
              <select class="form-select" id="cCategory" required>
                <option value="" selected disabled>Select Category...</option>
                <option value="Bribery & Extortion">Bribery &amp; Cash Extortion</option>
                <option value="Embezzlement & Fraud">Embezzlement of Public Funds</option>
                <option value="Procurement Malpractice">Procurement &amp; Tender Rigging</option>
                <option value="Nepotism & Favoritism">Nepotism &amp; Unfair Hiring</option>
                <option value="Judicial Misconduct">Judicial &amp; Law Enforcement Abuse</option>
                <option value="Cyber Fraud">Cyber &amp; Digital Fund Manipulation</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold text-heading small">Target Department / Sector <span class="text-danger">*</span></label>
              <select class="form-select" id="cDepartment" required>
                <option value="" selected disabled>Select Department...</option>
                <option value="Land & Revenue Dept">Land Registration &amp; Revenue</option>
                <option value="Public Works Dept">Public Works &amp; Infrastructure</option>
                <option value="Police & Law Enforcement">Police &amp; Judiciary Services</option>
                <option value="Healthcare & Supplies">Healthcare &amp; Hospital Supplies</option>
                <option value="Education & Grants">Education &amp; Grants</option>
                <option value="Transport & RTO">Transport &amp; Licensing</option>
              </select>
            </div>

            <!-- Date, Time, Location -->
            <div class="col-md-4">
              <label class="form-label fw-bold text-heading small">Date of Incident <span class="text-danger">*</span></label>
              <input type="date" class="form-control" id="cDate" required />
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold text-heading small">Time of Incident</label>
              <input type="time" class="form-control" id="cTime" value="11:30" />
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold text-heading small">Location / Office Address <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="cLocation" placeholder="e.g. Zonal Revenue Office, Desk #4" required />
            </div>

            <!-- Description -->
            <div class="col-12">
              <label class="form-label fw-bold text-heading small">Detailed Description &amp; Event Sequence <span class="text-danger">*</span></label>
              <textarea class="form-control" id="cDescription" rows="4" placeholder="Provide full details including official names (if known), exact demands made, and witness information..." required></textarea>
            </div>

            <!-- Anonymous & Priority Controls -->
            <div class="col-md-6">
              <div class="p-3 rounded bg-subtle border d-flex align-items-center justify-content-between h-100">
                <div class="d-flex align-items-center gap-3">
                  <i class="fas fa-user-secret text-primary fa-xl"></i>
                  <div>
                    <div class="fw-bold text-heading small">Anonymous Complaint</div>
                    <div class="text-muted" style="font-size:0.75rem;">Strips IP address &amp; identity from report</div>
                  </div>
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="cAnonymous" checked />
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="p-3 rounded bg-subtle border h-100">
                <label class="form-label fw-bold text-heading small mb-1">Severity / Urgency Priority (Optional)</label>
                <select class="form-select" id="cPriority">
                  <option value="Low">Low Priority (General Inquiry)</option>
                  <option value="Medium" selected>Medium Priority (Standard Misconduct)</option>
                  <option value="High">High Priority (Severe Bribery/Extortion)</option>
                  <option value="Critical">Critical (High-Value Fraud / Urgent Risk)</option>
                </select>
              </div>
            </div>

            <!-- Evidence File Drag & Drop Upload Zone -->
            <div class="col-12">
              <label class="form-label fw-bold text-heading small">Upload Evidence (Images, PDF, Video, Audio)</label>
              <div class="border border-2 border-dashed rounded p-4 text-center bg-subtle">
                <i class="fas fa-cloud-arrow-up fa-3x text-primary mb-2"></i>
                <h6 class="fw-bold text-heading">Drag &amp; Drop Evidence Files Here</h6>
                <p class="text-muted small mb-2">Accepted formats: JPG, PNG, PDF, MP3, WAV, MP4 (Max file size 50MB).</p>
                <span class="badge bg-success bg-opacity-10 text-success border mb-3"><i class="fas fa-shield-cat me-1"></i> EXIF &amp; GPS Metadata Auto-Scrubbed</span>
                <div>
                  <input type="file" class="d-none" id="fileInputMultiple" multiple onchange="handleFileSelection(this)" />
                  <button type="button" class="btn btn-sm btn-primary rounded-pill px-4" onclick="$('#fileInputMultiple').click()">
                    Browse Files
                  </button>
                </div>
              </div>
              <!-- Selected Files List -->
              <div id="filePreviewList" class="mt-3 d-flex flex-column gap-2"></div>
            </div>

          </div>

          <!-- Submission Actions -->
          <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
            <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
            <button type="submit" id="submitFormBtn" class="btn btn-primary fw-bold rounded-pill px-5" style="background:var(--gradient-brand); border:none;">
              <i class="fas fa-lock me-1"></i> Encrypt &amp; Submit Complaint
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>

<!-- FOOTER INCLUDE -->
<?php include 'includes/footer.php'; ?>
<script>
  let attachedFiles = ["transaction_receipt.pdf"];

  $(document).ready(function() {
    const user = getStoredUser();
    $('#topName').text(user.name);
    $('#topAvatar').text(user.avatarText);

    // Set today date default
    $('#cDate').val(new Date().toISOString().split('T')[0]);
    renderFilePreviews();
  });

  function handleFileSelection(input) {
    if (input.files) {
      for (let i = 0; i < input.files.length; i++) {
        attachedFiles.push(input.files[i].name);
      }
      renderFilePreviews();
    }
  }

  function renderFilePreviews() {
    let html = '';
    attachedFiles.forEach((file, index) => {
      html += `
        <div class="p-2 rounded bg-subtle border d-flex justify-content-between align-items-center">
          <span class="small fw-semibold text-heading"><i class="fas fa-file-shield text-primary me-2"></i>${file} <span class="text-success" style="font-size:0.75rem;">(Metadata Scrubbed)</span></span>
          <button type="button" class="btn btn-sm text-danger p-0 ms-2" onclick="removeFile(${index})"><i class="fas fa-times"></i></button>
        </div>
      `;
    });
    $('#filePreviewList').html(html);
  }

  function removeFile(index) {
    attachedFiles.splice(index, 1);
    renderFilePreviews();
  }

  function handleFormSubmission(e) {
    e.preventDefault();
    $('#submitFormBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Encrypting Report...');

    setTimeout(() => {
      const formData = {
        title: $('#cTitle').val(),
        category: $('#cCategory').val(),
        department: $('#cDepartment').val(),
        date: $('#cDate').val(),
        time: $('#cTime').val(),
        location: $('#cLocation').val(),
        description: $('#cDescription').val(),
        anonymous: $('#cAnonymous').is(':checked'),
        priority: $('#cPriority').val(),
        evidenceList: attachedFiles.length > 0 ? attachedFiles : ["evidence_scan.pdf"]
      };

      const newId = fileNewComplaint(formData);
      showCcmsToast(`Complaint #${newId} Encrypted & Registered Successfully!`, 'success', 'Report Registered');
      setTimeout(() => {
        window.location.href = `track.php?id=${newId}`;
      }, 1200);
    }, 1000);
  }
</script>
</body>
</html>

