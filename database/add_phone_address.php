<?php
require_once __DIR__ . '/../config/database.php';
$pdo = getPDO();

try {
    // Check if columns exist
    $stmt = $pdo->query("SHOW COLUMNS FROM orders");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (!in_array('user_phone', $columns)) {
        $pdo->exec("ALTER TABLE orders ADD COLUMN user_phone VARCHAR(60) DEFAULT NULL");
        echo "Column user_phone added successfully.\n";
    } else {
        echo "Column user_phone already exists.\n";
    }

    if (!in_array('user_address', $columns)) {
        $pdo->exec("ALTER TABLE orders ADD COLUMN user_address TEXT DEFAULT NULL");
        echo "Column user_address added successfully.\n";
    } else {
        echo "Column user_address already exists.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
