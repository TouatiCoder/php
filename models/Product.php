<?php
// models/Product.php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

class Product
{
    public static function fetchAll(PDO $pdo): array
    {
        $stmt = $pdo->prepare('SELECT id, category_id, tag, img, images, stock, created_at, title_en, title_fr, title_ar, desc_en, desc_fr, desc_ar, price, available FROM products WHERE available = 1 ORDER BY id ASC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function fetchFiltered(PDO $pdo, array $opts = []): array
    {
        $q = $opts['q'] ?? null;
        $category = isset($opts['category']) ? (int)$opts['category'] : null;
        $page = max(1, (int)($opts['page'] ?? 1));
        $limit = max(1, min(100, (int)($opts['limit'] ?? 9)));
        $offset = ($page - 1) * $limit;

        $where = ['available = 1'];
        $params = [];
        if ($category) {
            $where[] = 'category_id = :category';
            $params[':category'] = $category;
        }
        if ($q) {
            $where[] = '(title_en LIKE :q OR title_fr LIKE :q OR title_ar LIKE :q OR desc_en LIKE :q OR desc_fr LIKE :q OR desc_ar LIKE :q)';
            $params[':q'] = "%{$q}%";
        }

        $sql = 'SELECT SQL_CALC_FOUND_ROWS id, category_id, tag, img, images, stock, created_at, title_en, title_fr, title_ar, desc_en, desc_fr, desc_ar, price, available FROM products';
        if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
        $sql .= ' ORDER BY id DESC LIMIT :limit OFFSET :offset';

        $stmt = $pdo->prepare($sql);
        foreach ($params as $k => $v) $stmt->bindValue($k, $v);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $total = $pdo->query('SELECT FOUND_ROWS()')->fetchColumn();
        return ['rows' => $rows, 'total' => (int)$total, 'page' => $page, 'limit' => $limit];
    }

    public static function findById(PDO $pdo, int $id): ?array
    {
        $stmt = $pdo->prepare('SELECT id, category_id, tag, img, images, stock, created_at, title_en, title_fr, title_ar, desc_en, desc_fr, desc_ar, price, available FROM products WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function mapLocalized(array $row, string $locale): array
    {
        $titleKey = 'title_' . $locale;
        $descKey = 'desc_' . $locale;
        $images = [];
        if (!empty($row['images'])) {
            $decoded = json_decode($row['images'], true);
            if (is_array($decoded)) $images = $decoded;
        }
        if (empty($images) && !empty($row['img'])) $images = [$row['img']];
        return [
            'id' => (int)$row['id'],
            'category_id' => isset($row['category_id']) ? (int)$row['category_id'] : null,
            'tag' => $row['tag'],
            'title' => $row[$titleKey] ?? $row['title_en'] ?? '',
            'desc' => $row[$descKey] ?? $row['desc_en'] ?? '',
            'img' => $row['img'],
            'images' => $images,
            'price' => isset($row['price']) ? number_format((float)$row['price'], 2) : null,
            'stock' => isset($row['stock']) ? (int)$row['stock'] : 0,
            'available' => (bool)$row['available'],
            'created_at' => isset($row['created_at']) ? $row['created_at'] : null,
        ];
    }
}
