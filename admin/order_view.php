<?php
// admin/order_view.php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AdminController.php';
AdminController::requireAuth();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header('Location: orders.php'); exit; }
$pdo = getPDO();
$stmt = $pdo->prepare('SELECT id, user_name, user_email, user_phone, user_address, total, status, created_at FROM orders WHERE id = :id');
$stmt->execute([':id' => $id]);
$order = $stmt->fetch();
if (!$order) { header('Location: orders.php'); exit; }
$it = $pdo->prepare('SELECT oi.*, p.title_en FROM order_items oi JOIN products p ON p.id = oi.product_id WHERE oi.order_id = :oid');
$it->execute([':oid' => $id]);
$items = $it->fetchAll();

$statusClass = match($order['status']) {
  'completed'  => 'badge-green',
  'processing' => 'badge-blue',
  'cancelled'  => 'badge-red',
  default      => 'badge-yellow',
};
$activePage = 'orders';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Order #<?php echo (int)$order['id']; ?> — Admin Panel</title>
  <link rel="stylesheet" href="../css/admin-panel.css">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/_sidebar.php'; ?>
  <main class="admin-main">
    <header class="topbar">
      <div class="topbar-title">Sales <span>/ Orders / #<?php echo (int)$order['id']; ?></span></div>
      <div class="topbar-right">
        <a href="orders.php" class="btn btn-secondary">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
          Back to Orders
        </a>
      </div>
    </header>

    <div class="page-content fade-in">
      <div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start">

        <!-- Left: Items + Status -->
        <div style="display:flex;flex-direction:column;gap:20px">

          <!-- Order Items -->
          <div>
            <div class="section-header"><h2 class="section-title">Order Items</h2></div>
            <div class="panel">
              <?php if (empty($items)): ?>
                <div class="empty-state"><p>No items found.</p></div>
              <?php else: ?>
                <table class="data-table">
                  <thead><tr><th>Product</th><th>Qty</th><th>Unit Price</th><th>Subtotal</th></tr></thead>
                  <tbody>
                  <?php foreach ($items as $i): ?>
                    <tr>
                      <td class="text-primary"><?php echo htmlspecialchars($i['title_en']); ?></td>
                      <td><?php echo (int)$i['qty']; ?></td>
                      <td><?php echo number_format((float)$i['price'], 2); ?></td>
                      <td class="text-primary" style="font-weight:700"><?php echo number_format((float)$i['price'] * (int)$i['qty'], 2); ?></td>
                    </tr>
                  <?php endforeach; ?>
                  </tbody>
                </table>
                <div style="padding:14px 16px;border-top:1px solid var(--border);display:flex;justify-content:space-between;align-items:center">
                  <span style="font-size:0.82rem;color:var(--text-muted)">Total</span>
                  <span style="font-size:1.1rem;font-weight:800;color:var(--text-primary)"><?php echo number_format((float)$order['total'], 2); ?></span>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- Update Status -->
          <div>
            <div class="section-header"><h2 class="section-title">Update Status</h2></div>
            <div class="panel" style="padding:20px">
              <form method="post" action="order_update_status.php" style="display:flex;gap:12px;align-items:flex-end">
                <input type="hidden" name="id" value="<?php echo (int)$order['id']; ?>">
                <div class="field-group" style="flex:1">
                  <label class="field-label">Order Status</label>
                  <select name="status" class="field-select">
                    <?php foreach (['pending','processing','completed','cancelled'] as $s): ?>
                      <option value="<?php echo $s; ?>" <?php echo $order['status']===$s?'selected':''; ?>><?php echo ucfirst($s); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <button type="submit" class="btn btn-primary" style="flex-shrink:0;padding:10px 20px">
                  Update
                </button>
              </form>
            </div>
          </div>

          <!-- Danger zone -->
          <div class="panel" style="padding:18px 20px;border-color:rgba(239,68,68,0.15)">
            <div style="display:flex;align-items:center;justify-content:space-between">
              <div>
                <div style="font-weight:600;color:var(--text-primary);font-size:0.875rem;margin-bottom:3px">Delete Order</div>
                <div style="font-size:0.78rem;color:var(--text-muted)">This action cannot be undone.</div>
              </div>
              <a href="order_delete.php?id=<?php echo (int)$order['id']; ?>" onclick="return confirm('Permanently delete this order?')" class="btn btn-danger">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                Delete
              </a>
            </div>
          </div>

        </div>

        <!-- Right: Customer info -->
        <div style="display:flex;flex-direction:column;gap:16px">
          <div>
            <div class="section-header"><h2 class="section-title">Order Info</h2></div>
            <div class="panel" style="padding:20px;display:flex;flex-direction:column;gap:14px">
              <div style="display:flex;flex-direction:column;gap:3px">
                <span style="font-size:0.68rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-muted)">Order ID</span>
                <span style="font-size:1.1rem;font-weight:800;color:var(--text-primary)">#<?php echo (int)$order['id']; ?></span>
              </div>
              <div style="height:1px;background:var(--border)"></div>
              <div style="display:flex;flex-direction:column;gap:3px">
                <span style="font-size:0.68rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-muted)">Status</span>
                <span class="badge <?php echo $statusClass; ?>" style="align-self:flex-start;font-size:0.78rem"><?php echo htmlspecialchars($order['status']); ?></span>
              </div>
              <div style="height:1px;background:var(--border)"></div>
              <div style="display:flex;flex-direction:column;gap:3px">
                <span style="font-size:0.68rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-muted)">Date</span>
                <span style="color:var(--text-secondary)"><?php echo $order['created_at'] ? date('d M Y · H:i', strtotime($order['created_at'])) : '—'; ?></span>
              </div>
            </div>
          </div>

          <div>
            <div class="section-header"><h2 class="section-title">Customer</h2></div>
            <div class="panel" style="padding:20px;display:flex;flex-direction:column;gap:14px">
              <div style="display:flex;align-items:center;gap:10px">
                <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--brand-mid),var(--brand-accent));display:flex;align-items:center;justify-content:center;font-weight:800;color:#fff;font-size:0.9rem;flex-shrink:0">
                  <?php echo strtoupper(substr($order['user_name'], 0, 1)); ?>
                </div>
                <div>
                  <div style="font-weight:700;color:var(--text-primary)"><?php echo htmlspecialchars($order['user_name']); ?></div>
                  <div style="font-size:0.78rem;color:var(--text-muted)"><?php echo htmlspecialchars($order['user_email']); ?></div>
                </div>
              </div>
              <?php if (!empty($order['user_phone']) || !empty($order['user_address'])): ?>
              <div style="margin-top:14px;display:flex;flex-direction:column;gap:8px;padding-top:14px;border-top:1px solid var(--border)">
                <?php if (!empty($order['user_phone'])): ?>
                  <div><strong>Phone:</strong> <?php echo htmlspecialchars($order['user_phone']); ?></div>
                <?php endif; ?>
                <?php if (!empty($order['user_address'])): ?>
                  <div><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($order['user_address'])); ?></div>
                <?php endif; ?>
              </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

      </div><!-- /grid -->
    </div>
  </main>
</div>
</body>
</html>
