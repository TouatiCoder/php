<?php
// admin/login.php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AdminController.php';

$error = null;
$pdo = getPDO();
$hasAdmin = (bool)$pdo->query('SELECT 1 FROM admins LIMIT 1')->fetchColumn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!$hasAdmin && isset($_POST['setup']) && $_POST['setup']==='1') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '' || $password === '') {
      $error = 'Username and password required';
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $pdo->prepare('INSERT INTO admins (username, password_hash) VALUES (:username, :hash)');
      $stmt->execute([':username'=>$username, ':hash'=>$hash]);
      header('Location: login.php'); exit;
    }
  } else {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if (AdminController::attemptLogin($pdo, $username, $password)) {
      header('Location: dashboard.php');
      exit;
    } else {
      $error = 'Invalid credentials. Please try again.';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $hasAdmin ? 'Admin Login' : 'Admin Setup'; ?> — Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --brand-deep:   #071a16;
      --brand-dark:   #0C342C;
      --brand-mid:    #155e4e;
      --brand-light:  #1e8a6e;
      --brand-accent: #2dd4bf;
      --brand-glow:   rgba(45,212,191,0.18);
      --text-primary: #f0fdf9;
      --text-muted:   #94a3a8;
      --error-color:  #f87171;
      --error-bg:     rgba(248,113,113,0.1);
      --card-bg:      rgba(12,52,44,0.45);
      --card-border:  rgba(45,212,191,0.15);
      --input-bg:     rgba(7,26,22,0.7);
      --input-border: rgba(45,212,191,0.2);
      --input-focus:  rgba(45,212,191,0.6);
    }

    html, body {
      height: 100%;
      font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
    }

    body {
      background: var(--brand-deep);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      overflow: hidden;
      position: relative;
    }

    /* ── animated gradient bg ── */
    .bg-canvas {
      position: fixed;
      inset: 0;
      z-index: 0;
      background:
        radial-gradient(ellipse 80% 60% at 10% 20%, rgba(21,94,78,0.45) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 90% 80%, rgba(45,212,191,0.12) 0%, transparent 55%),
        radial-gradient(ellipse 50% 40% at 50% 110%, rgba(12,52,44,0.6) 0%, transparent 60%);
      animation: bgShift 12s ease-in-out infinite alternate;
    }

    @keyframes bgShift {
      0%   { opacity: 0.85; }
      100% { opacity: 1; }
    }

    /* ── floating orbs ── */
    .orb {
      position: fixed;
      border-radius: 50%;
      filter: blur(80px);
      opacity: 0.25;
      animation: orbFloat 18s ease-in-out infinite alternate;
      pointer-events: none;
      z-index: 0;
    }
    .orb-1 { width: 420px; height: 420px; background: var(--brand-mid); top: -120px; left: -80px; animation-delay: 0s; }
    .orb-2 { width: 320px; height: 320px; background: var(--brand-accent); bottom: -80px; right: -60px; opacity: 0.15; animation-delay: -6s; }
    .orb-3 { width: 200px; height: 200px; background: var(--brand-light); top: 50%; right: 10%; opacity: 0.12; animation-delay: -3s; animation-duration: 22s; }

    @keyframes orbFloat {
      0%   { transform: translate(0, 0) scale(1); }
      50%  { transform: translate(30px, -20px) scale(1.05); }
      100% { transform: translate(-20px, 30px) scale(0.95); }
    }

    /* ── grid overlay ── */
    .grid-overlay {
      position: fixed;
      inset: 0;
      z-index: 0;
      background-image:
        linear-gradient(rgba(45,212,191,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(45,212,191,0.04) 1px, transparent 1px);
      background-size: 48px 48px;
    }

    /* ── card ── */
    .login-wrapper {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 440px;
      padding: 16px;
      animation: cardEntry 0.7s cubic-bezier(0.16,1,0.3,1) both;
    }

    @keyframes cardEntry {
      from { opacity: 0; transform: translateY(28px) scale(0.97); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .login-card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 24px;
      padding: 44px 40px 40px;
      backdrop-filter: blur(24px) saturate(160%);
      -webkit-backdrop-filter: blur(24px) saturate(160%);
      box-shadow:
        0 0 0 1px rgba(255,255,255,0.04) inset,
        0 32px 64px rgba(0,0,0,0.5),
        0 0 80px rgba(45,212,191,0.06);
    }

    /* ── logo / header ── */
    .login-logo {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 32px;
    }

    .login-logo-icon {
      width: 46px;
      height: 46px;
      background: linear-gradient(135deg, var(--brand-mid) 0%, var(--brand-accent) 100%);
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 8px 20px rgba(45,212,191,0.25);
      flex-shrink: 0;
    }

    .login-logo-icon svg {
      width: 24px;
      height: 24px;
      color: white;
    }

    .login-logo-text h1 {
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--text-primary);
      letter-spacing: -0.02em;
      line-height: 1.2;
    }

    .login-logo-text span {
      font-size: 0.75rem;
      color: var(--text-muted);
      font-weight: 500;
      letter-spacing: 0.04em;
      text-transform: uppercase;
    }

    .login-heading {
      font-size: 1.75rem;
      font-weight: 700;
      color: var(--text-primary);
      letter-spacing: -0.03em;
      margin-bottom: 6px;
      line-height: 1.2;
    }

    .login-subheading {
      font-size: 0.9rem;
      color: var(--text-muted);
      margin-bottom: 32px;
      font-weight: 400;
    }

    /* ── divider ── */
    .login-divider {
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(45,212,191,0.25), transparent);
      margin-bottom: 32px;
    }

    /* ── error alert ── */
    .alert-error {
      display: flex;
      align-items: center;
      gap: 10px;
      background: var(--error-bg);
      border: 1px solid rgba(248,113,113,0.25);
      border-radius: 12px;
      padding: 12px 16px;
      margin-bottom: 24px;
      animation: shake 0.4s cubic-bezier(0.36,0.07,0.19,0.97) both;
    }

    @keyframes shake {
      10%, 90% { transform: translateX(-2px); }
      20%, 80% { transform: translateX(3px); }
      30%, 50%, 70% { transform: translateX(-3px); }
      40%, 60% { transform: translateX(3px); }
    }

    .alert-error svg { width: 18px; height: 18px; color: var(--error-color); flex-shrink: 0; }
    .alert-error span { font-size: 0.875rem; color: var(--error-color); font-weight: 500; }

    /* ── form fields ── */
    .field-group {
      margin-bottom: 20px;
    }

    .field-label {
      display: block;
      font-size: 0.82rem;
      font-weight: 600;
      color: var(--text-muted);
      margin-bottom: 8px;
      letter-spacing: 0.04em;
      text-transform: uppercase;
    }

    .field-wrap {
      position: relative;
    }

    .field-icon {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      width: 18px;
      height: 18px;
      color: var(--text-muted);
      pointer-events: none;
      transition: color 0.2s;
    }

    .field-wrap:focus-within .field-icon {
      color: var(--brand-accent);
    }

    .field-wrap input {
      width: 100%;
      background: var(--input-bg);
      border: 1px solid var(--input-border);
      border-radius: 12px;
      padding: 14px 48px 14px 46px;
      color: var(--text-primary);
      font-family: inherit;
      font-size: 0.95rem;
      font-weight: 500;
      outline: none;
      transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
    }

    .field-wrap input::placeholder { color: rgba(148,163,168,0.5); }

    .field-wrap input:focus {
      border-color: var(--input-focus);
      background: rgba(7,26,22,0.9);
      box-shadow: 0 0 0 3px rgba(45,212,191,0.1), 0 4px 16px rgba(0,0,0,0.2);
    }

    .field-wrap input:-webkit-autofill,
    .field-wrap input:-webkit-autofill:focus {
      -webkit-box-shadow: 0 0 0 1000px rgba(7,26,22,0.9) inset;
      -webkit-text-fill-color: var(--text-primary);
      caret-color: var(--text-primary);
    }

    /* eye toggle */
    .eye-toggle {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      color: var(--text-muted);
      padding: 4px;
      border-radius: 6px;
      transition: color 0.2s;
      display: flex;
      align-items: center;
    }
    .eye-toggle:hover { color: var(--brand-accent); }
    .eye-toggle svg { width: 18px; height: 18px; }

    /* ── submit button ── */
    .btn-submit {
      width: 100%;
      margin-top: 8px;
      padding: 15px 24px;
      background: linear-gradient(135deg, var(--brand-mid) 0%, var(--brand-light) 100%);
      border: none;
      border-radius: 12px;
      color: #fff;
      font-family: inherit;
      font-size: 1rem;
      font-weight: 700;
      letter-spacing: 0.01em;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition: transform 0.18s cubic-bezier(0.22,1,0.36,1), box-shadow 0.18s;
      box-shadow: 0 8px 24px rgba(21,94,78,0.4);
    }

    .btn-submit::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 60%);
      opacity: 0;
      transition: opacity 0.2s;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 32px rgba(21,94,78,0.55);
    }

    .btn-submit:hover::before { opacity: 1; }

    .btn-submit:active {
      transform: translateY(0) scale(0.98);
      box-shadow: 0 4px 12px rgba(21,94,78,0.35);
    }

    .btn-inner {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .btn-inner svg { width: 18px; height: 18px; }

    /* ── footer ── */
    .login-footer {
      margin-top: 28px;
      text-align: center;
      font-size: 0.78rem;
      color: rgba(148,163,168,0.5);
      letter-spacing: 0.03em;
    }

    .login-footer strong {
      color: rgba(45,212,191,0.6);
      font-weight: 600;
    }

    /* ── setup badge ── */
    .setup-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(45,212,191,0.1);
      border: 1px solid rgba(45,212,191,0.2);
      color: var(--brand-accent);
      border-radius: 100px;
      padding: 4px 12px;
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      margin-bottom: 12px;
    }

    .setup-badge svg { width: 12px; height: 12px; }

    @media (max-width: 480px) {
      .login-card { padding: 32px 24px 28px; border-radius: 20px; }
      .login-heading { font-size: 1.5rem; }
    }
  </style>
