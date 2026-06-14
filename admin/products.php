<?php
// admin/products.php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AdminController.php';
AdminController::requireAuth();
$pdo = getPDO();
$stmt = $pdo->query('SELECT id, tag, title_en, img, price, available FROM products ORDER BY id DESC');
$products = $stmt->fetchAll();
$activePage = 'products';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Products — Admin Panel</title>
  <link rel="stylesheet" href="../css/admin-panel.css">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/_sidebar.php'; ?>
  <main class="admin-main">
    <header class="topbar">
      <div class="topbar-title">Catalog <span>/ Products</span></div>
      <div class="topbar-right">
        <a href="product_add.php" class="btn btn-primary">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Add Product
        </a>
      </div>
    </header>

    <div class="page-content fade-in">
      <div class="section-header" style="margin-bottom:16px">
        <h1 class="section-title" style="font-size:1.3rem">All Products <span style="color:var(--text-muted);font-weight:400;font-size:0.9rem">(<?php echo count($products); ?>)</span></h1>
      </div>

      <div class="panel">
        <?php if (empty($products)): ?>
          <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            <p>No products found. <a href="product_add.php" style="color:var(--brand-accent)">Add your first product →</a></p>
          </div>
        <?php else: ?>
          <table class="data-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Tag</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $p): ?>
              <tr>
                <td style="color:var(--text-muted);font-size:0.78rem">#<?php echo (int)$p['id']; ?></td>
                <td>
                  <div style="display:flex;align-items:center;gap:10px">
                    <?php if (!empty($p['img'])): ?>
                      <img src="/<?php echo htmlspecialchars($p['img']); ?>" alt="" style="width:36px;height:36px;object-fit:cover;border-radius:8px;border:1px solid var(--border);flex-shrink:0">
                    <?php else: ?>
                      <div style="width:36px;height:36px;border-radius:8px;background:var(--surface-2);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--text-muted)"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                      </div>
                    <?php endif; ?>
                    <span class="text-primary"><?php echo htmlspecialchars($p['title_en']); ?></span>
                  </div>
                </td>
                <td><?php if ($p['tag']): ?><span class="badge badge-purple"><?php echo htmlspecialchars($p['tag']); ?></span><?php endif; ?></td>
                <td class="text-primary"><?php echo number_format((float)$p['price'], 2); ?></td>
                <td>
                  <span class="badge <?php echo $p['available'] ? 'badge-green' : 'badge-gray'; ?>">
                    <?php echo $p['available'] ? 'Active' : 'Hidden'; ?>
                  </span>
                </td>
                <td>
                  <div class="action-group">
                    <a href="product_edit.php?id=<?php echo (int)$p['id']; ?>" class="btn btn-secondary btn-sm">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                      Edit
                    </a>
                    <a href="product_delete.php?id=<?php echo (int)$p['id']; ?>" onclick="return confirm('Delete this product?')" class="btn btn-danger btn-sm">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                      Delete
                    </a>
                  </div>
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
