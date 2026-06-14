<?php
// controllers/ProductController.php
declare(strict_types=1);

require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    public static function getProducts(PDO $pdo, string $locale = 'en', array $opts = []): array
    {
        // support pagination, search and category filtering
        $filtered = Product::fetchFiltered($pdo, $opts);
        $out = [];
        foreach ($filtered['rows'] as $row) {
            $out[] = Product::mapLocalized($row, $locale);
        }
        return ['products' => $out, 'total' => $filtered['total'], 'page' => $filtered['page'], 'limit' => $filtered['limit']];
    }

    public static function getProductById(PDO $pdo, int $id, string $locale = 'en'): ?array
    {
        $row = Product::findById($pdo, $id);
        if (!$row) return null;
        return Product::mapLocalized($row, $locale);
    }

    public static function create(PDO $pdo, array $data): int
    {
        $stmt = $pdo->prepare('INSERT INTO products (category_id, tag, title_en, title_fr, title_ar, desc_en, desc_fr, desc_ar, img, images, stock, price, available) VALUES (:category_id, :tag, :title_en, :title_fr, :title_ar, :desc_en, :desc_fr, :desc_ar, :img, :images, :stock, :price, :available)');
        $stmt->execute([
            ':category_id' => $data['category_id'] ?: null,
            ':tag' => $data['tag'] ?? null,
            ':title_en' => $data['title_en'] ?? '',
            ':title_fr' => $data['title_fr'] ?? null,
            ':title_ar' => $data['title_ar'] ?? null,
            ':desc_en' => $data['desc_en'] ?? null,
            ':desc_fr' => $data['desc_fr'] ?? null,
            ':desc_ar' => $data['desc_ar'] ?? null,
            ':img' => $data['img'] ?? null,
            ':images' => isset($data['images']) ? json_encode($data['images'], JSON_UNESCAPED_UNICODE) : null,
            ':stock' => isset($data['stock']) ? (int)$data['stock'] : 0,
            ':price' => $data['price'] ?? null,
            ':available' => $data['available'] ? 1 : 0,
        ]);
        return (int)$pdo->lastInsertId();
    }

    public static function update(PDO $pdo, int $id, array $data): bool
    {
        $stmt = $pdo->prepare('UPDATE products SET category_id = :category_id, tag = :tag, title_en = :title_en, title_fr = :title_fr, title_ar = :title_ar, desc_en = :desc_en, desc_fr = :desc_fr, desc_ar = :desc_ar, img = :img, images = :images, stock = :stock, price = :price, available = :available WHERE id = :id');
        return $stmt->execute([
            ':category_id' => $data['category_id'] ?: null,
            ':tag' => $data['tag'] ?? null,
            ':title_en' => $data['title_en'] ?? '',
            ':title_fr' => $data['title_fr'] ?? null,
            ':title_ar' => $data['title_ar'] ?? null,
            ':desc_en' => $data['desc_en'] ?? null,
            ':desc_fr' => $data['desc_fr'] ?? null,
            ':desc_ar' => $data['desc_ar'] ?? null,
            ':img' => $data['img'] ?? null,
            ':images' => isset($data['images']) ? json_encode($data['images'], JSON_UNESCAPED_UNICODE) : null,
            ':stock' => isset($data['stock']) ? (int)$data['stock'] : 0,
            ':price' => $data['price'] ?? null,
            ':available' => $data['available'] ? 1 : 0,
            ':id' => $id,
        ]);
    }

    public static function delete(PDO $pdo, int $id): bool
    {
        $stmt = $pdo->prepare('DELETE FROM products WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }
}
