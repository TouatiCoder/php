<?php
// admin/_sidebar.php — shared admin sidebar include
// Usage: include __DIR__ . '/_sidebar.php';
// Requires $activePage to be set before include (e.g. 'dashboard', 'products', etc.)
$activePage = $activePage ?? '';
$adminUser = $_SESSION['admin_user'] ?? 'Admin';
$avatarLetter = strtoupper(substr($adminUser, 0, 1));
?>
<aside class="sidebar">
  <a href="dashboard.php" class="sidebar-logo" style="text-decoration:none">
    <div class="sidebar-logo-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
      </svg>
    </div>
    <div class="sidebar-logo-text">
      <strong>Admin Panel</strong>
      <span>Dashboard</span>
    </div>
  </a>

  <nav class="sidebar-nav">
    <div class="sidebar-section-label">Main</div>

    <a href="dashboard.php" class="nav-item <?php echo $activePage==='dashboard'?'active':''; ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
      </svg>
      Overview
    </a>

    <div class="sidebar-section-label">Catalog</div>

    <a href="products.php" class="nav-item <?php echo $activePage==='products'?'active':''; ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/>
      </svg>
      Products
    </a>

    <a href="categories.php" class="nav-item <?php echo $activePage==='categories'?'active':''; ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/>
      </svg>
      Categories
    </a>

    <div class="sidebar-section-label">Sales</div>

    <a href="orders.php" class="nav-item <?php echo $activePage==='orders'?'active':''; ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/><path d="M9 12h6M9 16h4"/>
      </svg>
      Orders
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="sidebar-user">
      <div class="user-avatar"><?php echo htmlspecialchars($avatarLetter); ?></div>
      <div class="user-info">
        <strong><?php echo htmlspecialchars($adminUser); ?></strong>
        <span>Administrator</span>
      </div>
    </div>
    <a href="logout.php" class="btn-logout">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
      </svg>
      Sign out
    </a>
  </div>
</aside>
