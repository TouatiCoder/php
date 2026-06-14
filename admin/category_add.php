<?php
// admin/category_add.php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AdminController.php';
AdminController::requireAuth();
$pdo = getPDO();
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_en = trim($_POST['name_en'] ?? '');
    $slug    = trim($_POST['slug'] ?? '');
    if ($name_en === '') $error = 'Name (EN) is required.';
    elseif ($slug === '') $error = 'Slug is required.';
    else {
        $stmt = $pdo->prepare('INSERT INTO categories (name_en, name_fr, name_ar, slug) VALUES (:name_en, :name_fr, :name_ar, :slug)');
        $stmt->execute([':name_en'=>$name_en, ':name_fr'=>trim($_POST['name_fr']??''), ':name_ar'=>trim($_POST['name_ar']??''), ':slug'=>$slug]);
        header('Location: categories.php'); exit;
    }
}
$activePage = 'categories';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Category — Admin Panel</title>
  <link rel="stylesheet" href="../css/admin-panel.css">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/_sidebar.php'; ?>
  <main class="admin-main">
    <header class="topbar">
      <div class="topbar-title">Catalog <span>/ Categories / Add</span></div>
      <div class="topbar-right">
        <a href="categories.php" class="btn btn-secondary">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
          Back
        </a>
      </div>
    </header>

    <div class="page-content fade-in">
      <div style="max-width:580px">
        <h1 class="section-title" style="font-size:1.3rem;margin-bottom:20px">Add Category</h1>

        <?php if ($error): ?>
          <div class="alert alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <?php echo htmlspecialchars($error); ?>
          </div>
        <?php endif; ?>

        <div class="panel" style="padding:28px">
          <form method="post">
            <div style="display:flex;flex-direction:column;gap:16px">
              <div class="form-grid">
                <div class="field-group">
                  <label class="field-label" for="name_en">Name (English) <span style="color:#f87171">*</span></label>
                  <input class="field-input" id="name_en" name="name_en" type="text" required placeholder="English name" value="<?php echo htmlspecialchars($_POST['name_en'] ?? ''); ?>">
                </div>
                <div class="field-group">
                  <label class="field-label" for="slug">Slug <span style="color:#f87171">*</span></label>
                  <input class="field-input" id="slug" name="slug" type="text" required placeholder="e.g. tea-sets" value="<?php echo htmlspecialchars($_POST['slug'] ?? ''); ?>">
                </div>
                <div class="field-group">
                  <label class="field-label" for="name_fr">Name (French)</label>
                  <input class="field-input" id="name_fr" name="name_fr" type="text" placeholder="French name" value="<?php echo htmlspecialchars($_POST['name_fr'] ?? ''); ?>">
                </div>
                <div class="field-group">
                  <label class="field-label" for="name_ar">Name (Arabic)</label>
                  <input class="field-input" id="name_ar" name="name_ar" type="text" dir="rtl" placeholder="Arabic name" value="<?php echo htmlspecialchars($_POST['name_ar'] ?? ''); ?>">
                </div>
              </div>

              <div class="form-actions" style="margin-top:8px">
                <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center;padding:12px">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                  Create Category
                </button>
                <a href="categories.php" class="btn btn-secondary" style="padding:12px 16px">Cancel</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</div>

<script>
  // Auto-generate slug from English name
  document.getElementById('name_en').addEventListener('input', function() {
    const slugField = document.getElementById('slug');
    if (!slugField.dataset.touched) {
      slugField.value = this.value.toLowerCase().trim().replace(/\s+/g,'-').replace(/[^a-z0-9-]/g,'');
    }
  });
  document.getElementById('slug').addEventListener('input', function() {
    this.dataset.touched = '1';
  });
</script>
</body>
</html>
