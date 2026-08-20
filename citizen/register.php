<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="CCMS Citizen Registration â€” Create your anonymous, encrypted whistleblower account and join thousands of citizens fighting corruption." />
  <title>Create Citizen Account | CCMS â€” Corruption Complaint Management System</title>
  <link rel="icon" type="image/png" href="../logo.png" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Orbitron:wght@600;700;800;900&display=swap" rel="stylesheet" />

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <style>
    :root {
      --bg: #f8fafc;
      --surface: #ffffff;
      --subtle: #f1f5f9;
      --border: #e2e8f0;
      --border-hover: #cbd5e1;
      --primary: #2563eb;
      --primary-dark: #1d4ed8;
      --primary-light: rgba(37,99,235,0.08);
      --accent: #7c3aed;
      --success: #059669;
      --danger: #e11d48;
      --warning: #d97706;
      --heading: #0f172a;
      --body: #334155;
      --muted: #64748b;
      --grad-brand: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
      --grad-panel: linear-gradient(145deg, #064e3b 0%, #065f46 40%, #0f766e 100%);
      --transition: all 0.35s cubic-bezier(.25,.8,.25,1);
    }
    [data-theme="dark"] {
      --bg: #0b1329;
      --surface: #111c38;
      --subtle: #192648;
      --border: rgba(255,255,255,0.1);
      --border-hover: rgba(56,189,248,0.3);
      --primary: #38bdf8;
      --primary-dark: #0284c7;
      --primary-light: rgba(56,189,248,0.12);
      --accent: #a78bfa;
      --success: #34d399;
      --danger: #f87171;
      --warning: #fbbf24;
      --heading: #f8fafc;
      --body: #cbd5e1;
      --muted: #94a3b8;
      --grad-brand: linear-gradient(135deg, #00d4ff 0%, #8b5cf6 100%);
      --grad-panel: linear-gradient(145deg, #042f1f 0%, #053320 40%, #063a2a 100%);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Inter', sans-serif; background: var(--bg); color: var(--body);
      min-height: 100vh; display: flex; overflow-x: hidden;
      transition: background 0.3s ease, color 0.3s ease;
    }
    a { text-decoration: none; color: inherit; }
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: var(--bg); }
    ::-webkit-scrollbar-thumb { background: var(--border-hover); border-radius: 99px; }

    .auth-page { display: flex; width: 100%; min-height: 100vh; }

    /* â”€â”€â”€ LEFT PANEL â”€â”€â”€ */
    .brand-panel {
      width: 42%;
      background: var(--grad-panel);
      position: relative; overflow: hidden;
      display: flex; flex-direction: column;
      justify-content: center; align-items: flex-start;
      padding: 60px 56px;
    }
    .brand-panel::before {
      content: '';
      position: absolute; inset: 0;
      background:
        radial-gradient(circle at 25% 25%, rgba(52,211,153,0.18) 0%, transparent 55%),
        radial-gradient(circle at 75% 75%, rgba(56,189,248,0.15) 0%, transparent 50%);
    }
    .brand-panel::after {
      content: ''; position: absolute; inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
      background-size: 40px 40px;
    }
    .brand-panel-content { position: relative; z-index: 2; width: 100%; }

    .brand-wordmark {
      font-family: 'Orbitron', sans-serif;
      font-size: 2.8rem; font-weight: 900; color: #fff;
      letter-spacing: 2px; line-height: 1;
      display: inline-block; text-decoration: none;
    }
    .brand-wordmark span {
      display: block; font-family: 'Inter', sans-serif;
      font-size: 0.7rem; font-weight: 700; letter-spacing: 3px;
      text-transform: uppercase; color: rgba(255,255,255,0.55); margin-top: 8px;
    }
    .brand-divider {
      width: 52px; height: 3px;
      background: linear-gradient(90deg, #34d399, #38bdf8);
      border-radius: 99px; margin: 24px 0;
    }
    .brand-headline { font-size: 1.7rem; font-weight: 800; color: #fff; line-height: 1.3; margin-bottom: 16px; }
    .brand-desc { font-size: 0.92rem; color: rgba(255,255,255,0.6); line-height: 1.8; max-width: 370px; margin-bottom: 36px; }

    /* Steps */
    .reg-steps { display: flex; flex-direction: column; gap: 20px; }
    .reg-step { display: flex; align-items: flex-start; gap: 14px; }
    .step-num {
      width: 34px; height: 34px; border-radius: 50%;
      background: rgba(255,255,255,0.15); border: 2px solid rgba(255,255,255,0.25);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.82rem; font-weight: 800; color: #fff; flex-shrink: 0;
      font-family: 'Orbitron', sans-serif;
    }
    .step-num.done { background: rgba(52,211,153,0.3); border-color: #34d399; color: #34d399; }
    .step-text strong { display: block; font-size: 0.88rem; font-weight: 700; color: #fff; }
    .step-text span { font-size: 0.77rem; color: rgba(255,255,255,0.5); line-height: 1.5; }

    .stats-mini {
      margin-top: 36px; padding: 18px 22px;
      background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);
      border-radius: 14px; display: flex; gap: 32px;
    }
    .stat-mini { text-align: center; }
    .stat-mini-value { font-size: 1.4rem; font-weight: 900; color: #fff; font-family: 'Orbitron', sans-serif; }
    .stat-mini-label { font-size: 0.72rem; color: rgba(255,255,255,0.5); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }

    /* Orbs */
    .orb {
      position: absolute; border-radius: 50%;
      filter: blur(60px); pointer-events: none; z-index: 1;
    }
    .orb-1 { width: 280px; height: 280px; background: rgba(5,150,105,0.25); top: -60px; right: -60px; animation: drift 9s ease-in-out infinite; }
    .orb-2 { width: 200px; height: 200px; background: rgba(56,189,248,0.2); bottom: -50px; left: -50px; animation: drift 11s ease-in-out infinite reverse; }
    @keyframes drift { 0%,100% { transform: translate(0,0); } 50% { transform: translate(18px,-18px); } }

    /* â”€â”€â”€ RIGHT PANEL â”€â”€â”€ */
    .form-panel {
      flex: 1; display: flex; flex-direction: column;
      justify-content: flex-start; align-items: center;
      padding: 32px 40px; background: var(--bg);
      position: relative; overflow-y: auto;
      transition: background 0.3s ease;
    }
    .panel-controls {
      position: sticky; top: 0; width: 100%; display: flex;
      justify-content: flex-end; align-items: center; gap: 12px;
      padding-bottom: 16px; z-index: 10;
    }
    .back-link {
      display: inline-flex; align-items: center; gap: 6px;
      font-size: 0.83rem; font-weight: 600; color: var(--muted);
      background: var(--subtle); border: 1px solid var(--border);
      padding: 7px 14px; border-radius: 50px; transition: var(--transition);
    }
    .back-link:hover { color: var(--primary); border-color: var(--primary); background: var(--primary-light); }
    .theme-btn {
      width: 38px; height: 38px; border-radius: 50%;
      border: 1px solid var(--border); background: var(--subtle);
      color: var(--heading); display: flex; align-items: center;
      justify-content: center; cursor: pointer; font-size: 0.9rem; transition: var(--transition);
    }
    .theme-btn:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-light); }

    .auth-card { width: 100%; max-width: 500px; padding-bottom: 40px; }

    .auth-header { margin-bottom: 28px; }
    .auth-tag {
      display: inline-flex; align-items: center; gap: 8px;
      font-size: 0.75rem; font-weight: 800; letter-spacing: 2px;
      text-transform: uppercase; color: var(--success);
      background: rgba(5,150,105,0.08); border: 1px solid rgba(5,150,105,0.2);
      padding: 5px 14px; border-radius: 50px; margin-bottom: 16px;
    }
    [data-theme="dark"] .auth-tag { color: var(--success); background: rgba(52,211,153,0.1); border-color: rgba(52,211,153,0.25); }
    .auth-title { font-size: 1.85rem; font-weight: 900; color: var(--heading); letter-spacing: -0.5px; line-height: 1.2; margin-bottom: 6px; }
    .auth-subtitle { font-size: 0.9rem; color: var(--muted); line-height: 1.6; }

    /* Progress indicator */
    .reg-progress {
      display: flex; align-items: center; gap: 8px; margin-bottom: 28px;
    }
    .prog-step {
      display: flex; align-items: center; gap: 6px;
      font-size: 0.78rem; font-weight: 600; color: var(--muted);
    }
    .prog-step.active { color: var(--primary); }
    .prog-step.done { color: var(--success); }
    .prog-dot {
      width: 26px; height: 26px; border-radius: 50%;
      border: 2px solid var(--border); background: var(--surface);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.72rem; font-weight: 700; transition: var(--transition);
    }
    .prog-step.active .prog-dot { border-color: var(--primary); color: var(--primary); background: var(--primary-light); }
    .prog-step.done .prog-dot { border-color: var(--success); color: var(--success); background: rgba(5,150,105,0.08); }
    .prog-line { flex: 1; height: 2px; background: var(--border); border-radius: 99px; }
    .prog-line.done { background: var(--success); }

    /* Form elements */
    .form-group { margin-bottom: 18px; }
    .field-label { display: block; font-size: 0.83rem; font-weight: 700; color: var(--heading); margin-bottom: 8px; }
    .field-hint { font-size: 0.75rem; color: var(--muted); font-weight: 400; margin-left: 4px; }

    .input-wrapper { position: relative; }
    .input-icon {
      position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
      color: var(--muted); font-size: 0.9rem; pointer-events: none; z-index: 2; transition: color 0.25s;
    }
    .input-wrapper:focus-within .input-icon { color: var(--primary); }
    .form-field {
      width: 100%; padding: 12px 14px 12px 40px;
      font-family: 'Inter', sans-serif; font-size: 0.9rem;
      color: var(--heading); background: var(--surface);
      border: 1.5px solid var(--border); border-radius: 11px;
      outline: none; transition: border-color 0.25s, box-shadow 0.25s;
    }
    .form-field::placeholder { color: var(--muted); }
    .form-field:focus { border-color: var(--primary); box-shadow: 0 0 0 4px var(--primary-light); }
    .form-field.is-valid { border-color: var(--success); box-shadow: 0 0 0 4px rgba(5,150,105,0.08); }
    .form-field.is-invalid { border-color: var(--danger); box-shadow: 0 0 0 4px rgba(225,29,72,0.08); }

    /* Password with toggle */
    .pw-toggle {
      position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
      background: none; border: none; padding: 4px; cursor: pointer;
      color: var(--muted); font-size: 0.9rem; z-index: 2; transition: color 0.2s;
    }
    .pw-toggle:hover { color: var(--primary); }
    .has-toggle .form-field { padding-right: 42px; }

    /* Password strength bar */
    .pw-strength { margin-top: 8px; }
    .pw-strength-bar {
      height: 4px; background: var(--border); border-radius: 99px; overflow: hidden; margin-bottom: 4px;
    }
    .pw-strength-fill {
      height: 100%; border-radius: 99px; width: 0%;
      transition: width 0.4s ease, background-color 0.4s ease;
    }
    .pw-strength-label { font-size: 0.75rem; font-weight: 600; color: var(--muted); }

    /* OTP section */
    .otp-section {
      background: var(--subtle); border: 1px solid var(--border);
      border-radius: 12px; padding: 16px;
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 18px;
    }
    .otp-info strong { display: block; font-size: 0.87rem; font-weight: 700; color: var(--heading); }
    .otp-info span { font-size: 0.77rem; color: var(--muted); }

    /* Custom switch */
    .switch { position: relative; display: inline-block; width: 44px; height: 24px; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider {
      position: absolute; cursor: pointer; inset: 0;
      background: var(--border-hover); border-radius: 99px; transition: 0.3s;
    }
    .slider::before {
      content: ''; position: absolute;
      width: 18px; height: 18px; left: 3px; bottom: 3px;
      background: white; border-radius: 50%; transition: 0.3s;
    }
    input:checked + .slider { background: var(--primary); }
    input:checked + .slider::before { transform: translateX(20px); }

    /* Terms checkbox */
    .terms-row {
      display: flex; align-items: flex-start; gap: 10px; margin-bottom: 22px;
    }
    .custom-check { width: 18px; height: 18px; border: 2px solid var(--border-hover); border-radius: 5px; cursor: pointer; accent-color: var(--primary); flex-shrink: 0; margin-top: 2px; }
    .check-label { font-size: 0.83rem; color: var(--muted); line-height: 1.5; }
    .check-label a { color: var(--primary); font-weight: 600; }

    /* Submit */
    .btn-submit {
      width: 100%; padding: 15px;
      background: var(--grad-brand); color: #fff;
      font-family: 'Inter', sans-serif; font-size: 0.97rem; font-weight: 700;
      border: none; border-radius: 12px; cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 10px;
      box-shadow: 0 8px 25px rgba(37,99,235,0.3); transition: var(--transition);
      position: relative; overflow: hidden;
    }
    .btn-submit::before {
      content: ''; position: absolute; top: 0; left: -100%;
      width: 100%; height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
      transition: left 0.5s ease;
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 14px 35px rgba(124,58,237,0.4); }
    .btn-submit:hover::before { left: 100%; }
    .btn-submit:active { transform: translateY(0); }
    .btn-submit .spinner-inner {
      width: 18px; height: 18px; border: 2.5px solid rgba(255,255,255,0.4);
      border-top-color: #fff; border-radius: 50%;
      animation: spin 0.7s linear infinite; display: none;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .btn-submit.loading .btn-text { display: none; }
    .btn-submit.loading .spinner-inner { display: block; }

    .auth-divider { display: flex; align-items: center; gap: 14px; margin: 20px 0; }
    .auth-divider::before, .auth-divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
    .auth-divider span { font-size: 0.78rem; font-weight: 600; color: var(--muted); white-space: nowrap; }

    .auth-footer { text-align: center; font-size: 0.85rem; color: var(--muted); }
    .auth-footer a { color: var(--primary); font-weight: 700; }
    .auth-footer a:hover { opacity: 0.75; }

    .auth-alert {
      padding: 12px 16px; border-radius: 10px; font-size: 0.85rem; font-weight: 600;
      margin-bottom: 18px; display: none; align-items: center; gap: 10px;
    }
    .auth-alert.error { background: rgba(225,29,72,0.08); border: 1px solid rgba(225,29,72,0.2); color: var(--danger); }
    .auth-alert.success { background: rgba(5,150,105,0.08); border: 1px solid rgba(5,150,105,0.2); color: var(--success); }

    /* Field row */
    .fields-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    /* OTP Modal */
    .otp-inputs { display: flex; gap: 10px; justify-content: center; margin: 20px 0; }
    .otp-digit {
      width: 52px; height: 60px; text-align: center;
      font-size: 1.5rem; font-weight: 800;
      border: 2px solid var(--border); border-radius: 12px;
      background: var(--surface); color: var(--heading);
      font-family: 'Orbitron', sans-serif; outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .otp-digit:focus { border-color: var(--primary); box-shadow: 0 0 0 4px var(--primary-light); }
    .modal-glass {
      background: var(--surface); border: 1px solid var(--border);
      border-radius: 20px; box-shadow: 0 30px 80px rgba(15,23,42,0.2);
    }

    @media (max-width: 900px) { .brand-panel { display: none; } .form-panel { padding: 24px; } }
    @media (max-width: 560px) { .fields-row { grid-template-columns: 1fr; } .auth-title { font-size: 1.55rem; } }
  </style>
</head>
<body>

<div class="auth-page">

  <!-- â”€â”€â”€ LEFT BRAND PANEL â”€â”€â”€ -->
  <div class="brand-panel">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="brand-panel-content">
      <a href="../index.php" class="brand-wordmark">
        CCMS
        <span>Corruption Complaint Management System</span>
      </a>
      <div class="brand-divider"></div>
      <h2 class="brand-headline">Join the Fight<br />Against Corruption</h2>
      <p class="brand-desc">
        Create your secure citizen account in under 2 minutes. Your identity is protected by military-grade encryption from the moment you register.
      </p>

      <div class="reg-steps">
        <div class="reg-step">
          <div class="step-num done"><i class="fas fa-check" style="font-size:0.75rem;"></i></div>
          <div class="step-text">
            <strong>Create Secure Account</strong>
            <span>Register with your email and a strong password</span>
          </div>
        </div>
        <div class="reg-step">
          <div class="step-num">2</div>
          <div class="step-text">
            <strong>Verify Your Identity</strong>
            <span>Quick OTP verification to secure your account</span>
          </div>
        </div>
        <div class="reg-step">
          <div class="step-num">3</div>
          <div class="step-text">
            <strong>File Your First Complaint</strong>
            <span>Report anonymously with end-to-end encryption</span>
          </div>
        </div>
        <div class="reg-step">
          <div class="step-num">4</div>
          <div class="step-text">
            <strong>Track Investigation Live</strong>
            <span>Real-time updates on every stage of inquiry</span>
          </div>
        </div>
      </div>

      <div class="stats-mini">
        <div class="stat-mini">
          <div class="stat-mini-value">15K+</div>
          <div class="stat-mini-label">Citizens</div>
        </div>
        <div class="stat-mini">
          <div class="stat-mini-value">95%</div>
          <div class="stat-mini-label">Resolution</div>
        </div>
        <div class="stat-mini">
          <div class="stat-mini-value">24hr</div>
          <div class="stat-mini-label">Response</div>
        </div>
      </div>
    </div>
  </div>

  <!-- â”€â”€â”€ RIGHT FORM PANEL â”€â”€â”€ -->
  <div class="form-panel">
    <div class="panel-controls">
      <a href="../index.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Home</a>
      <button class="theme-btn" onclick="toggleTheme()" title="Toggle Theme">
        <i class="fas fa-moon" id="themeIcon"></i>
      </button>
    </div>

    <div class="auth-card">
      <div class="auth-header">
        <div class="auth-tag"><i class="fas fa-user-shield" style="font-size:0.75rem;"></i>New Citizen Account</div>
        <h1 class="auth-title">Create Your Account</h1>
        <p class="auth-subtitle">Join 15,000+ citizens fighting bribery, fraud, and public sector corruption across India.</p>
      </div>

      <!-- Progress -->
      <div class="reg-progress">
        <div class="prog-step active">
          <div class="prog-dot">1</div>
          <span>Details</span>
        </div>
        <div class="prog-line" id="line1"></div>
        <div class="prog-step" id="step2">
          <div class="prog-dot">2</div>
          <span>Verify</span>
        </div>
        <div class="prog-line" id="line2"></div>
        <div class="prog-step" id="step3">
          <div class="prog-dot">3</div>
          <span>Done</span>
        </div>
      </div>

      <!-- Alert -->
      <div class="auth-alert" id="regAlert">
        <i class="fas fa-circle-exclamation"></i>
        <span id="alertMessage"></span>
      </div>

      <!-- Registration Form -->
      <form id="registerForm" onsubmit="handleRegister(event)" novalidate>

        <!-- Full Name -->
        <div class="form-group">
          <label class="field-label" for="regName">Full Name</label>
          <div class="input-wrapper">
            <i class="fas fa-user input-icon"></i>
            <input type="text" class="form-field" id="regName" placeholder="e.g. Rajesh Kumar" autocomplete="name" required />
          </div>
        </div>

        <!-- Email & Phone -->
        <div class="fields-row">
          <div class="form-group">
            <label class="field-label" for="regEmail">Email Address</label>
            <div class="input-wrapper">
              <i class="fas fa-envelope input-icon"></i>
              <input type="email" class="form-field" id="regEmail" placeholder="name@domain.com" autocomplete="email" required />
            </div>
          </div>
          <div class="form-group">
            <label class="field-label" for="regPhone">Mobile Number</label>
            <div class="input-wrapper">
              <i class="fas fa-phone input-icon"></i>
              <input type="tel" class="form-field" id="regPhone" placeholder="+91 98765 43210" autocomplete="tel" required />
            </div>
          </div>
        </div>

        <!-- Address -->
        <div class="form-group">
          <label class="field-label" for="regAddress">
            Residential Address
            <span class="field-hint">(Optional)</span>
          </label>
          <div class="input-wrapper">
            <i class="fas fa-location-dot input-icon"></i>
            <input type="text" class="form-field" id="regAddress" placeholder="City, State" autocomplete="street-address" />
          </div>
        </div>

        <!-- Password & Confirm -->
        <div class="fields-row">
          <div class="form-group">
            <label class="field-label" for="regPassword">Password</label>
            <div class="input-wrapper has-toggle">
              <i class="fas fa-lock input-icon"></i>
              <input type="password" class="form-field" id="regPassword" placeholder="Create password" autocomplete="new-password" required oninput="checkStrength(this.value)" />
              <button type="button" class="pw-toggle" onclick="togglePw('regPassword', 'pwIcon1')">
                <i class="fas fa-eye" id="pwIcon1"></i>
              </button>
            </div>
            <div class="pw-strength" id="strengthContainer">
              <div class="pw-strength-bar"><div class="pw-strength-fill" id="strengthFill"></div></div>
              <div class="pw-strength-label" id="strengthLabel">Enter a password</div>
            </div>
          </div>
          <div class="form-group">
            <label class="field-label" for="regConfirm">Confirm Password</label>
            <div class="input-wrapper has-toggle">
              <i class="fas fa-lock input-icon"></i>
              <input type="password" class="form-field" id="regConfirm" placeholder="Repeat password" autocomplete="new-password" required oninput="checkMatch()" />
              <button type="button" class="pw-toggle" onclick="togglePw('regConfirm', 'pwIcon2')">
                <i class="fas fa-eye" id="pwIcon2"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Email Verification OTP Toggle -->
        <div class="otp-section">
          <div class="otp-info">
            <strong><i class="fas fa-envelope-open-text me-2" style="color:var(--primary);"></i>Email OTP Verification</strong>
            <span>Verify your email address via a 6-digit OTP code</span>
          </div>
          <label class="switch">
            <input type="checkbox" id="otpSwitch" checked />
            <span class="slider"></span>
          </label>
        </div>

        <!-- Terms -->
        <div class="terms-row">
          <input type="checkbox" class="custom-check" id="termsCheck" required />
          <label class="check-label" for="termsCheck">
            I agree to the <a href="#">Terms of Service</a>, <a href="#">Privacy Policy</a>, and <a href="#">Whistleblower Protection Guidelines</a>. I confirm I am filing complaints in good faith.
          </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-submit" id="regBtn">
          <div class="spinner-inner"></div>
          <span class="btn-text">
            <i class="fas fa-user-plus"></i>
            Create Secure Account
          </span>
        </button>

      </form>

      <div class="auth-divider" style="margin-top:22px;"><span>Already registered?</span></div>
      <div class="auth-footer">
        Already have an account? <a href="login.php">Sign In <i class="fas fa-arrow-right" style="font-size:0.78rem;"></i></a>
      </div>

      <div style="display:flex;align-items:center;gap:8px;margin-top:20px;padding:12px 14px;background:var(--subtle);border:1px solid var(--border);border-radius:10px;">
        <i class="fas fa-shield-halved" style="color:var(--success);font-size:0.9rem;"></i>
        <span style="font-size:0.77rem;color:var(--muted);line-height:1.4;">Your data is encrypted end-to-end. We never sell, share, or expose your personal information to any third party.</span>
      </div>
    </div>
  </div>
</div>


<!-- â”€â”€â”€ OTP VERIFICATION MODAL â”€â”€â”€ -->
<div class="modal fade" id="otpModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-glass">
      <div class="modal-body p-5 text-center">
        <div style="width:64px;height:64px;border-radius:50%;background:rgba(37,99,235,0.1);border:2px solid rgba(37,99,235,0.2);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
          <i class="fas fa-envelope-open-text" style="font-size:1.5rem;color:var(--primary);"></i>
        </div>
        <h5 class="fw-bold mb-1" style="color:var(--heading);">Verify Your Email</h5>
        <p class="text-muted small mb-0" id="otpEmailText">Enter the 6-digit code sent to your email address</p>

        <div class="otp-inputs mt-3">
          <input type="text" class="otp-digit" id="otp1" maxlength="1" oninput="otpNext(this, 'otp2')" onkeydown="otpBack(event, this, null)" />
          <input type="text" class="otp-digit" id="otp2" maxlength="1" oninput="otpNext(this, 'otp3')" onkeydown="otpBack(event, this, 'otp1')" />
          <input type="text" class="otp-digit" id="otp3" maxlength="1" oninput="otpNext(this, 'otp4')" onkeydown="otpBack(event, this, 'otp2')" />
          <input type="text" class="otp-digit" id="otp4" maxlength="1" oninput="otpNext(this, 'otp5')" onkeydown="otpBack(event, this, 'otp3')" />
          <input type="text" class="otp-digit" id="otp5" maxlength="1" oninput="otpNext(this, 'otp6')" onkeydown="otpBack(event, this, 'otp4')" />
          <input type="text" class="otp-digit" id="otp6" maxlength="1" oninput="otpNext(this, null)" onkeydown="otpBack(event, this, 'otp5')" />
        </div>

        <div class="auth-alert" id="otpAlert" style="text-align:left;margin-bottom:10px;">
          <i class="fas fa-circle-exclamation"></i><span id="otpAlertMsg"></span>
        </div>

        <p class="text-muted small mb-0">
          Demo OTP: <strong style="font-family:'Orbitron',sans-serif;color:var(--primary);letter-spacing:3px;">1 2 3 4 5 6</strong>
        </p>

        <div style="display:flex;gap:10px;margin-top:20px;">
          <button class="btn w-50 fw-bold rounded-pill" onclick="closeOtp()" style="background:var(--subtle);color:var(--heading);border:1px solid var(--border);font-family:'Inter',sans-serif;">
            Cancel
          </button>
          <button class="btn w-50 fw-bold rounded-pill" onclick="verifyOtp()" style="background:var(--grad-brand);color:#fff;border:none;font-family:'Inter',sans-serif;" id="verifyBtn">
            Verify & Continue
          </button>
        </div>

        <div class="mt-3">
          <span class="text-muted small">Didn't receive the code? </span>
          <a href="#" class="small fw-bold" style="color:var(--primary);" onclick="resendOtp(event)">Resend OTP</a>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // THEME
  const html = document.documentElement;
  function applyTheme(t) {
    html.setAttribute('data-theme', t);
    document.getElementById('themeIcon').className = t === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    localStorage.setItem('ccms_theme', t);
  }
  function toggleTheme() { applyTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark'); }
  applyTheme(localStorage.getItem('ccms_theme') || 'light');

  // PASSWORD TOGGLE
  function togglePw(fieldId, iconId) {
    const pw = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
    if (pw.type === 'password') { pw.type = 'text'; icon.className = 'fas fa-eye-slash'; }
    else { pw.type = 'password'; icon.className = 'fas fa-eye'; }
  }

  // PASSWORD STRENGTH
  function checkStrength(val) {
    const fill = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');
    const pw = document.getElementById('regPassword');
    if (!val) {
      fill.style.width = '0%';
      label.textContent = 'Enter a password';
      label.style.color = 'var(--muted)';
      pw.className = 'form-field';
      return;
    }
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const levels = [
      { w: '25%', c: '#e11d48', t: 'Very Weak' },
      { w: '50%', c: '#d97706', t: 'Weak' },
      { w: '75%', c: '#2563eb', t: 'Good' },
      { w: '100%', c: '#059669', t: 'Strong' }
    ];
    const l = levels[Math.max(score - 1, 0)];
    fill.style.width = l.w;
    fill.style.backgroundColor = l.c;
    label.textContent = l.t;
    label.style.color = l.c;
    pw.className = 'form-field ' + (score >= 3 ? 'is-valid' : 'is-invalid');
  }

  // PASSWORD MATCH
  function checkMatch() {
    const pw = document.getElementById('regPassword').value;
    const conf = document.getElementById('regConfirm');
    if (!conf.value) { conf.className = 'form-field'; return; }
    conf.className = 'form-field ' + (pw === conf.value ? 'is-valid' : 'is-invalid');
  }

  // REAL-TIME VALIDATION
  document.getElementById('regEmail').addEventListener('input', function() {
    const v = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value);
    this.className = 'form-field ' + (this.value ? (v ? 'is-valid' : 'is-invalid') : '');
  });
  document.getElementById('regPhone').addEventListener('input', function() {
    const v = /^[+]?[\d\s\-]{8,15}$/.test(this.value.replace(/\s/g, ''));
    this.className = 'form-field ' + (this.value ? (v ? 'is-valid' : 'is-invalid') : '');
  });
  document.getElementById('regName').addEventListener('input', function() {
    this.className = 'form-field ' + (this.value.trim().length >= 3 ? 'is-valid' : this.value ? 'is-invalid' : '');
  });

  // REGISTER HANDLER
  let pendingUser = null;
  function handleRegister(e) {
    e.preventDefault();
    const name = document.getElementById('regName').value.trim();
    const email = document.getElementById('regEmail').value.trim();
    const phone = document.getElementById('regPhone').value.trim();
    const address = document.getElementById('regAddress').value.trim();
    const pw = document.getElementById('regPassword').value;
    const conf = document.getElementById('regConfirm').value;
    const terms = document.getElementById('termsCheck').checked;
    const btn = document.getElementById('regBtn');
    const alert = document.getElementById('regAlert');
    alert.style.display = 'none';

    if (!name || !email || !phone || !pw || !conf) { showAlert('Please fill in all required fields.'); return; }
    if (name.trim().length < 3) { showAlert('Please enter your full name (at least 3 characters).'); return; }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showAlert('Please enter a valid email address.'); return; }
    if (!/^[+]?[\d\s\-]{8,15}$/.test(phone.replace(/\s/g, ''))) { showAlert('Please enter a valid mobile number.'); return; }
    if (pw.length < 8) { showAlert('Password must be at least 8 characters.'); return; }
    if (pw !== conf) { showAlert('Passwords do not match. Please re-enter.'); return; }
    if (!terms) { showAlert('You must agree to the Terms of Service to register.'); return; }

    pendingUser = {
      name, email, phone, address: address || 'Not provided',
      nationalId: 'IND-2026-' + Math.floor(1000 + Math.random() * 9000),
      joinedDate: new Date().toLocaleDateString('en-IN', { month: 'long', year: 'numeric' }),
      avatarText: name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
    };

    btn.classList.add('loading'); btn.disabled = true;

    setTimeout(() => {
      btn.classList.remove('loading'); btn.disabled = false;
      if (document.getElementById('otpSwitch').checked) {
        document.getElementById('otpEmailText').textContent = 'Enter the 6-digit code sent to ' + email;
        ['otp1','otp2','otp3','otp4','otp5','otp6'].forEach(id => document.getElementById(id).value = '');
        new bootstrap.Modal(document.getElementById('otpModal')).show();
        setTimeout(() => document.getElementById('otp1').focus(), 300);
      } else {
        completeRegistration();
      }
    }, 1000);
  }

  function completeRegistration() {
    if (!pendingUser) return;
    localStorage.setItem('ccms_user', JSON.stringify(pendingUser));
    localStorage.setItem('ccms_loggedIn', 'true');

    // Advance progress
    ['step2','step3'].forEach(id => document.getElementById(id).classList.add('done'));
    ['line1','line2'].forEach(id => document.getElementById(id).classList.add('done'));

    showSuccess('Registration successful! Welcome to CCMS, ' + pendingUser.name + '!');
    setTimeout(() => { window.location.href = 'index.php'; }, 1800);
  }

  function showAlert(msg) {
    const el = document.getElementById('regAlert');
    document.getElementById('alertMessage').textContent = msg;
    el.className = 'auth-alert error'; el.style.display = 'flex';
    el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }
  function showSuccess(msg) {
    const el = document.getElementById('regAlert');
    document.getElementById('alertMessage').textContent = msg;
    el.className = 'auth-alert success'; el.style.display = 'flex';
    el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }

  // OTP LOGIC
  function otpNext(el, nextId) {
    el.value = el.value.replace(/[^0-9]/g, '');
    if (el.value && nextId) document.getElementById(nextId).focus();
    checkOtpFilled();
  }
  function otpBack(e, el, prevId) {
    if (e.key === 'Backspace' && !el.value && prevId) document.getElementById(prevId).focus();
  }
  function checkOtpFilled() {
    const digits = ['otp1','otp2','otp3','otp4','otp5','otp6'];
    const all = digits.every(id => document.getElementById(id).value !== '');
    document.getElementById('verifyBtn').style.opacity = all ? '1' : '0.6';
  }

  function verifyOtp() {
    const code = ['otp1','otp2','otp3','otp4','otp5','otp6'].map(id => document.getElementById(id).value).join('');
    const otpAlertEl = document.getElementById('otpAlert');
    if (code.length < 6) {
      document.getElementById('otpAlertMsg').textContent = 'Please enter all 6 digits.';
      otpAlertEl.className = 'auth-alert error'; otpAlertEl.style.display = 'flex'; return;
    }
    if (code === '123456') {
      bootstrap.Modal.getInstance(document.getElementById('otpModal')).hide();
      completeRegistration();
    } else {
      document.getElementById('otpAlertMsg').textContent = 'Invalid OTP. Demo code: 123456';
      otpAlertEl.className = 'auth-alert error'; otpAlertEl.style.display = 'flex';
      ['otp1','otp2','otp3','otp4','otp5','otp6'].forEach(id => {
        const el = document.getElementById(id);
        el.value = ''; el.style.borderColor = 'var(--danger)';
        setTimeout(() => el.style.borderColor = '', 1000);
      });
      document.getElementById('otp1').focus();
    }
  }
  function closeOtp() { bootstrap.Modal.getInstance(document.getElementById('otpModal')).hide(); }
  function resendOtp(e) {
    e.preventDefault();
    const otpAlertEl = document.getElementById('otpAlert');
    document.getElementById('otpAlertMsg').textContent = 'A new OTP has been sent to your email. (Demo: 123456)';
    otpAlertEl.className = 'auth-alert success'; otpAlertEl.style.display = 'flex';
    ['otp1','otp2','otp3','otp4','otp5','otp6'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('otp1').focus();
  }

  // Handle OTP modal paste
  document.addEventListener('paste', function(e) {
    const target = e.target;
    if (target.classList.contains('otp-digit')) {
      e.preventDefault();
      const text = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 6);
      const ids = ['otp1','otp2','otp3','otp4','otp5','otp6'];
      text.split('').forEach((ch, i) => { if (ids[i]) document.getElementById(ids[i]).value = ch; });
      checkOtpFilled();
    }
  });
</script>

</body>
</html>

