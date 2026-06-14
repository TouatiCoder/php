<?php
// admin/product_edit.php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../lib/upload.php';
require_once __DIR__ . '/../controllers/AdminController.php';
AdminController::requireAuth();

$pdo = getPDO();
$categories = Category::all($pdo);
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header('Location: products.php'); exit; }
$row = Product::findById($pdo, $id);
if (!$row) { header('Location: products.php'); exit; }
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title_en = trim($_POST['title_en'] ?? '');
    if ($title_en === '') $error = 'Title (EN) is required.';
    else {
        $imgFile  = $_FILES['img'] ?? null;
        $uploaded = handleImageUpload($imgFile, __DIR__ . '/../assets/images/uploads');
        if ($uploaded && !empty($row['img']) && str_contains($row['img'], 'assets/images/uploads/')) {
            $old = __DIR__ . '/../' . $row['img'];
            if (is_file($old)) @unlink($old);
        }
        $data = [
            'category_id' => (int)($_POST['category_id'] ?: 0) ?: null,
            'tag'         => trim($_POST['tag'] ?? ''),
            'title_en'    => $title_en,
            'title_fr'    => trim($_POST['title_fr'] ?? ''),
            'title_ar'    => trim($_POST['title_ar'] ?? ''),
            'desc_en'     => trim($_POST['desc_en'] ?? ''),
            'desc_fr'     => trim($_POST['desc_fr'] ?? ''),
            'desc_ar'     => trim($_POST['desc_ar'] ?? ''),
            'img'         => $uploaded ? 'assets/images/uploads/' . $uploaded : $row['img'],
            'price'       => isset($_POST['price']) ? (float)$_POST['price'] : null,
            'available'   => isset($_POST['available']) ? 1 : 0,
        ];
        try {
            ProductController::update($pdo, $id, $data);
            header('Location: products.php'); exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
$activePage = 'products';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Product — Admin Panel</title>
  <link rel="stylesheet" href="../css/admin-panel.css">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/_sidebar.php'; ?>
  <main class="admin-main">
    <header class="topbar">
      <div class="topbar-title">Catalog <span>/ Products / Edit</span></div>
      <div class="topbar-right">
        <a href="products.php" class="btn btn-secondary">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
          Back
        </a>
      </div>
    </header>

    <div class="page-content fade-in">
      <div style="max-width:860px">
        <h1 class="section-title" style="font-size:1.3rem;margin-bottom:20px">Edit: <?php echo htmlspecialchars($row['title_en']); ?></h1>

        <?php if ($error): ?>
          <div class="alert alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <?php echo htmlspecialchars($error); ?>
          </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
          <div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start">

            <!-- Left -->
            <div style="display:flex;flex-direction:column;gap:20px">
              <div class="panel" style="padding:24px">
                <h2 style="font-size:0.82rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-muted);margin-bottom:18px">Basic Info</h2>
                <div class="form-grid">
                  <div class="field-group full">
                    <label class="field-label">Title (English) <span style="color:#f87171">*</span></label>
                    <input class="field-input" name="title_en" type="text" required placeholder="English name" value="<?php echo htmlspecialchars($row['title_en']); ?>">
                  </div>
                  <div class="field-group">
                    <label class="field-label">Title (French)</label>
                    <input class="field-input" name="title_fr" type="text" placeholder="French name" value="<?php echo htmlspecialchars($row['title_fr']); ?>">
                  </div>
                  <div class="field-group">
                    <label class="field-label">Title (Arabic)</label>
                    <input class="field-input" name="title_ar" type="text" dir="rtl" placeholder="Arabic name" value="<?php echo htmlspecialchars($row['title_ar']); ?>">
                  </div>
                </div>
              </div>

              <div class="panel" style="padding:24px">
                <h2 style="font-size:0.82rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-muted);margin-bottom:18px">Descriptions</h2>
                <div class="form-grid cols-1" style="gap:14px">
                  <div class="field-group">
                    <label class="field-label">Description (EN)</label>
                    <textarea class="field-textarea" name="desc_en"><?php echo htmlspecialchars($row['desc_en']); ?></textarea>
                  </div>
                  <div class="field-group">
                    <label class="field-label">Description (FR)</label>
                    <textarea class="field-textarea" name="desc_fr"><?php echo htmlspecialchars($row['desc_fr']); ?></textarea>
                  </div>
                  <div class="field-group">
                    <label class="field-label">Description (AR)</label>
                    <textarea class="field-textarea" name="desc_ar" dir="rtl"><?php echo htmlspecialchars($row['desc_ar']); ?></textarea>
                  </div>
                </div>
              </div>
            </div>

            <!-- Right -->
            <div style="display:flex;flex-direction:column;gap:20px">
              <div class="panel" style="padding:24px">
                <h2 style="font-size:0.82rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-muted);margin-bottom:18px">Details</h2>
                <div style="display:flex;flex-direction:column;gap:14px">
                  <div class="field-group">
                    <label class="field-label">Category</label>
                    <select class="field-select" name="category_id">
                      <option value="">— None —</option>
                      <?php foreach ($categories as $c): ?>
                        <option value="<?php echo (int)$c['id']; ?>" <?php echo ($row['category_id']==$c['id'])?'selected':''; ?>><?php echo htmlspecialchars($c['name_en']); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="field-group">
                    <label class="field-label">Tag</label>
                    <input class="field-input" name="tag" type="text" placeholder="e.g. New, Sale…" value="<?php echo htmlspecialchars($row['tag']); ?>">
                  </div>
                  <div class="field-group">
                    <label class="field-label">Price</label>
                    <input class="field-input" name="price" type="number" step="0.01" min="0" value="<?php echo htmlspecialchars($row['price']); ?>">
                  </div>
                  <div class="field-group">
                    <label class="field-label">Product Image</label>
                    <?php if (!empty($row['img'])): ?>
                      <div style="margin-bottom:8px;border-radius:10px;overflow:hidden;border:1px solid var(--border)">
                        <img src="/<?php echo htmlspecialchars($row['img']); ?>" alt="" style="width:100%;height:140px;object-fit:cover;display:block">
                      </div>
                    <?php endif; ?>
                    <input class="field-input" name="img" type="file" accept="image/*" style="padding:8px 14px;cursor:pointer">
                  </div>
                  <label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:12px;background:var(--surface-2);border-radius:var(--radius-sm);border:1px solid var(--border)">
                    <input type="checkbox" name="available" <?php echo $row['available'] ? 'checked' : ''; ?> style="width:16px;height:16px;accent-color:var(--brand-accent)">
                    <span style="font-size:0.875rem;color:var(--text-primary);font-weight:500">Available for sale</span>
                  </label>
                </div>
              </div>

              <div class="form-actions">
                <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center;padding:12px">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                  Save Changes
                </button>
                <a href="products.php" class="btn btn-secondary" style="padding:12px 16px">Cancel</a>
              </div>
            </div>

          </div>
        </form>
      </div>
    </div>
  </main>
</div>
</body>
</html>
