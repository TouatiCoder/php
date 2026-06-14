<?php
// admin/category_delete.php?id=123
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AdminController.php';
AdminController::requireAuth();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id<=0) { header('Location: /admin/categories.php'); exit; }
$pdo = getPDO();
$stmt = $pdo->prepare('DELETE FROM categories WHERE id = :id');
$stmt->execute([':id'=>$id]);
header('Location: /admin/categories.php'); exit;
