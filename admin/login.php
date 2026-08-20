<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Super Admin Login | CCMS</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Orbitron:wght@600;700;900&display=swap" rel="stylesheet" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="css/admin.css" />
</head>
<body class="align-items-center justify-content-center py-5" style="background: var(--bg-main);">

<div class="position-absolute top-0 end-0 p-4">
  <button class="theme-toggle-btn" id="themeToggleBtn" onclick="toggleAdminTheme()" title="Toggle Theme">
    <i class="fas fa-moon"></i>
  </button>
</div>

<div class="container" style="max-width: 440px;">
  <div class="admin-card text-center p-4 p-md-5 shadow-lg">
    <!-- Brand Logo -->
    <a href="../index.php" class="d-inline-block mb-3">
      <h2 class="admin-logo mb-0" style="font-size:2.2rem;">CCMS</h2>
      <div class="text-violet small text-uppercase fw-bold" style="letter-spacing:2px; font-size:0.65rem;"><i class="fas fa-user-shield me-1"></i> Super Admin Control</div>
    </a>

    <h4 class="fw-bold text-heading mb-1">Super Admin Login</h4>
    <p class="text-muted small mb-4">Authorized Master Control Authentication Required</p>

    <form onsubmit="event.preventDefault(); window.location.href='index.php';">
      <div class="text-start mb-3">
        <label class="form-label small fw-bold text-heading">Super Admin Email</label>
        <div class="input-group">
          <span class="input-group-text bg-subtle border-end-0 text-muted"><i class="fas fa-envelope"></i></span>
          <input type="email" class="form-control border-start-0" value="admin@ccms.gov.in" placeholder="admin@domain.com" required />
        </div>
      </div>

      <div class="text-start mb-3">
        <label class="form-label small fw-bold text-heading">Master Password</label>
        <div class="input-group">
          <span class="input-group-text bg-subtle border-end-0 text-muted"><i class="fas fa-key"></i></span>
          <input type="password" class="form-control border-start-0" value="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢" placeholder="Enter password" required />
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100 fw-bold py-2.5 rounded-pill my-3" style="background:var(--gradient-admin); border:none;">
        Authenticate Master Console <i class="fas fa-unlock-keyhole ms-1"></i>
      </button>

      <div class="text-muted small">
        <i class="fas fa-shield-halved text-success me-1"></i> Restricted System Access
      </div>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/admin.js"></script>
</body>
</html>

