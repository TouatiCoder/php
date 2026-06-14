<?php
// admin/categories.php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AdminController.php';
AdminController::requireAuth();
$pdo = getPDO();
$stmt = $pdo->query('SELECT id, name_en, slug FROM categories ORDER BY id DESC');
$cats = $stmt->fetchAll();
$activePage = 'categories';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Categories — Admin Panel</title>
  <link rel="stylesheet" href="../css/admin-panel.css">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/_sidebar.php'; ?>
  <main class="admin-main">
    <header class="topbar">
      <div class="topbar-title">Catalog <span>/ Categories</span></div>
      <div class="topbar-right">
        <a href="category_add.php" class="btn btn-primary">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Add Category
        </a>
      </div>
    </header>

    <div class="page-content fade-in">
      <div class="section-header" style="margin-bottom:16px">
        <h1 class="section-title" style="font-size:1.3rem">Categories <span style="color:var(--text-muted);font-weight:400;font-size:0.9rem">(<?php echo count($cats); ?>)</span></h1>
      </div>

      <div class="panel">
        <?php if (empty($cats)): ?>
          <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
            <p>No categories yet. <a href="category_add.php" style="color:var(--brand-accent)">Add your first →</a></p>
          </div>
        <?php else: ?>
          <table class="data-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($cats as $c): ?>
              <tr>
                <td style="color:var(--text-muted);font-size:0.78rem">#<?php echo (int)$c['id']; ?></td>
                <td class="text-primary"><?php echo htmlspecialchars($c['name_en']); ?></td>
                <td><code style="background:var(--surface-2);padding:3px 8px;border-radius:6px;font-size:0.78rem;color:var(--brand-accent)"><?php echo htmlspecialchars($c['slug']); ?></code></td>
                <td>
                  <div class="action-group">
                    <a href="category_edit.php?id=<?php echo (int)$c['id']; ?>" class="btn btn-secondary btn-sm">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                      Edit
                    </a>
                    <a href="category_delete.php?id=<?php echo (int)$c['id']; ?>" onclick="return confirm('Delete this category?')" class="btn btn-danger btn-sm">
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
