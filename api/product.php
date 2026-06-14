<?php
// api/product.php?id=123&locale=en
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Product.php';

header('Content-Type: application/json; charset=utf-8');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$locale = 'en';
if (isset($_GET['locale'])) {
    $l = strtolower(substr($_GET['locale'], 0, 2));
    if (in_array($l, ['en', 'fr', 'ar'])) $locale = $l;
}

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'invalid_id']);
    exit;
}

$pdo = getPDO();
try {
    $stmt = $pdo->prepare('SELECT p.id, p.category_id, p.tag, p.img, p.images, p.stock, p.created_at, p.title_en, p.title_fr, p.title_ar, p.desc_en, p.desc_fr, p.desc_ar, p.price, p.available, c.name_en AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = :id LIMIT 1');
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
    if (!$row) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'not_found']);
        exit;
    }
    $product = Product::mapLocalized($row, $locale);
    $product['category_name'] = $row['category_name'] ?? null;
    // fetch related products (same category) limited to 4
    $related = [];
    if (!empty($row['category_id'])) {
        $stmtR = $pdo->prepare('SELECT id, tag, img, images, title_en, title_fr, title_ar, desc_en, desc_fr, desc_ar, price FROM products WHERE category_id = :cid AND id != :id AND available = 1 LIMIT 4');
        $stmtR->execute([':cid'=>$row['category_id'], ':id'=>$row['id']]);
        $rowsR = $stmtR->fetchAll();
        foreach ($rowsR as $r) $related[] = Product::mapLocalized($r, $locale);
    }
    echo json_encode(['success' => true, 'product' => $product, 'related' => $related], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
