<?php
// admin/product_delete.php?id=123
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../controllers/AdminController.php';
AdminController::requireAuth();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header('Location: /admin/products.php'); exit; }
$pdo = getPDO();
$row = Product::findById($pdo, $id);
if ($row) {
    // delete image file if uploaded in uploads
    if (!empty($row['img']) && str_contains($row['img'], 'assets/images/uploads/')) {
        $path = __DIR__ . '/../' . $row['img'];
        if (is_file($path)) @unlink($path);
    }
    ProductController::delete($pdo, $id);
}
header('Location: /admin/products.php');
exit;
