<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Support | CCMS</title>

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
        <h1 class="page-title">Submit Support Ticket</h1>
        <p class="page-subtitle">Get in touch with our technical support team or whistleblower legal protection desk.</p>
      </div>

      <div class="row g-4">
        <!-- Support Form -->
        <div class="col-lg-7">
          <div class="card-custom">
            <h5 class="fw-bold text-heading mb-3"><i class="fas fa-headset text-primary me-2"></i>Send Message</h5>
            <form id="contactForm" onsubmit="handleContactSubmit(event)">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label small fw-bold text-heading">Category</label>
                  <select class="form-select" required>
                    <option value="Technical Issue">Technical / Portal Issue</option>
                    <option value="Legal Protection">Whistleblower Legal Aid</option>
                    <option value="Urgent Escalation">Urgent Case Escalation</option>
                    <option value="General Query">General Query</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-bold text-heading">Related Complaint ID (Optional)</label>
                  <input type="text" class="form-control font-monospace" placeholder="e.g. CCMS-2026-8902" />
                </div>
                <div class="col-12">
                  <label class="form-label small fw-bold text-heading">Subject</label>
                  <input type="text" class="form-control" placeholder="Brief summary of your query" required />
                </div>
                <div class="col-12">
                  <label class="form-label small fw-bold text-heading">Message Details</label>
                  <textarea class="form-control" rows="4" placeholder="Describe the issue or assistance required..." required></textarea>
                </div>
              </div>
              <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary fw-bold rounded-pill px-4" style="background:var(--gradient-brand); border:none;">
                  Submit Ticket <i class="fas fa-paper-plane ms-1"></i>
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Hotline & Office Details -->
        <div class="col-lg-5">
          <div class="card-custom mb-4">
            <h5 class="fw-bold text-heading mb-3"><i class="fas fa-phone-volume text-primary me-2"></i>Emergency Hotline</h5>
            <div class="p-3 rounded bg-subtle border mb-3">
              <div class="fw-bold font-monospace text-primary fs-4">1800-11-CCMS</div>
              <div class="text-muted small">24/7 Toll-Free National Anti-Corruption Helpline</div>
            </div>
            <p class="text-muted small mb-0">Call our emergency hotline for immediate protection against threats or urgent bribery reporting.</p>
          </div>

          <div class="card-custom">
            <h5 class="fw-bold text-heading mb-3"><i class="fas fa-building text-primary me-2"></i>Anti-Corruption Bureau Office</h5>
            <div class="text-muted small mb-2">
              <strong>Address:</strong> Central Vigilance Complex, Block B, Integrity Square, Capital City.
            </div>
            <div class="text-muted small mb-2">
              <strong>Official Email:</strong> support@ccms-portal.gov.in
            </div>
            <div class="text-muted small">
              <strong>Encrypted Telegram Channel:</strong> @CCMS_Vigilance_Bot
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

  function handleContactSubmit(e) {
    e.preventDefault();
    showCcmsToast("Support ticket submitted! Our vigilance desk will contact you within 24 hours.", "success", "Ticket Submitted");
    document.getElementById('contactForm').reset();
  }
</script>
</body>
</html>

