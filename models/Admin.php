<?php
// models/Admin.php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

class Admin
{
    public static function findByUsername(PDO $pdo, string $username): ?array
    {
        $stmt = $pdo->prepare('SELECT id, username, password_hash FROM admins WHERE username = :username LIMIT 1');
        $stmt->execute([':username' => $username]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
