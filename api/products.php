<?php
// api/products.php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/ProductController.php';

header('Content-Type: application/json; charset=utf-8');

$locale = 'en';
if (isset($_GET['locale'])) {
    $l = strtolower(substr($_GET['locale'], 0, 2));
    if (in_array($l, ['en', 'fr', 'ar'])) $locale = $l;
}

$opts = [];
if (isset($_GET['q'])) $opts['q'] = trim($_GET['q']);
if (isset($_GET['category'])) $opts['category'] = (int)$_GET['category'];
if (isset($_GET['page'])) $opts['page'] = (int)$_GET['page'];
if (isset($_GET['limit'])) $opts['limit'] = (int)$_GET['limit'];

$pdo = getPDO();
try {
    $result = ProductController::getProducts($pdo, $locale, $opts);
    echo json_encode(['success' => true, 'products' => $result['products'], 'total' => $result['total'], 'page' => $result['page'], 'limit' => $result['limit']], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