</head>
<body>
  <div class="bg-canvas"></div>
  <div class="grid-overlay"></div>
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>
  <div class="orb orb-3"></div>

  <div class="login-wrapper">
    <div class="login-card">

      <!-- Logo -->
      <div class="login-logo">
        <div class="login-logo-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
            <path d="M2 17l10 5 10-5"/>
            <path d="M2 12l10 5 10-5"/>
          </svg>
        </div>
        <div class="login-logo-text">
          <h1>Admin Panel</h1>
          <span>Secure Access</span>
        </div>
      </div>

      <div class="login-divider"></div>

      <?php if (!$hasAdmin): ?>
        <div class="setup-badge">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          First-time Setup
        </div>
      <?php endif; ?>

      <h2 class="login-heading">
        <?php echo $hasAdmin ? 'Welcome back' : 'Create Admin Account'; ?>
      </h2>
      <p class="login-subheading">
        <?php echo $hasAdmin ? 'Sign in to your admin dashboard' : 'Set up your administrator credentials'; ?>
      </p>

      <?php if ($error): ?>
        <div class="alert-error" role="alert">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          <span><?php echo htmlspecialchars($error); ?></span>
        </div>
      <?php endif; ?>

      <form method="post" novalidate>
        <?php if (!$hasAdmin): ?>
          <input type="hidden" name="setup" value="1">
        <?php endif; ?>

        <!-- Username -->
        <div class="field-group">
          <label class="field-label" for="username">Username</label>
          <div class="field-wrap">
            <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
            <input
              id="username"
              name="username"
              type="text"
              placeholder="Enter your username"
              autocomplete="username"
              required
              value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
            >
          </div>
        </div>

        <!-- Password -->
        <div class="field-group">
          <label class="field-label" for="password">Password</label>
          <div class="field-wrap">
            <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            <input
              id="password"
              name="password"
              type="password"
              placeholder="Enter your password"
              autocomplete="current-password"
              required
            >
            <button type="button" class="eye-toggle" onclick="togglePassword()" id="eye-btn" aria-label="Toggle password visibility">
              <svg id="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-submit" id="login-btn">
          <div class="btn-inner">
            <?php if ($hasAdmin): ?>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
              </svg>
              Sign In to Dashboard
            <?php else: ?>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
              </svg>
              Create Admin Account
            <?php endif; ?>
          </div>
        </button>
      </form>

      <div class="login-footer">
        Protected by <strong>AdminController</strong> · Session secured
      </div>
    </div>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById('password');
      const icon  = document.getElementById('eye-icon');
      const isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';
      icon.innerHTML = isHidden
        ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>'
        : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }

    // Button loading state on submit
    document.querySelector('form').addEventListener('submit', function() {
      const btn = document.getElementById('login-btn');
      btn.disabled = true;
      btn.querySelector('.btn-inner').innerHTML = `
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" style="animation:spin .7s linear infinite">
          <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
        </svg>
        Authenticating…
      `;
      const style = document.createElement('style');
      style.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
      document.head.appendChild(style);
    });
  </script>
</body>
</html>
