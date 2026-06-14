<?php
require 'config/database.php';
$pdo = getPDO();
echo "orders columns:\n";
foreach ($pdo->query('SHOW COLUMNS FROM orders')->fetchAll(PDO::FETCH_COLUMN) as $col) {
    echo $col . "\n";
}
echo "products sample ids:\n";
foreach ($pdo->query('SELECT id,title_en,available,stock FROM products ORDER BY id ASC LIMIT 10')->fetchAll() as $row) {
    echo json_encode($row, JSON_UNESCAPED_UNICODE) . "\n";
}
