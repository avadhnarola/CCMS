<?php 
include '../connection.php';


?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="CCMS Citizen Login â€” Securely access your corruption complaint dashboard with zero-knowledge authentication." />
  <title>Citizen Login | CCMS â€” Corruption Complaint Management System</title>
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
      --heading: #0f172a;
      --body: #334155;
      --muted: #64748b;
      --grad-brand: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
      --grad-panel: linear-gradient(145deg, #1e3a8a 0%, #312e81 40%, #4c1d95 100%);
      --radius: 20px;
      --shadow-card: 0 25px 60px -15px rgba(15,23,42,0.12), 0 8px 20px -8px rgba(15,23,42,0.06);
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
      --heading: #f8fafc;
      --body: #cbd5e1;
      --muted: #94a3b8;
      --grad-brand: linear-gradient(135deg, #00d4ff 0%, #8b5cf6 100%);
      --grad-panel: linear-gradient(145deg, #0a1628 0%, #0d1b3e 40%, #130f2e 100%);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      color: var(--body);
      min-height: 100vh;
      display: flex;
      overflow-x: hidden;
      transition: background 0.3s ease, color 0.3s ease;
    }
    a { text-decoration: none; color: inherit; }
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: var(--bg); }
    ::-webkit-scrollbar-thumb { background: var(--border-hover); border-radius: 99px; }

    .auth-page { display: flex; width: 100%; min-height: 100vh; }

    /* LEFT BRAND PANEL */
    .brand-panel {
      width: 45%;
      background: var(--grad-panel);
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
      padding: 60px 56px;
    }
    .brand-panel::before {
      content: '';
      position: absolute;
      inset: 0;
      background:
        radial-gradient(circle at 20% 20%, rgba(56,189,248,0.15) 0%, transparent 55%),
        radial-gradient(circle at 80% 80%, rgba(167,139,250,0.18) 0%, transparent 50%);
    }
    .brand-panel::after {
      content: '';
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
      background-size: 40px 40px;
    }
    .brand-panel-content { position: relative; z-index: 2; }

    .brand-wordmark {
      font-family: 'Orbitron', sans-serif;
      font-size: 3rem;
      font-weight: 900;
      color: #fff;
      letter-spacing: 2px;
      line-height: 1;
      margin-bottom: 6px;
      display: inline-block;
      text-decoration: none;
    }
    .brand-wordmark span {
      display: block;
      font-family: 'Inter', sans-serif;
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: rgba(255,255,255,0.55);
      margin-top: 8px;
    }
    .brand-divider {
      width: 52px; height: 3px;
      background: linear-gradient(90deg, #38bdf8, #a78bfa);
      border-radius: 99px;
      margin: 28px 0;
    }
    .brand-headline {
      font-size: 1.85rem; font-weight: 800;
      color: #fff; line-height: 1.3;
      margin-bottom: 20px; letter-spacing: -0.5px;
    }
    .brand-desc {
      font-size: 0.95rem; color: rgba(255,255,255,0.6);
      line-height: 1.8; max-width: 380px; margin-bottom: 40px;
    }
    .trust-badges { display: flex; flex-direction: column; gap: 14px; }
    .trust-badge-item { display: flex; align-items: center; gap: 14px; }
    .trust-icon-box {
      width: 40px; height: 40px; border-radius: 10px;
      background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);
      display: flex; align-items: center; justify-content: center;
      font-size: 1rem; color: #38bdf8; flex-shrink: 0;
    }
    .trust-badge-text strong { display: block; font-size: 0.88rem; font-weight: 700; color: #fff; }
    .trust-badge-text span { font-size: 0.77rem; color: rgba(255,255,255,0.5); }

    .orb {
      position: absolute; border-radius: 50%;
      filter: blur(60px); pointer-events: none; z-index: 1;
    }
    .orb-1 {
      width: 300px; height: 300px;
      background: rgba(37,99,235,0.25);
      top: -80px; right: -80px;
      animation: drift 8s ease-in-out infinite;
    }
    .orb-2 {
      width: 220px; height: 220px;
      background: rgba(124,58,237,0.2);
      bottom: -60px; left: -60px;
      animation: drift 10s ease-in-out infinite reverse;
    }
    @keyframes drift {
      0%, 100% { transform: translate(0, 0); }
      50% { transform: translate(20px, -20px); }
    }

    /* RIGHT FORM PANEL */
    .form-panel {
      flex: 1;
      display: flex; flex-direction: column;
      justify-content: center; align-items: center;
      padding: 48px 40px;
      background: var(--bg);
      position: relative;
      transition: background 0.3s ease;
    }
    .panel-controls {
      position: absolute; top: 20px; right: 24px;
      display: flex; align-items: center; gap: 12px;
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
      justify-content: center; cursor: pointer; font-size: 0.9rem;
      transition: var(--transition);
    }
    .theme-btn:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-light); }

    .auth-card { width: 100%; max-width: 440px; }
    .auth-header { margin-bottom: 32px; }
    .auth-tag {
      display: inline-flex; align-items: center; gap: 8px;
      font-size: 0.75rem; font-weight: 800; letter-spacing: 2px;
      text-transform: uppercase; color: var(--primary);
      background: var(--primary-light); border: 1px solid rgba(37,99,235,0.2);
      padding: 5px 14px; border-radius: 50px; margin-bottom: 18px;
    }
    [data-theme="dark"] .auth-tag { border-color: rgba(56,189,248,0.25); }
    .auth-tag .dot {
      width: 7px; height: 7px; border-radius: 50%;
      background: var(--success); box-shadow: 0 0 8px var(--success);
      animation: ping 1.6s ease-in-out infinite;
    }
    @keyframes ping {
      0%,100% { transform: scale(1); opacity: 1; }
      50% { transform: scale(1.5); opacity: 0.5; }
    }
    .auth-title {
      font-size: 2rem; font-weight: 900; color: var(--heading);
      letter-spacing: -0.5px; line-height: 1.2; margin-bottom: 8px;
    }
    .auth-subtitle { font-size: 0.92rem; color: var(--muted); line-height: 1.6; }

    .form-group { margin-bottom: 20px; }
    .form-label-row {
      display: flex; justify-content: space-between;
      align-items: center; margin-bottom: 8px;
    }
    .field-label { font-size: 0.83rem; font-weight: 700; color: var(--heading); }
    .field-link { font-size: 0.8rem; font-weight: 600; color: var(--primary); transition: opacity 0.2s; }
    .field-link:hover { opacity: 0.75; }

    .input-wrapper { position: relative; }
    .input-icon {
      position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
      color: var(--muted); font-size: 0.95rem; pointer-events: none;
      transition: color 0.25s; z-index: 2;
    }
    .input-wrapper:focus-within .input-icon { color: var(--primary); }
    .form-field {
      width: 100%; padding: 14px 16px 14px 44px;
      font-family: 'Inter', sans-serif; font-size: 0.93rem;
      color: var(--heading); background: var(--surface);
      border: 1.5px solid var(--border); border-radius: 12px;
      outline: none; transition: border-color 0.25s ease, box-shadow 0.25s ease;
    }
    .form-field::placeholder { color: var(--muted); }
    .form-field:focus { border-color: var(--primary); box-shadow: 0 0 0 4px var(--primary-light); }
    .form-field.is-invalid { border-color: var(--danger); box-shadow: 0 0 0 4px rgba(225,29,72,0.08); }
    .form-field.is-valid { border-color: var(--success); box-shadow: 0 0 0 4px rgba(5,150,105,0.08); }

    .pw-toggle {
      position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
      background: none; border: none; padding: 4px; cursor: pointer;
      color: var(--muted); font-size: 0.95rem; z-index: 2; transition: color 0.2s;
    }
    .pw-toggle:hover { color: var(--primary); }
    .has-toggle .form-field { padding-right: 46px; }

    .check-row {
      display: flex; align-items: center; gap: 10px; margin-bottom: 24px;
    }
    .custom-check {
      width: 18px; height: 18px; border: 2px solid var(--border-hover);
      border-radius: 5px; cursor: pointer; accent-color: var(--primary); flex-shrink: 0;
    }
    .check-label { font-size: 0.83rem; color: var(--muted); cursor: pointer; }

    .btn-submit {
      width: 100%; padding: 15px;
      background: var(--grad-brand); color: #fff;
      font-family: 'Inter', sans-serif; font-size: 0.97rem; font-weight: 700;
      border: none; border-radius: 12px; cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 10px;
      box-shadow: 0 8px 25px rgba(37,99,235,0.3);
      transition: var(--transition); position: relative; overflow: hidden;
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
      width: 18px; height: 18px;
      border: 2.5px solid rgba(255,255,255,0.4);
      border-top-color: #fff; border-radius: 50%;
      animation: spin 0.7s linear infinite; display: none;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .btn-submit.loading .btn-text { display: none; }
    .btn-submit.loading .spinner-inner { display: block; }

    .auth-divider {
      display: flex; align-items: center; gap: 14px; margin: 24px 0;
    }
    .auth-divider::before, .auth-divider::after {
      content: ''; flex: 1; height: 1px; background: var(--border);
    }
    .auth-divider span { font-size: 0.78rem; font-weight: 600; color: var(--muted); white-space: nowrap; }

    .social-row { display: flex; gap: 12px; margin-bottom: 24px; }
    .btn-social {
      flex: 1; padding: 11px 10px;
      background: var(--surface); border: 1.5px solid var(--border);
      border-radius: 10px; color: var(--heading);
      font-size: 0.85rem; font-weight: 600;
      display: flex; align-items: center; justify-content: center; gap: 8px;
      cursor: pointer; transition: var(--transition); font-family: 'Inter', sans-serif;
    }
    .btn-social:hover {
      border-color: var(--primary); color: var(--primary);
      background: var(--primary-light); transform: translateY(-1px);
    }

    .auth-footer { text-align: center; font-size: 0.85rem; color: var(--muted); }
    .auth-footer a { color: var(--primary); font-weight: 700; transition: opacity 0.2s; }
    .auth-footer a:hover { opacity: 0.75; }

    .auth-alert {
      padding: 12px 16px; border-radius: 10px;
      font-size: 0.85rem; font-weight: 600; margin-bottom: 18px;
      display: none; align-items: center; gap: 10px;
    }
    .auth-alert.error { background: rgba(225,29,72,0.08); border: 1px solid rgba(225,29,72,0.2); color: var(--danger); }
    .auth-alert.success { background: rgba(5,150,105,0.08); border: 1px solid rgba(5,150,105,0.2); color: var(--success); }

    .modal-glass {
      background: var(--surface); border: 1px solid var(--border);
      border-radius: var(--radius); box-shadow: 0 30px 80px rgba(15,23,42,0.2);
    }
    .modal-glass .modal-header { border-bottom: 1px solid var(--border); }

    @media (max-width: 900px) { .brand-panel { display: none; } .form-panel { padding: 40px 24px; } }
    @media (max-width: 480px) { .auth-title { font-size: 1.6rem; } .social-row { flex-direction: column; } }
  </style>
</head>
<body>

<div class="auth-page">

  <!-- LEFT BRAND PANEL -->
  <div class="brand-panel">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="brand-panel-content">
      <a href="../index.php" class="brand-wordmark">
        CCMS
        <span>Corruption Complaint Management System</span>
      </a>
      <div class="brand-divider"></div>
      <h2 class="brand-headline">Fight Corruption.<br />Stay Anonymous.<br />Demand Justice.</h2>
      <p class="brand-desc">
        CCMS provides a zero-knowledge, end-to-end encrypted, and anonymous portal for citizens and whistleblowers to report corruption and track investigations in real time.
      </p>
      <div class="trust-badges">
        <div class="trust-badge-item">
          <div class="trust-icon-box"><i class="fas fa-lock"></i></div>
          <div class="trust-badge-text">
            <strong>AES-256 Military Encryption</strong>
            <span>All data encrypted client-side before transmission</span>
          </div>
        </div>
        <div class="trust-badge-item">
          <div class="trust-icon-box"><i class="fas fa-user-secret"></i></div>
          <div class="trust-badge-text">
            <strong>Zero-Knowledge Architecture</strong>
            <span>No IP address or device metadata logged</span>
          </div>
        </div>
        <div class="trust-badge-item">
          <div class="trust-icon-box"><i class="fas fa-gavel"></i></div>
          <div class="trust-badge-text">
            <strong>Legal Protection Guaranteed</strong>
            <span>Whistleblower Protection Act coverage applied</span>
          </div>
        </div>
        <div class="trust-badge-item">
          <div class="trust-icon-box"><i class="fas fa-shield-halved"></i></div>
          <div class="trust-badge-text">
            <strong>15,420+ Complaints Processed</strong>
            <span>95% resolution rate â€” Trusted nationwide</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- RIGHT FORM PANEL -->
  <div class="form-panel">
    <div class="panel-controls">
      <a href="../index.php" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Home
      </a>
      <button class="theme-btn" id="themeBtn" onclick="toggleTheme()" title="Toggle Theme">
        <i class="fas fa-moon" id="themeIcon"></i>
      </button>
    </div>

    <div class="auth-card">
      <div class="auth-header">
        <div class="auth-tag"><span class="dot"></span>Secure Portal</div>
        <h1 class="auth-title">Welcome Back,<br />Citizen</h1>
        <p class="auth-subtitle">Sign in to your secure whistleblower account to track complaints and manage your profile.</p>
      </div>

      <div class="auth-alert" id="loginAlert">
        <i class="fas fa-circle-exclamation"></i>
        <span id="alertMessage"></span>
      </div>

      <!-- Social Login -->
      <div class="social-row">
        <button class="btn-social" onclick="socialLogin('Google')" id="googleBtn">
          <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
          Continue with Google
        </button>
        <button class="btn-social" onclick="socialLogin('Aadhaar')" id="aadhaarBtn">
          <i class="fas fa-id-card" style="color:#FF671F;"></i>
          Aadhaar Login
        </button>
      </div>

      <div class="auth-divider"><span>or sign in with email</span></div>

      <form id="loginForm" onsubmit="handleLogin(event)" novalidate>
        <!-- Email -->
        <div class="form-group">
          <label class="field-label" for="loginEmail">Email Address</label>
          <div class="input-wrapper">
            <i class="fas fa-envelope input-icon"></i>
            <input type="email" class="form-field" id="loginEmail" placeholder="name@domain.com" autocomplete="email" required />
          </div>
        </div>

        <!-- Password -->
        <div class="form-group">
          <div class="form-label-row">
            <label class="field-label" for="loginPassword">Password</label>
            <a href="#" class="field-link" data-bs-toggle="modal" data-bs-target="#forgotModal">Forgot password?</a>
          </div>
          <div class="input-wrapper has-toggle">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" class="form-field" id="loginPassword" placeholder="Enter your password" autocomplete="current-password" required />
            <button type="button" class="pw-toggle" id="pwToggle" onclick="togglePw()">
              <i class="fas fa-eye" id="pwIcon"></i>
            </button>
          </div>
        </div>

        <div class="check-row">
          <input type="checkbox" class="custom-check" id="rememberMe" checked />
          <label class="check-label" for="rememberMe">Remember me on this device for 30 days</label>
        </div>

        <button type="submit" class="btn-submit" id="loginBtn">
          <div class="spinner-inner"></div>
          <span class="btn-text">
            <i class="fas fa-arrow-right-to-bracket"></i>
            Sign In to Dashboard
          </span>
        </button>
      </form>

      <div class="auth-divider" style="margin-top:24px;"><span>New to CCMS?</span></div>
      <div class="auth-footer">
        Don't have an account? <a href="register.php">Create Citizen Account <i class="fas fa-arrow-right" style="font-size:0.78rem;"></i></a>
      </div>

      <div style="display:flex;align-items:center;gap:8px;margin-top:20px;padding:12px 14px;background:var(--subtle);border:1px solid var(--border);border-radius:10px;">
        <i class="fas fa-shield-halved" style="color:var(--success);font-size:0.9rem;"></i>
        <span style="font-size:0.77rem;color:var(--muted);line-height:1.4;">Your identity is protected by zero-knowledge cryptography. We never store your personal data unencrypted.</span>
      </div>
    </div>
  </div>
</div>


<!-- FORGOT PASSWORD MODAL -->
<div class="modal fade" id="forgotModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-glass">
      <div class="modal-header border-0 pb-0">
        <div>
          <h5 class="fw-bold mb-0" style="color:var(--heading);">
            <i class="fas fa-key me-2" style="color:var(--primary);"></i>Reset Password
          </h5>
          <p class="text-muted small mb-0 mt-1">We'll send a secure reset link to your email</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body pt-3">
        <div class="form-group mb-0">
          <label class="field-label d-block mb-2">Registered Email Address</label>
          <div class="input-wrapper">
            <i class="fas fa-envelope input-icon"></i>
            <input type="email" class="form-field" id="resetEmail" placeholder="name@domain.com" />
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn w-100 fw-bold rounded-pill" onclick="sendResetLink()" style="background:var(--grad-brand);color:#fff;border:none;padding:12px;font-family:'Inter',sans-serif;">
          <i class="fas fa-paper-plane me-2"></i>Send Reset Link
        </button>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // THEME
  const html = document.documentElement;
  const themeIcon = document.getElementById('themeIcon');
  function applyTheme(t) {
    html.setAttribute('data-theme', t);
    themeIcon.className = t === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    localStorage.setItem('ccms_theme', t);
  }
  function toggleTheme() { applyTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark'); }
  applyTheme(localStorage.getItem('ccms_theme') || 'light');

  // PASSWORD TOGGLE
  function togglePw() {
    const pw = document.getElementById('loginPassword');
    const icon = document.getElementById('pwIcon');
    if (pw.type === 'password') { pw.type = 'text'; icon.className = 'fas fa-eye-slash'; }
    else { pw.type = 'password'; icon.className = 'fas fa-eye'; }
  }

  // REAL-TIME VALIDATION
  document.getElementById('loginEmail').addEventListener('input', function() {
    const valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value);
    this.className = 'form-field ' + (this.value ? (valid ? 'is-valid' : 'is-invalid') : '');
  });
  document.getElementById('loginPassword').addEventListener('input', function() {
    this.className = 'form-field ' + (this.value.length >= 6 ? 'is-valid' : this.value ? 'is-invalid' : '');
  });

  // LOGIN HANDLER
  function handleLogin(e) {
    e.preventDefault();
    const email = document.getElementById('loginEmail').value.trim();
    const password = document.getElementById('loginPassword').value;
    const btn = document.getElementById('loginBtn');
    document.getElementById('loginAlert').style.display = 'none';

    if (!email || !password) { showAlert('Please fill in all fields.'); return; }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showAlert('Please enter a valid email address.'); return; }
    if (password.length < 6) { showAlert('Password must be at least 6 characters.'); return; }

    btn.classList.add('loading'); btn.disabled = true;

    setTimeout(() => {
      const stored = localStorage.getItem('ccms_user');
      const user = stored ? JSON.parse(stored) : null;

      if (user && user.email === email) {
        localStorage.setItem('ccms_loggedIn', 'true');
        btn.classList.remove('loading');
        showSuccess('Login successful! Redirecting to your dashboard...');
        setTimeout(() => { window.location.href = 'index.php'; }, 1200);
      } else if (email === 'citizen@ccms.gov.in' && password === 'ccms@123') {
        const demoUser = { name: 'Rajesh Kumar', email, phone: '+91 98765 43210', nationalId: 'IND-2026-0001', address: '24, Nehru Nagar, New Delhi 110001', joinedDate: 'January 2025', avatarText: 'RK' };
        localStorage.setItem('ccms_user', JSON.stringify(demoUser));
        localStorage.setItem('ccms_loggedIn', 'true');
        btn.classList.remove('loading');
        showSuccess('Login successful! Redirecting...');
        setTimeout(() => { window.location.href = 'index.php'; }, 1200);
      } else {
        btn.classList.remove('loading'); btn.disabled = false;
        showAlert('Invalid credentials. Demo: citizen@ccms.gov.in / ccms@123');
      }
    }, 1400);
  }

  function showAlert(msg) {
    const el = document.getElementById('loginAlert');
    document.getElementById('alertMessage').textContent = msg;
    el.className = 'auth-alert error'; el.style.display = 'flex';
    el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }
  function showSuccess(msg) {
    const el = document.getElementById('loginAlert');
    document.getElementById('alertMessage').textContent = msg;
    el.className = 'auth-alert success'; el.style.display = 'flex';
  }

  function sendResetLink() {
    const email = document.getElementById('resetEmail').value.trim();
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { alert('Please enter a valid email address.'); return; }
    bootstrap.Modal.getInstance(document.getElementById('forgotModal')).hide();
    showSuccess('Password reset link sent to ' + email + '. Please check your inbox.');
  }

  function socialLogin(provider) {
    const btn = document.getElementById('loginBtn'); btn.classList.add('loading'); btn.disabled = true;
    setTimeout(() => {
      btn.classList.remove('loading'); btn.disabled = false;
      showAlert(provider + ' sign-in is not available in the demo environment.');
    }, 1200);
  }
</script>
</body>
</html>

