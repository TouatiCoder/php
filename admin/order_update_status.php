<?php
// admin/order_update_status.php (POST)
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AdminController.php';
AdminController::requireAuth();
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$status = trim($_POST['status'] ?? '');
if ($id<=0) { header('Location: /admin/orders.php'); exit; }
$pdo = getPDO();
$stmt = $pdo->prepare('UPDATE orders SET status = :status WHERE id = :id');
$stmt->execute([':status'=>$status, ':id'=>$id]);
header('Location: /admin/order_view.php?id=' . $id);
exit;
