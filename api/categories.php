<?php
// api/categories.php
declare(strict_types=1);
require_once __DIR__ . '/../config/database.php';
header('Content-Type: application/json; charset=utf-8');
$pdo = getPDO();
$stmt = $pdo->query('SELECT id, name_en, name_fr, name_ar, slug FROM categories ORDER BY name_en ASC');
$cats = $stmt->fetchAll();
echo json_encode(['success'=>true,'categories'=>$cats], JSON_UNESCAPED_UNICODE);
