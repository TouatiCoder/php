<?php
// api/order.php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../config/database.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'method_not_allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
$productId = isset($input['product_id']) ? (int)$input['product_id'] : 0;
$qty = isset($input['qty']) ? max(1, (int)$input['qty']) : 1;
$name = trim((string)($input['full_name'] ?? ''));
$address = trim((string)($input['address'] ?? ''));
$phone = trim((string)($input['phone'] ?? ''));

if ($productId <= 0 || $qty <= 0 || $name === '' || $address === '' || $phone === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'invalid_request']);
    exit;
}

$pdo = getPDO();
$productStmt = $pdo->prepare('SELECT id, price, stock, available FROM products WHERE id = :id LIMIT 1');
$productStmt->execute([':id' => $productId]);
$product = $productStmt->fetch();

if (!$product || !$product['available'] || (int)$product['stock'] < $qty) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'product_unavailable']);
    exit;
}

$total = (float)$product['price'] * $qty;
$columns = [];
try {
    $columns = $pdo->query('SHOW COLUMNS FROM orders')->fetchAll(PDO::FETCH_COLUMN);
} catch (Throwable $e) {
    $columns = [];
}

$hasPhone = in_array('user_phone', $columns, true);
$hasAddress = in_array('user_address', $columns, true);

$insertColumns = ['user_name', 'user_email', 'total', 'status'];
$insertParams = [
    ':name' => $name,
    ':email' => null,
    ':total' => $total,
    ':status' => 'pending',
];

if ($hasPhone) {
    $insertColumns[] = 'user_phone';
    $insertParams[':phone'] = $phone;
}
if ($hasAddress) {
    $insertColumns[] = 'user_address';
    $insertParams[':address'] = $address;
}

$columnSql = implode(', ', $insertColumns);
$valueSql = implode(', ', array_keys($insertParams));

try {
    $pdo->beginTransaction();
    $ins = $pdo->prepare("INSERT INTO orders ({$columnSql}) VALUES ({$valueSql})");
    $ins->execute($insertParams);
    $orderId = (int)$pdo->lastInsertId();

    $itemStmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, qty, price) VALUES (:order_id, :product_id, :qty, :price)');
    $itemStmt->execute([
        ':order_id' => $orderId,
        ':product_id' => $productId,
        ':qty' => $qty,
        ':price' => $product['price'],
    ]);

    $pdo->commit();
    echo json_encode(['success' => true, 'order_id' => $orderId]);
} catch (Throwable $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'server_error']);
}
