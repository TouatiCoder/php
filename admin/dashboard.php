<?php
// admin/dashboard.php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AdminController.php';
AdminController::requireAuth();
$pdo = getPDO();

$totals = $pdo->query('
  SELECT
    (SELECT COUNT(*) FROM products)   AS total_products,
    (SELECT COUNT(*) FROM categories) AS total_categories,
    (SELECT COUNT(*) FROM orders)     AS total_orders,
    (SELECT IFNULL(SUM(total),0) FROM orders) AS total_revenue,
    (SELECT COUNT(*) FROM orders WHERE status = "pending")    AS pending_orders,
    (SELECT COUNT(*) FROM orders WHERE status = "processing") AS processing_orders,
    (SELECT COUNT(*) FROM products WHERE available = 1)       AS available_products
')->fetch();

// Recent orders
$recentOrders = $pdo->query('
  SELECT id, user_name, user_email, total, status, created_at
  FROM orders ORDER BY id DESC LIMIT 7
')->fetchAll();

// Recent products
$recentProducts = $pdo->query('
  SELECT id, title_en, price, available, tag FROM products ORDER BY id DESC LIMIT 5
')->fetchAll();

$activePage = 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard — Admin Panel</title>
  <link rel="stylesheet" href="../css/admin-panel.css">
</head>
<body>
<div class="admin-layout">

  <?php include __DIR__ . '/_sidebar.php'; ?>

  <main class="admin-main">
    <!-- Top bar -->
    <header class="topbar">
      <div>
        <div class="topbar-title">Overview <span>/ Dashboard</span></div>
      </div>
      <div class="topbar-right">
        <div class="topbar-time" id="live-time"></div>
        <a href="product_add.php" class="btn btn-primary">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Add Product
        </a>
      </div>
    </header>

    <div class="page-content fade-in">

      <!-- Stat cards -->
      <div class="stats-grid">
        <div class="stat-card" style="--card-accent: linear-gradient(90deg, #155e4e, #2dd4bf)">
          <div class="stat-icon" style="background:rgba(45,212,191,0.12)">
            <svg style="color:#2dd4bf" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/>
            </svg>
          </div>
          <div class="stat-label">Total Products</div>
          <div class="stat-value"><?php echo (int)$totals['total_products']; ?></div>
          <div class="stat-sub"><?php echo (int)$totals['available_products']; ?> available</div>
        </div>

        <div class="stat-card" style="--card-accent: linear-gradient(90deg, #8b5cf6, #a78bfa)">
          <div class="stat-icon" style="background:rgba(139,92,246,0.12)">
            <svg style="color:#a78bfa" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/>
            </svg>
          </div>
          <div class="stat-label">Categories</div>
          <div class="stat-value"><?php echo (int)$totals['total_categories']; ?></div>
          <div class="stat-sub">Catalog sections</div>
        </div>

        <div class="stat-card" style="--card-accent: linear-gradient(90deg, #f59e0b, #fbbf24)">
          <div class="stat-icon" style="background:rgba(245,158,11,0.12)">
            <svg style="color:#fbbf24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/>
            </svg>
          </div>
          <div class="stat-label">Total Orders</div>
          <div class="stat-value"><?php echo (int)$totals['total_orders']; ?></div>
          <div class="stat-sub"><?php echo (int)$totals['pending_orders']; ?> pending · <?php echo (int)$totals['processing_orders']; ?> processing</div>
        </div>

        <div class="stat-card" style="--card-accent: linear-gradient(90deg, #10b981, #34d399)">
          <div class="stat-icon" style="background:rgba(16,185,129,0.12)">
            <svg style="color:#34d399" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
            </svg>
          </div>
          <div class="stat-label">Total Revenue</div>
          <div class="stat-value"><?php echo number_format((float)$totals['total_revenue'], 2); ?></div>
          <div class="stat-sub">All time</div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="section-header">
        <h2 class="section-title">Quick Actions</h2>
      </div>
      <div class="quick-grid" style="margin-bottom:28px">
        <a href="product_add.php" class="quick-card">
          <div class="quick-card-icon" style="background:rgba(45,212,191,0.12)">
            <svg style="color:#2dd4bf" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          </div>
          <span class="quick-card-label">Add Product</span>
          <span class="quick-card-sub">Create new listing</span>
        </a>
        <a href="category_add.php" class="quick-card">
          <div class="quick-card-icon" style="background:rgba(139,92,246,0.12)">
            <svg style="color:#a78bfa" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/><line x1="12" y1="11" x2="12" y2="17"/><line x1="9" y1="14" x2="15" y2="14"/></svg>
          </div>
          <span class="quick-card-label">Add Category</span>
          <span class="quick-card-sub">Organise catalog</span>
        </a>
        <a href="orders.php" class="quick-card">
          <div class="quick-card-icon" style="background:rgba(245,158,11,0.12)">
            <svg style="color:#fbbf24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/><path d="M9 12h6M9 16h4"/></svg>
          </div>
          <span class="quick-card-label">View Orders</span>
          <span class="quick-card-sub"><?php echo (int)$totals['pending_orders']; ?> pending</span>
        </a>
        <a href="products.php" class="quick-card">
          <div class="quick-card-icon" style="background:rgba(59,130,246,0.12)">
            <svg style="color:#60a5fa" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
          </div>
          <span class="quick-card-label">All Products</span>
          <span class="quick-card-sub"><?php echo (int)$totals['total_products']; ?> total</span>
        </a>
      </div>

      <!-- Two-column: Recent Orders + Recent Products -->
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

        <!-- Recent Orders -->
        <div>
          <div class="section-header">
            <h2 class="section-title">Recent Orders</h2>
            <a href="orders.php" class="btn btn-secondary btn-sm">View all</a>
          </div>
          <div class="panel">
            <?php if (empty($recentOrders)): ?>
              <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/></svg>
                <p>No orders yet</p>
              </div>
            <?php else: ?>
              <table class="data-table">
                <thead><tr>
                  <th>#</th><th>Customer</th><th>Total</th><th>Status</th><th></th>
                </tr></thead>
                <tbody>
                <?php foreach ($recentOrders as $o):
                  $statusClass = match($o['status']) {
                    'completed'  => 'badge-green',
                    'processing' => 'badge-blue',
                    'cancelled'  => 'badge-red',
                    default      => 'badge-yellow',
                  };
                ?>
                <tr>
                  <td class="text-primary">#<?php echo (int)$o['id']; ?></td>
                  <td><?php echo htmlspecialchars($o['user_name']); ?></td>
                  <td class="text-primary"><?php echo number_format((float)$o['total'], 2); ?></td>
                  <td><span class="badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($o['status']); ?></span></td>
                  <td><a href="order_view.php?id=<?php echo (int)$o['id']; ?>" class="btn btn-secondary btn-sm">View</a></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            <?php endif; ?>
          </div>
        </div>

        <!-- Recent Products -->
        <div>
          <div class="section-header">
            <h2 class="section-title">Recent Products</h2>
            <a href="products.php" class="btn btn-secondary btn-sm">View all</a>
          </div>
          <div class="panel">
            <?php if (empty($recentProducts)): ?>
              <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/></svg>
                <p>No products yet</p>
              </div>
            <?php else: ?>
              <table class="data-table">
                <thead><tr>
                  <th>Product</th><th>Price</th><th>Status</th><th></th>
                </tr></thead>
                <tbody>
                <?php foreach ($recentProducts as $p): ?>
                <tr>
                  <td>
                    <div class="text-primary" style="font-weight:600;font-size:0.83rem"><?php echo htmlspecialchars($p['title_en']); ?></div>
                    <?php if ($p['tag']): ?><div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px"><?php echo htmlspecialchars($p['tag']); ?></div><?php endif; ?>
                  </td>
                  <td class="text-primary"><?php echo number_format((float)$p['price'], 2); ?></td>
                  <td>
                    <span class="badge <?php echo $p['available'] ? 'badge-green' : 'badge-gray'; ?>">
                      <?php echo $p['available'] ? 'Active' : 'Hidden'; ?>
                    </span>
                  </td>
                  <td><a href="product_edit.php?id=<?php echo (int)$p['id']; ?>" class="btn btn-secondary btn-sm">Edit</a></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            <?php endif; ?>
          </div>
        </div>

      </div><!-- /two-col -->

    </div><!-- /page-content -->
  </main>
</div>

<script>
  function updateTime() {
    const el = document.getElementById('live-time');
    if (el) {
      el.textContent = new Date().toLocaleTimeString('en-GB', {hour:'2-digit', minute:'2-digit', second:'2-digit'});
    }
  }
  updateTime();
  setInterval(updateTime, 1000);
</script>
</body>
</html>
