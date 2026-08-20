<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Resolution Feedback &amp; Rating | CCMS</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Orbitron:wght@600;700;900&display=swap" rel="stylesheet" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="css/citizen.css" />

  <style>
    .star-rating i {
      font-size: 2rem;
      color: #cbd5e1;
      cursor: pointer;
      transition: color 0.2s;
    }
    .star-rating i.selected, .star-rating i:hover {
      color: #f59e0b;
    }
  </style>
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
        <h1 class="page-title">Citizen Satisfaction Feedback</h1>
        <p class="page-subtitle">Rate the resolution efficiency and vigilance officer response for your closed cases.</p>
      </div>

      <div class="row g-4">
        <!-- Left Feedback Submission Form -->
        <div class="col-lg-6">
          <div class="card-custom">
            <h5 class="fw-bold text-heading mb-3"><i class="fas fa-pen-to-square text-primary me-2"></i>Submit Feedback</h5>
            <form onsubmit="submitFeedback(event)">
              <div class="mb-3">
                <label class="form-label small fw-bold text-heading">Select Resolved Complaint</label>
                <select class="form-select" id="feedbackComplaintSelect" required>
                  <option value="CCMS-2026-8902">CCMS-2026-8902 (Land Registration Title Deed Bribe Extortion)</option>
                </select>
              </div>

              <div class="mb-3 text-center p-3 rounded bg-subtle border">
                <label class="form-label small fw-bold text-heading d-block mb-2">Overall Satisfaction Rating</label>
                <div class="star-rating d-flex justify-content-center gap-2" id="starRatingGroup">
                  <i class="fas fa-star selected" data-value="1"></i>
                  <i class="fas fa-star selected" data-value="2"></i>
                  <i class="fas fa-star selected" data-value="3"></i>
                  <i class="fas fa-star selected" data-value="4"></i>
                  <i class="fas fa-star selected" data-value="5"></i>
                </div>
                <div class="text-muted small mt-2 fw-bold" id="ratingTextDisplay">5 - Excellent Resolution</div>
              </div>

              <div class="mb-3">
                <label class="form-label small fw-bold text-heading">Feedback &amp; Officer Comments</label>
                <textarea class="form-control" id="feedbackComments" rows="4" placeholder="Share your experience regarding SLA timeliness, confidentiality, and officer professionalism..." required>Resolved quickly without compromising my identity. Thank you!</textarea>
              </div>

              <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill" style="background:var(--gradient-brand); border:none;">
                Submit Rating &amp; Review <i class="fas fa-paper-plane ms-1"></i>
              </button>
            </form>
          </div>
        </div>

        <!-- Right Submitted Feedback Preview -->
        <div class="col-lg-6">
          <div class="card-custom">
            <h5 class="fw-bold text-heading mb-3"><i class="fas fa-comments text-primary me-2"></i>My Recent Reviews</h5>
            <div id="reviewsList">
              <div class="p-3 rounded bg-subtle border mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="font-monospace fw-bold text-primary">#CCMS-2026-8902</span>
                  <div class="text-warning small"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                </div>
                <p class="text-muted small mb-1">"Resolved quickly without compromising my identity. Thank you!"</p>
                <div class="text-muted" style="font-size:0.75rem;">Submitted on: 18 July 2026</div>
              </div>
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
  let selectedRating = 5;

  $(document).ready(function() {
    const user = getStoredUser();
    $('#topName').text(user.name);
    $('#topAvatar').text(user.avatarText);

    // Interactive Star Hover & Select
    $('.star-rating i').click(function() {
      selectedRating = $(this).data('value');
      $('.star-rating i').each(function() {
        if ($(this).data('value') <= selectedRating) {
          $(this).addClass('selected');
        } else {
          $(this).removeClass('selected');
        }
      });
      const texts = ["", "1 - Poor", "2 - Fair", "3 - Average", "4 - Good", "5 - Excellent Resolution"];
      $('#ratingTextDisplay').text(texts[selectedRating]);
    });
  });

  function submitFeedback(e) {
    e.preventDefault();
    const complaintId = $('#feedbackComplaintSelect').val();
    const comments = $('#feedbackComments').val();

    const complaints = getStoredComplaints();
    const c = complaints.find(item => item.id === complaintId);
    if (c) {
      c.rating = selectedRating;
      c.feedback = comments;
      saveComplaints(complaints);
    }

    showCcmsToast("Thank you for your valuable rating and feedback!", "success", "Feedback Submitted");
    setTimeout(() => {
      window.location.reload();
    }, 1200);
  }
</script>
</body>
</html>

