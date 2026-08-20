<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Profile | CCMS</title>

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
        <h1 class="page-title">Manage Profile &amp; Security</h1>
        <p class="page-subtitle">Update personal information, profile photo, and password security.</p>
      </div>

      <div class="row g-4">
        <!-- Left Photo Card -->
        <div class="col-lg-4">
          <div class="card-custom text-center">
            <div class="position-relative d-inline-block mb-3">
              <div class="user-avatar-img mx-auto" style="width: 100px; height: 100px; font-size: 2.2rem;" id="cardAvatar">RK</div>
              <label for="avatarUpload" class="position-absolute bottom-0 end-0 bg-primary text-white p-2 rounded-circle shadow border border-white" style="cursor:pointer;" title="Upload Photo">
                <i class="fas fa-camera"></i>
              </label>
              <input type="file" id="avatarUpload" class="d-none" accept="image/*" onchange="handleAvatarUpload(this)" />
            </div>

            <h5 class="fw-bold text-heading mb-1" id="profileNameDisplay">Rajesh Kumar</h5>
            <div class="badge bg-primary bg-opacity-10 text-primary border mb-3">Verified Citizen</div>
            <p class="text-muted small mb-0" id="profileEmailDisplay">rajesh.kumar@example.com</p>

            <hr class="my-4" />

            <div class="text-start small text-muted">
              <div class="d-flex justify-content-between mb-2">
                <span>Member Since:</span>
                <strong class="text-heading" id="profileJoined">January 2026</strong>
              </div>
              <div class="d-flex justify-content-between">
                <span>Encrypted Vault Key:</span>
                <strong class="text-success font-monospace">VERIFIED</strong>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Profile Details Form & Password Change -->
        <div class="col-lg-8">
          <!-- Update Details -->
          <div class="card-custom mb-4">
            <h5 class="fw-bold text-heading mb-3"><i class="fas fa-user-pen text-primary me-2"></i>Personal Details</h5>
            <form id="profileForm" onsubmit="saveProfileDetails(event)">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label small fw-bold text-heading">Full Name</label>
                  <input type="text" class="form-control" id="pName" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-bold text-heading">Email Address</label>
                  <input type="email" class="form-control" id="pEmail" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-bold text-heading">Mobile Number</label>
                  <input type="tel" class="form-control" id="pPhone" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-bold text-heading">National ID / Resident Key</label>
                  <input type="text" class="form-control font-monospace" id="pNatId" readonly />
                </div>
                <div class="col-12">
                  <label class="form-label small fw-bold text-heading">Address / District</label>
                  <textarea class="form-control" id="pAddress" rows="2"></textarea>
                </div>
              </div>
              <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary fw-bold rounded-pill px-4" style="background:var(--gradient-brand); border:none;">
                  <i class="fas fa-save me-1"></i> Save Profile Changes
                </button>
              </div>
            </form>
          </div>

          <!-- Change Password Card -->
          <div class="card-custom">
            <h5 class="fw-bold text-heading mb-3"><i class="fas fa-lock text-primary me-2"></i>Change Password</h5>
            <form onsubmit="event.preventDefault(); showCcmsToast('Password updated successfully!', 'success', 'Password Changed'); this.reset();">
              <div class="row g-3">
                <div class="col-md-4">
                  <label class="form-label small fw-bold text-heading">Current Password</label>
                  <input type="password" class="form-control" placeholder="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢" required />
                </div>
                <div class="col-md-4">
                  <label class="form-label small fw-bold text-heading">New Password</label>
                  <input type="password" class="form-control" placeholder="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢" required />
                </div>
                <div class="col-md-4">
                  <label class="form-label small fw-bold text-heading">Confirm New Password</label>
                  <input type="password" class="form-control" placeholder="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢" required />
                </div>
              </div>
              <div class="mt-4 text-end">
                <button type="submit" class="btn btn-outline-primary fw-bold rounded-pill px-4">
                  Update Password
                </button>
              </div>
            </form>
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
    loadProfile();
  });

  function loadProfile() {
    const user = getStoredUser();
    $('#topName, #profileNameDisplay').text(user.name);
    $('#topAvatar, #cardAvatar').text(user.avatarText);
    $('#profileEmailDisplay').text(user.email);
    $('#profileJoined').text(user.joinedDate || "January 2026");

    $('#pName').val(user.name);
    $('#pEmail').val(user.email);
    $('#pPhone').val(user.phone);
    $('#pNatId').val(user.nationalId);
    $('#pAddress').val(user.address);
  }

  function saveProfileDetails(e) {
    e.preventDefault();
    const user = getStoredUser();
    user.name = $('#pName').val();
    user.email = $('#pEmail').val();
    user.phone = $('#pPhone').val();
    user.address = $('#pAddress').val();
    user.avatarText = user.name.split(' ').map(n=>n[0]).join('').toUpperCase();

    localStorage.setItem("ccms_user", JSON.stringify(user));
    showCcmsToast("Profile details successfully updated!", "success", "Profile Saved");
    loadProfile();
  }

  function handleAvatarUpload(input) {
    if (input.files && input.files[0]) {
      showCcmsToast("New profile picture updated: " + input.files[0].name, "info", "Avatar Updated");
    }
  }
</script>
</body>
</html>

