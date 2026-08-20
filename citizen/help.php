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

  <!-- SIDEBAR NAVIGATION INCLUDE -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- MAIN CONTENT -->
  <main class="app-main">
    <!-- TOP BAR INCLUDE -->
    <?php include 'includes/topbar.php'; ?>

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

<!-- FOOTER INCLUDE -->
<?php include 'includes/footer.php'; ?>
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

