<?php
// api/cart.php?action=add/remove/update/list
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../config/database.php';
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
$action = $_GET['action'] ?? 'list';

function respond($data) { echo json_encode($data, JSON_UNESCAPED_UNICODE); exit; }

if ($action === 'list') {
    respond(['success' => true, 'cart' => $_SESSION['cart']]);
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

if ($action === 'add') {
    if ($id <= 0) respond(['success'=>false,'error'=>'invalid_id']);
    if ($qty < 1) $qty = 1;
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $qty;
    } else {
        $_SESSION['cart'][$id] = $qty;
    }
    respond(['success'=>true,'cart'=>$_SESSION['cart']]);
}

if ($action === 'update') {
    if ($id <= 0) respond(['success'=>false,'error'=>'invalid_id']);
    if ($qty < 1) { unset($_SESSION['cart'][$id]); }
    else { $_SESSION['cart'][$id] = $qty; }
    respond(['success'=>true,'cart'=>$_SESSION['cart']]);
}

if ($action === 'remove') {
    if ($id <= 0) respond(['success'=>false,'error'=>'invalid_id']);
    unset($_SESSION['cart'][$id]);
    respond(['success'=>true,'cart'=>$_SESSION['cart']]);
}

if ($action === 'clear') {
    $_SESSION['cart'] = [];
    respond(['success'=>true,'cart'=>$_SESSION['cart']]);
}

respond(['success'=>false,'error'=>'unknown_action']);
