<?php
// api/checkout.php (POST)
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../config/database.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['success'=>false,'error'=>'method']); exit; }

$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
$name = trim($input['name'] ?? '');
$email = trim($input['email'] ?? '');

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'invalid_customer']); exit;
}

if (empty($_SESSION['cart'])) {
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'cart_empty']); exit;
}

$pdo = getPDO();
try {
    $pdo->beginTransaction();
    $total = 0.0;
    $items = [];
    $stmt = $pdo->prepare('SELECT id, price FROM products WHERE id IN (' . implode(',', array_map('intval', array_keys($_SESSION['cart']))) . ')');
    $stmt->execute();
    $rows = $stmt->fetchAll();
    $prices = [];
    foreach ($rows as $r) $prices[$r['id']] = (float)$r['price'];

    foreach ($_SESSION['cart'] as $pid => $qty) {
        $price = $prices[$pid] ?? 0.0;
        $line = $price * $qty;
        $total += $line;
        $items[] = ['product_id'=>$pid, 'qty'=>$qty, 'price'=>$price];
    }

    $ins = $pdo->prepare('INSERT INTO orders (user_name, user_email, total, status) VALUES (:name, :email, :total, :status)');
    $ins->execute([':name'=>$name, ':email'=>$email, ':total'=>$total, ':status'=>'pending']);
    $orderId = (int)$pdo->lastInsertId();

    $itSt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, qty, price) VALUES (:order_id, :product_id, :qty, :price)');
    foreach ($items as $it) {
        $itSt->execute([':order_id'=>$orderId, ':product_id'=>$it['product_id'], ':qty'=>$it['qty'], ':price'=>$it['price']]);
    }

    $pdo->commit();
    // clear cart
    $_SESSION['cart'] = [];
    echo json_encode(['success'=>true,'order_id'=>$orderId]);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}
