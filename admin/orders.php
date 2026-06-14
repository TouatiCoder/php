<?php
// admin/orders.php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AdminController.php';
AdminController::requireAuth();
$pdo = getPDO();
$stmt = $pdo->query('SELECT id, user_name, user_email, total, status, created_at FROM orders ORDER BY id DESC');
$orders = $stmt->fetchAll();
$activePage = 'orders';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Orders — Admin Panel</title>
  <link rel="stylesheet" href="../css/admin-panel.css">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/_sidebar.php'; ?>
  <main class="admin-main">
    <header class="topbar">
      <div class="topbar-title">Sales <span>/ Orders</span></div>
    </header>

    <div class="page-content fade-in">
      <div class="section-header" style="margin-bottom:16px">
        <h1 class="section-title" style="font-size:1.3rem">All Orders <span style="color:var(--text-muted);font-weight:400;font-size:0.9rem">(<?php echo count($orders); ?>)</span></h1>
      </div>

      <div class="panel">
        <?php if (empty($orders)): ?>
          <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/></svg>
            <p>No orders yet.</p>
          </div>
        <?php else: ?>
          <table class="data-table">
            <thead>
              <tr>
                <th>Order</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $o):
              $statusClass = match($o['status']) {
                'completed'  => 'badge-green',
                'processing' => 'badge-blue',
                'cancelled'  => 'badge-red',
                default      => 'badge-yellow',
              };
              $date = $o['created_at'] ? date('d M Y', strtotime($o['created_at'])) : '—';
            ?>
              <tr>
                <td class="text-primary">#<?php echo (int)$o['id']; ?></td>
                <td class="text-primary"><?php echo htmlspecialchars($o['user_name']); ?></td>
                <td style="font-size:0.8rem"><?php echo htmlspecialchars($o['user_email']); ?></td>
                <td class="text-primary" style="font-weight:700"><?php echo number_format((float)$o['total'], 2); ?></td>
                <td><span class="badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($o['status']); ?></span></td>
                <td style="font-size:0.8rem;color:var(--text-muted)"><?php echo $date; ?></td>
                <td>
                  <a href="order_view.php?id=<?php echo (int)$o['id']; ?>" class="btn btn-secondary btn-sm">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    View
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    </div>
  </main>
</div>
</body>
</html>
