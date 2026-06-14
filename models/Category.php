<?php
// models/Category.php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

class Category
{
    public static function all(PDO $pdo): array
    {
        $stmt = $pdo->query('SELECT id, name_en, name_fr, name_ar, slug FROM categories ORDER BY name_en ASC');
        return $stmt->fetchAll();
    }

    public static function find(PDO $pdo, int $id): ?array
    {
        $stmt = $pdo->prepare('SELECT id, name_en, name_fr, name_ar, slug FROM categories WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
