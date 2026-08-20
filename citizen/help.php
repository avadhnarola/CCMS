<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Help &amp; AI Vigilance Chatbot | CCMS</title>

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
  <!-- SIDEBAR NAVIGATION -->
  <aside class="app-sidebar" id="appSidebar">
    <div class="sidebar-header flex-column align-items-start">
      <div class="d-flex align-items-center justify-content-between w-100 mb-1">
        <a href="index.php" class="sidebar-logo">CCMS</a>
        <span class="sidebar-badge">Citizen</span>
      </div>
      <div class="text-muted small fw-semibold" style="letter-spacing: 1px; font-size: 0.65rem; text-transform: uppercase;">Whistleblower Portal</div>

      <!-- User Info Badge -->
      <div class="mt-3 p-2 rounded w-100 d-flex align-items-center gap-2" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
        <div class="position-relative">
          <div class="user-avatar-img" id="sideAvatar">RK</div>
          <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-dark rounded-circle"></span>
        </div>
        <div class="overflow-hidden">
          <div class="fw-bold text-white small text-truncate" id="sideUserName">Rajesh Kumar</div>
          <div class="text-muted small" style="font-size:0.7rem;"><i class="fas fa-shield-alt text-info me-1"></i> Verified Citizen</div>
        </div>
      </div>
    </div>

    <div class="sidebar-nav">
      <div class="nav-section-title">Main Dashboard</div>
      <a href="index.php" class="sidebar-link"><i class="fas fa-chart-pie"></i> Analytics &amp; Overview</a>
      <a href="file-complaint.php" class="sidebar-link"><i class="fas fa-plus-circle"></i> File New Complaint</a>
      <a href="my-complaints.php" class="sidebar-link"><i class="fas fa-folder-open"></i> My Complaints</a>
      <a href="track.php" class="sidebar-link"><i class="fas fa-route"></i> Track Complaint</a>
      <a href="evidence.php" class="sidebar-link"><i class="fas fa-photo-film"></i> Evidence Gallery</a>

      <div class="nav-section-title">Engage &amp; Support</div>
      <a href="feedback.php" class="sidebar-link"><i class="fas fa-star"></i> Feedback &amp; Rating</a>
      <a href="notifications.php" class="sidebar-link"><i class="fas fa-bell"></i> Notifications <span class="badge bg-danger rounded-pill ms-auto" style="font-size:0.65rem;">3</span></a>
      <a href="help.php" class="sidebar-link active"><i class="fas fa-headset"></i> AI Assistance &amp; Help</a>
      <a href="contact.php" class="sidebar-link"><i class="fas fa-envelope"></i> Contact Vigilance</a>

      <div class="nav-section-title">Account Settings</div>
      <a href="profile.php" class="sidebar-link"><i class="fas fa-user-gear"></i> Citizen Profile</a>
      <a href="login.php" class="sidebar-link text-danger" onclick="localStorage.removeItem('ccms_loggedIn');"><i class="fas fa-arrow-right-from-bracket"></i> Sign Out</a>
    </div>

    <div class="sidebar-footer">
      <div class="text-white small fw-bold"><i class="fas fa-lock text-success me-1"></i> Zero-Knowledge Encryption</div>
      <div class="text-muted" style="font-size:0.7rem;">IP Scrubbed • AES-256 Protocol</div>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="app-main">
    <header class="app-topbar">
      <div class="d-flex align-items-center gap-3">
        <button class="btn d-lg-none text-heading p-0 fs-4" onclick="$('#appSidebar').toggleClass('show')">
          <i class="fas fa-bars"></i>
        </button>
        <h5 class="fw-bold mb-0 text-heading">Help Center &amp; AI Assistant</h5>
      </div>

      <div class="d-flex align-items-center gap-3">
        <button class="theme-toggle-btn" id="themeToggleBtn" onclick="toggleTheme()" title="Toggle Theme">
          <i class="fas fa-moon"></i>
        </button>
        <a href="profile.php" class="user-profile-btn">
          <div class="user-avatar-img" id="topAvatar">RK</div>
          <span class="fw-bold small d-none d-md-inline text-heading" id="topName">Rajesh Kumar</span>
        </a>
      </div>
    </header>

    <div class="app-content">
      <div class="page-header">
        <h1 class="page-title">Citizen Help Center</h1>
        <p class="page-subtitle">Instant assistance through our AI Vigilance Assistant or browse common questions.</p>
      </div>

      <div class="row g-4">
        <!-- AI Chatbot Card -->
        <div class="col-lg-6">
          <div class="card-custom chatbot-card">
            <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center gap-2">
                <i class="fas fa-robot text-primary fa-lg"></i>
                <div>
                  <h6 class="fw-bold mb-0 text-heading">AI Vigilance Assistant</h6>
                  <span class="badge bg-success bg-opacity-10 text-success" style="font-size:0.65rem;">Online &bull; 24/7 Support</span>
                </div>
              </div>
              <button class="btn btn-sm btn-subtle text-muted" onclick="clearChat()">Clear Chat</button>
            </div>

            <!-- Chat Messages Container -->
            <div class="chat-messages" id="chatContainer">
              <div class="chat-bubble bot">
                Hello! I am your CCMS AI Assistant. How can I help you today? You can ask me about anonymous filing, tracking keys, evidence uploading, or whistleblower rights!
              </div>
            </div>

            <!-- Quick Suggestions -->
            <div class="px-3 py-2 border-top bg-subtle d-flex gap-2 overflow-x-auto" style="white-space:nowrap;">
              <button class="btn btn-sm btn-outline-primary rounded-pill py-1 px-3" onclick="sendQuickMsg('How does anonymous mode work?')">Anonymous Mode?</button>
              <button class="btn btn-sm btn-outline-primary rounded-pill py-1 px-3" onclick="sendQuickMsg('How do I track my complaint?')">Track Complaint?</button>
              <button class="btn btn-sm btn-outline-primary rounded-pill py-1 px-3" onclick="sendQuickMsg('Can I withdraw a complaint?')">Withdraw Complaint?</button>
            </div>

            <!-- Chat Input Bar -->
            <div class="p-3 border-top">
              <form class="d-flex gap-2" onsubmit="handleUserChatSubmit(event)">
                <input type="text" id="chatInputText" class="form-control" placeholder="Ask a question..." required />
                <button type="submit" class="btn btn-primary fw-bold px-3" style="background:var(--gradient-brand); border:none;">
                  <i class="fas fa-paper-plane"></i>
                </button>
              </form>
            </div>
          </div>
        </div>

        <!-- FAQ Accordion Card -->
        <div class="col-lg-6">
          <div class="card-custom">
            <h5 class="fw-bold text-heading mb-3"><i class="fas fa-circle-question text-primary me-2"></i>Frequently Asked Questions</h5>
            
            <div class="accordion accordion-flush" id="faqCitizenAccordion">
              <div class="accordion-item bg-transparent">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed fw-bold text-heading bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#cfaq1">
                    Is my identity 100% protected when reporting anonymously?
                  </button>
                </h2>
                <div id="cfaq1" class="accordion-collapse collapse" data-bs-parent="#faqCitizenAccordion">
                  <div class="accordion-body text-muted small">
                    Yes. Selecting Anonymous Mode during complaint filing strips IP addresses, EXIF file metadata, and browser footprints before saving into our encrypted database.
                  </div>
                </div>
              </div>

              <div class="accordion-item bg-transparent">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed fw-bold text-heading bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#cfaq2">
                    How long does it take for a complaint to be assigned?
                  </button>
                </h2>
                <div id="cfaq2" class="accordion-collapse collapse" data-bs-parent="#faqCitizenAccordion">
                  <div class="accordion-body text-muted small">
                    Complaints are triaged by our automated AI urgency filter and assigned to an Anti-Corruption Officer within the mandated 24-hour SLA.
                  </div>
                </div>
              </div>

              <div class="accordion-item bg-transparent">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed fw-bold text-heading bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#cfaq3">
                    Can I withdraw my complaint after submission?
                  </button>
                </h2>
                <div id="cfaq3" class="accordion-collapse collapse" data-bs-parent="#faqCitizenAccordion">
                  <div class="accordion-body text-muted small">
                    You can withdraw your complaint from the 'My Complaints' page as long as its status remains 'Pending' (prior to officer assignment).
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>
</div>

<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/citizen.js"></script>
<script>
  $(document).ready(function() {
    const user = getStoredUser();
    $('#topName').text(user.name);
    $('#topAvatar').text(user.avatarText);
  });

  function handleUserChatSubmit(e) {
    e.preventDefault();
    const text = $('#chatInputText').val().trim();
    if (!text) return;

    // Append user message
    $('#chatContainer').append(`<div class="chat-bubble user">${text}</div>`);
    $('#chatInputText').val('');
    scrollToChatBottom();

    // Bot response simulation
    setTimeout(() => {
      const response = getAIChatbotResponse(text);
      $('#chatContainer').append(`<div class="chat-bubble bot">${response}</div>`);
      scrollToChatBottom();
    }, 600);
  }

  function sendQuickMsg(msg) {
    $('#chatInputText').val(msg);
    handleUserChatSubmit(new Event('submit'));
  }

  function clearChat() {
    $('#chatContainer').html(`<div class="chat-bubble bot">Chat cleared. How can I assist you further?</div>`);
  }

  function scrollToChatBottom() {
    const container = document.getElementById("chatContainer");
    container.scrollTop = container.scrollHeight;
  }
</script>
</body>
</html>

