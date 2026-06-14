<?php
// database/seeder.php - run from CLI or browser to populate sample data
require_once __DIR__ . '/../config/database.php';
$pdo = getPDO();

// categories
$cats = [
  ['name_en'=>'Bags','slug'=>'bags'],
  ['name_en'=>'Boxes','slug'=>'boxes'],
  ['name_en'=>'Future','slug'=>'future'],
];
foreach ($cats as $c) {
  $stmt = $pdo->prepare('SELECT id FROM categories WHERE slug = :slug');
  $stmt->execute([':slug'=>$c['slug']]);
  if (!$stmt->fetch()) {
    $ins = $pdo->prepare('INSERT INTO categories (name_en, slug) VALUES (:name_en, :slug)');
    $ins->execute([':name_en'=>$c['name_en'], ':slug'=>$c['slug']]);
  }
}

// products (if none)
$count = $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
if ($count == 0) {
  $catsMap = [];
  $stmt = $pdo->query('SELECT id, slug FROM categories');
  foreach ($stmt->fetchAll() as $r) $catsMap[$r['slug']] = $r['id'];

  $products = [
    ['category'=>'bags','tag'=>'Available','title_en'=>'Biodegradable Shopping Bags','desc_en'=>'Strong, supple, and made entirely from fruit fibers. Carries up to 8kg.','img'=>'assets/images/product-bag.jpg','price'=>4.99],
    ['category'=>'boxes','tag'=>'Available','title_en'=>'Eco Packaging for Dry Food','desc_en'=>'Premium boxes for grains, nuts and pantry essentials. Compostable in 12 weeks.','img'=>'assets/images/product-box.jpg','price'=>6.99],
    ['category'=>'future','tag'=>'Coming 2026','title_en'=>'Future Packaging Solutions','desc_en'=>'Sculptural bio-containers for cosmetics, e-commerce and the new luxury.','img'=>'assets/images/product-future.jpg','price'=>12.50],
  ];
  $ins = $pdo->prepare('INSERT INTO products (category_id, tag, title_en, desc_en, img, images, stock, price, available) VALUES (:category_id, :tag, :title_en, :desc_en, :img, :images, :stock, :price, 1)');
  foreach ($products as $p) {
    $images = json_encode(array_filter([$p['img']]), JSON_UNESCAPED_UNICODE);
    $stock = $p['stock'] ?? 10;
    $ins->execute([':category_id'=>$catsMap[$p['category']] ?? null, ':tag'=>$p['tag'], ':title_en'=>$p['title_en'], ':desc_en'=>$p['desc_en'], ':img'=>$p['img'], ':images'=>$images, ':stock'=>$stock, ':price'=>$p['price']]);
  }
}

echo "Seeding complete.";
