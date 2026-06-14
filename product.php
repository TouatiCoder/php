<?php
// product.php - server-rendered product detail page
declare(strict_types=1);
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/Product.php';
require_once __DIR__ . '/models/Category.php';

$pdo = getPDO();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Safe locale check
$locale = 'en';
if (isset($_GET['locale']) && in_array($_GET['locale'], ['en', 'fr', 'ar'])) {
    $locale = $_GET['locale'];
}

if ($id <= 0) {
    http_response_code(404);
    echo "Product not found";
    exit;
}

$row = Product::findById($pdo, $id);
if (!$row) {
    http_response_code(404);
    echo "Product not found";
    exit;
}

$product = Product::mapLocalized($row, $locale);
$category = null;
if (!empty($row['category_id'])) {
    $category = Category::find($pdo, (int)$row['category_id']);
}
$product['category_name'] = $category ? ($category['name_' . $locale] ?? $category['name_en']) : null;

// related products
$relStmt = $pdo->prepare('SELECT id, category_id, tag, img, images, stock, created_at, title_en, title_fr, title_ar, desc_en, desc_fr, desc_ar, price, available FROM products WHERE category_id = :cat AND id != :id AND available = 1 ORDER BY id DESC LIMIT 3');
$relStmt->execute([':cat' => $row['category_id'], ':id' => $id]);
$relatedRows = $relStmt->fetchAll();
$related = array_map(function($r) use ($locale) { 
    return Product::mapLocalized($r, $locale); 
}, $relatedRows);

// Localized translation helper for server rendering
$translations = [
    'en' => [
        'brand' => 'Aqcha.',
        'join' => 'Join the Movement',
        'links' => [
            ['label' => 'Crisis', 'url' => 'pages/crisis.php'],
            ['label' => 'Revolution', 'url' => 'pages/revolution.php'],
            ['label' => 'Why Us', 'url' => 'pages/why.php'],
            ['label' => 'Products', 'url' => 'pages/products.php'],
            ['label' => 'Impact', 'url' => 'pages/impact.php'],
        ],
        'back' => 'Back to Products',
        'category' => 'Category',
        'stock' => 'Stock',
        'available' => 'available',
        'out_of_stock' => 'Out of Stock',
        'add_to_cart' => 'Add to Cart',
        'buy_now' => 'Buy Now',
        'related_products' => 'Related Products',
        'sustainability' => 'Sustainability Highlights',
        'sustain1' => '100% Bio-based & compostable in weeks',
        'sustain2' => 'Made from local agricultural waste',
        'sustain3' => 'Plastic-free, toxic-free packaging',
        'footer_copy' => '© ' . date('Y') . ' AQCHA · Designed in Morocco for the planet.',
        'instagram' => 'Instagram',
        'linkedin' => 'LinkedIn',
    ],
    'fr' => [
        'brand' => 'Aqcha.',
        'join' => 'Rejoindre le mouvement',
        'links' => [
            ['label' => 'Crise', 'url' => 'pages/crisis.php'],
            ['label' => 'Révolution', 'url' => 'pages/revolution.php'],
            ['label' => 'Pourquoi nous', 'url' => 'pages/why.php'],
            ['label' => 'Produits', 'url' => 'pages/products.php'],
            ['label' => 'Impact', 'url' => 'pages/impact.php'],
        ],
        'back' => 'Retour aux produits',
        'category' => 'Catégorie',
        'stock' => 'Stock',
        'available' => 'disponible(s)',
        'out_of_stock' => 'Rupture de stock',
        'add_to_cart' => 'Ajouter au panier',
        'buy_now' => 'Acheter maintenant',
        'related_products' => 'Produits similaires',
        'sustainability' => 'Points forts écologiques',
        'sustain1' => '100% biosourcé & compostable en quelques semaines',
        'sustain2' => 'Fabriqué à partir de déchets agricoles locaux',
        'sustain3' => 'Emballage sans plastique ni toxines',
        'footer_copy' => '© ' . date('Y') . ' AQCHA · Conçu au Maroc pour la planète.',
        'instagram' => 'Instagram',
        'linkedin' => 'LinkedIn',
    ],
    'ar' => [
        'brand' => 'Aqcha.',
        'join' => 'انضم للحركة',
        'links' => [
            ['label' => 'الأزمة', 'url' => 'pages/crisis.php'],
            ['label' => 'الثورة', 'url' => 'pages/revolution.php'],
            ['label' => 'لماذا نحن', 'url' => 'pages/why.php'],
            ['label' => 'المنتجات', 'url' => 'pages/products.php'],
            ['label' => 'الأثر', 'url' => 'pages/impact.php'],
        ],
        'back' => 'العودة إلى المنتجات',
        'category' => 'الفئة',
        'stock' => 'المخزون',
        'available' => 'متوفر',
        'out_of_stock' => 'غير متوفر',
        'add_to_cart' => 'أضف إلى السلة',
        'buy_now' => 'اشتري الآن',
        'related_products' => 'منتجات ذات صلة',
        'sustainability' => 'أهم مميزات الاستدامة',
        'sustain1' => 'حيوي 100٪ وقابل للتحلل خلال أسابيع',
        'sustain2' => 'مصنوع من النفايات الزراعية المحلية',
        'sustain3' => 'تغليف خالٍ من البلاستيك والسموم',
        'footer_copy' => '© ' . date('Y') . ' AQCHA · مصمم في المغرب من أجل الكوكب.',
        'instagram' => 'إنستاجرام',
        'linkedin' => 'لينكدإن',
    ]
];

$t = $translations[$locale];
$images = !empty($product['images']) ? $product['images'] : (!empty($product['img']) ? [$product['img']] : []);
$mainImage = $images[0] ?? '';
$available = $product['available'] && $product['stock'] > 0;
$createdTime = !empty($product['created_at']) ? strtotime($product['created_at']) : time();
$createdStr = date('F j, Y', $createdTime);
if ($locale === 'fr') {
    $createdStr = date('d/m/Y', $createdTime);
} elseif ($locale === 'ar') {
    $createdStr = date('Y-m-d', $createdTime);
}
?>
<!DOCTYPE html>
<html lang="<?php echo $locale; ?>" dir="<?php echo $locale === 'ar' ? 'rtl' : 'ltr'; ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($product['title'] . ' — AQCHA') ?></title>
  <meta name="description" content="<?php echo htmlspecialchars(substr($product['desc'], 0, 160)) ?>">
  
  <meta property="og:title" content="<?php echo htmlspecialchars($product['title']) ?>">
  <meta property="og:description" content="<?php echo htmlspecialchars(substr($product['desc'], 0, 160)) ?>">
  <meta property="og:image" content="<?php echo htmlspecialchars(ltrim($mainImage, '/')) ?>">
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,300;9..144,400;9..144,500;9..144,600&family=Inter:wght@300;400;500;600;700&display=swap">
  
  <link rel="stylesheet" href="css/react-build.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-[var(--cream)] text-[var(--forest-deep)] font-sans antialiased">

  <!-- Fixed Header -->
  <header class="fixed top-0 left-0 right-0 z-50 flex justify-center pt-5 px-4">
    <nav class="bg-[var(--forest-deep)] rounded-full px-2 py-2 flex flex-wrap items-center gap-2 text-[var(--cream)] shadow-[0_10px_40px_-15px_rgba(0,0,0,0.35)]">
      <a href="index.php" class="pl-4 pr-6 font-display text-xl tracking-tight">
        <?php echo htmlspecialchars($t['brand']); ?><span class="text-[var(--amber)]">.</span>
      </a>
      <div class="hidden md:flex items-center gap-1 text-sm">
        <?php foreach ($t['links'] as $link): ?>
          <a href="<?php echo $link['url']; ?>" class="px-4 py-2 rounded-full opacity-80 hover:opacity-100 hover:bg-white/10 transition"><?php echo htmlspecialchars($link['label']); ?></a>
        <?php endforeach; ?>
      </div>
      <div class="flex items-center gap-2 ml-auto">
        <a href="index.php#contact" class="inline-flex items-center gap-1.5 rounded-full bg-[var(--amber)] text-[var(--forest-deep)] pl-5 pr-4 py-2 text-sm font-medium hover:scale-[1.03] transition">
          <?php echo htmlspecialchars($t['join']); ?> 
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M7 7h10v10"></path><path d="M7 17 17 7"></path></svg>
        </a>
        <select data-locale-select class="rounded-full bg-[var(--forest-deep)] text-[var(--cream)] px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em] focus:outline-none">
          <option value="en" <?php echo $locale === 'en' ? 'selected' : ''; ?>>English</option>
          <option value="fr" <?php echo $locale === 'fr' ? 'selected' : ''; ?>>Français</option>
          <option value="ar" <?php echo $locale === 'ar' ? 'selected' : ''; ?>>العربية</option>
        </select>
      </div>
    </nav>
  </header>

  <!-- Main app mount container -->
  <div id="app" data-page="product">
    <main class="bg-[var(--cream)] text-[var(--forest-deep)] min-h-screen pt-28">
      <section class="bg-[var(--cream)] py-24 md:py-32">
        <div class="container mx-auto px-6 max-w-7xl">
          
          <!-- Back button / Breadcrumbs -->
          <div class="mb-10 flex flex-wrap items-center justify-between gap-4">
            <a href="products.php" class="group inline-flex items-center gap-2 text-sm font-medium text-[var(--forest-deep)] opacity-70 hover:opacity-100 transition-opacity">
              <span class="inline-block transition-transform group-hover:-translate-x-1">←</span>
              <?php echo htmlspecialchars($t['back']); ?>
            </a>
            <nav class="text-xs uppercase tracking-wider opacity-50 flex items-center gap-2">
              <a href="index.php" class="hover:underline"><?php echo htmlspecialchars($locale === 'ar' ? 'الرئيسية' : ($locale === 'fr' ? 'Accueil' : 'Home')); ?></a>
              <span>/</span>
              <a href="products.php" class="hover:underline"><?php echo htmlspecialchars($t['category']); ?></a>
              <?php if (!empty($product['category_name'])): ?>
                <span>/</span>
                <span class="font-semibold"><?php echo htmlspecialchars($product['category_name']); ?></span>
              <?php endif; ?>
            </nav>
          </div>

          <!-- Product Details Section -->
          <div class="grid md:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            <!-- Left: Gallery -->
            <div class="md:col-span-7">
              <div class="rounded-[2rem] overflow-hidden bg-[var(--bone)] shadow-sm border border-[var(--forest)]/5 relative group aspect-square">
                <img id="main-product-image" src="<?php echo htmlspecialchars(ltrim($mainImage, '/')); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                <span class="absolute top-6 left-6 glass rounded-full px-4 py-1.5 text-[10px] uppercase tracking-[0.18em] text-[var(--forest-deep)] font-semibold shadow-sm">
                  <?php echo htmlspecialchars($product['tag'] ?: 'ECO'); ?>
                </span>
              </div>
              
              <?php if (count($images) > 1): ?>
                <div class="mt-4 grid grid-cols-5 gap-3">
                  <?php foreach (array_slice($images, 0, 5) as $idx => $im): ?>
                    <div class="aspect-square rounded-2xl overflow-hidden bg-[var(--bone)] cursor-pointer border-2 transition-all duration-200 thumb-container <?php echo $idx === 0 ? 'border-[var(--forest-deep)]' : 'border-transparent'; ?>" data-src="<?php echo htmlspecialchars(ltrim($im, '/')); ?>">
                      <img src="<?php echo htmlspecialchars(ltrim($im, '/')); ?>" class="w-full h-full object-cover thumb-image" />
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>

            <!-- Right: Details -->
            <div class="md:col-span-5 flex flex-col">
              <p class="text-xs uppercase tracking-[0.3em] text-[var(--amber)] mb-3 font-semibold"><?php echo htmlspecialchars($product['tag'] ?: ''); ?></p>
              <h1 class="display text-4xl md:text-5xl text-[var(--forest-deep)] mb-4 leading-tight"><?php echo htmlspecialchars($product['title']); ?></h1>
              
              <div class="flex items-center gap-4 mb-6 flex-wrap">
                <div class="text-3xl font-display font-medium text-[var(--forest-deep)]">
                  $<?php echo htmlspecialchars($product['price'] ?: '0.00'); ?>
                </div>
                <div>
                  <?php if ($available): ?>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[var(--forest)]/10 text-[var(--forest)] px-3 py-1 text-xs font-semibold">
                      <span class="w-2 h-2 rounded-full bg-[var(--forest)] animate-pulse"></span>
                      <?php echo $product['stock']; ?> <?php echo htmlspecialchars($t['available']); ?>
                    </span>
                  <?php else: ?>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-500/10 text-red-500 px-3 py-1 text-xs font-semibold">
                      <span class="w-2 h-2 rounded-full bg-red-500"></span>
                      <?php echo htmlspecialchars($t['out_of_stock']); ?>
                    </span>
                  <?php endif; ?>
                </div>
              </div>

              <p class="text-[var(--forest)]/70 leading-relaxed mb-8 text-base border-t border-[var(--forest)]/10 pt-6">
                <?php echo nl2br(htmlspecialchars($product['desc'] ?: '')); ?>
              </p>

              <?php if ($available): ?>
              <!-- Direct order form -->
              <div class="bg-[var(--bone)] border border-[var(--forest)]/10 rounded-3xl p-6 mb-8">
                <h2 class="text-2xl font-semibold text-[var(--forest-deep)] mb-5">Commander ce produit</h2>
                <form id="product-order-form" class="space-y-4">
                  <div>
                    <label for="order-fullname" class="block text-sm font-medium text-[var(--forest-deep)] mb-2">Nom complet</label>
                    <input id="order-fullname" name="full_name" type="text" required class="w-full rounded-2xl border border-[var(--forest)]/10 bg-white/90 px-4 py-3 text-sm text-[var(--forest-deep)] focus:border-[var(--forest-deep)] focus:outline-none" placeholder="Nom complet" />
                  </div>
                  <div>
                    <label for="order-address" class="block text-sm font-medium text-[var(--forest-deep)] mb-2">Adresse</label>
                    <textarea id="order-address" name="address" required rows="3" class="w-full rounded-2xl border border-[var(--forest)]/10 bg-white/90 px-4 py-3 text-sm text-[var(--forest-deep)] focus:border-[var(--forest-deep)] focus:outline-none" placeholder="Adresse de livraison"></textarea>
                  </div>
                  <div>
                    <label for="order-phone" class="block text-sm font-medium text-[var(--forest-deep)] mb-2">Numéro de téléphone</label>
                    <input id="order-phone" name="phone" type="tel" required class="w-full rounded-2xl border border-[var(--forest)]/10 bg-white/90 px-4 py-3 text-sm text-[var(--forest-deep)] focus:border-[var(--forest-deep)] focus:outline-none" placeholder="+212 6 12 34 56 78" />
                  </div>
                  <div class="space-y-3">
                    <button id="product-order-button" type="button" class="w-full inline-flex items-center justify-center gap-2 bg-[#16A34A] text-[var(--cream)] rounded-2xl px-6 py-4 font-semibold transition-all hover:scale-[1.01] active:scale-[0.99] shadow-sm">Commander</button>
                    <div id="order-feedback" class="text-sm text-[var(--forest)]/80"></div>
                  </div>
                </form>
              </div>
              <?php else: ?>
              <div class="bg-[var(--bone)] border border-red-400/20 rounded-3xl p-6 mb-8">
                <p class="text-sm text-red-700">Produit en rupture de stock, commande impossible.</p>
              </div>
              <?php endif; ?>

              <!-- Cart Form controls -->
              <div class="flex flex-col gap-6 py-6 border-y border-[var(--forest)]/10 mb-8">
                <div class="flex flex-wrap items-center gap-4">
                  <!-- Custom minus/plus qty picker -->
                  <div class="flex items-center bg-[var(--bone)] rounded-2xl p-1.5 border border-[var(--forest)]/5 shadow-inner">
                    <button id="qty-minus" class="w-10 h-10 rounded-xl hover:bg-white/50 text-[var(--forest-deep)] flex items-center justify-center font-bold transition-all focus:outline-none" <?php echo !$available ? 'disabled' : ''; ?>>−</button>
                    <input id="qty-input" type="text" value="1" readonly class="w-10 text-center bg-transparent border-none focus:outline-none font-semibold text-sm text-[var(--forest-deep)]" />
                    <button id="qty-plus" class="w-10 h-10 rounded-xl hover:bg-white/50 text-[var(--forest-deep)] flex items-center justify-center font-bold transition-all focus:outline-none" <?php echo !$available ? 'disabled' : ''; ?>>+</button>
                  </div>

                  <button id="add-to-cart-btn" class="flex-1 group inline-flex items-center justify-center gap-2 bg-[var(--forest-deep)] text-[var(--cream)] rounded-2xl px-6 py-4 font-semibold hover:bg-[var(--forest)] transition-all hover:scale-[1.01] active:scale-[0.99] disabled:opacity-50 disabled:pointer-events-none" <?php echo !$available ? 'disabled' : ''; ?>>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 opacity-75"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect></svg>
                    <?php echo htmlspecialchars($t['add_to_cart']); ?>
                  </button>
                </div>
                
                <button id="buy-now-btn" class="w-full inline-flex items-center justify-center gap-2 bg-[#FF7A00] text-[var(--cream)] rounded-2xl px-6 py-4 font-semibold hover:bg-[#E06B00] transition-all hover:scale-[1.01] active:scale-[0.99] disabled:opacity-50 disabled:pointer-events-none shadow-sm" <?php echo !$available ? 'disabled' : ''; ?>>
                  <?php echo htmlspecialchars($t['buy_now']); ?>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                </button>
              </div>

              <!-- Sustainability fact highlights -->
              <div class="bg-white/40 border border-[var(--forest)]/5 rounded-3xl p-6 backdrop-blur shadow-sm">
                <h4 class="text-xs uppercase tracking-[0.2em] text-[var(--forest-deep)]/60 font-semibold mb-4"><?php echo htmlspecialchars($t['sustainability']); ?></h4>
                <ul class="space-y-4">
                  <li class="flex items-start gap-3 text-sm text-[var(--forest-deep)]/80">
                    <span class="w-6 h-6 rounded-lg bg-[var(--forest)]/5 text-[var(--forest)] flex items-center justify-center shrink-0 mt-0.5">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M14 9.536V7a4 4 0 0 1 4-4h1.5a.5.5 0 0 1 .5.5V5a4 4 0 0 1-4 4 4 4 0 0 0-4 4c0 2 1 3 1 5a5 5 0 0 1-1 3"></path><path d="M4 9a5 5 0 0 1 8 4 5 5 0 0 1-8-4"></path><path d="M5 21h14"></path></svg>
                    </span>
                    <span><?php echo htmlspecialchars($t['sustain1']); ?></span>
                  </li>
                  <li class="flex items-start gap-3 text-sm text-[var(--forest-deep)]/80">
                    <span class="w-6 h-6 rounded-lg bg-[var(--forest)]/5 text-[var(--forest)] flex items-center justify-center shrink-0 mt-0.5">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M7 19H4.815a1.83 1.83 0 0 1-1.57-.881 1.785 1.785 0 0 1-.004-1.784L7.196 9.5"></path><path d="M11 19h8.203a1.83 1.83 0 0 0 1.556-.89 1.784 1.784 0 0 0 0-1.775l-1.226-2.12"></path><path d="m14 16-3 3 3 3"></path><path d="M8.293 13.596 7.196 9.5 3.1 10.598"></path><path d="m9.344 5.811 1.093-1.892A1.83 1.83 0 0 1 11.985 3a1.784 1.784 0 0 1 1.546.888l3.943 6.843"></path><path d="m13.378 9.633 4.096 1.098 1.097-4.096"></path></svg>
                    </span>
                    <span><?php echo htmlspecialchars($t['sustain2']); ?></span>
                  </li>
                  <li class="flex items-start gap-3 text-sm text-[var(--forest-deep)]/80">
                    <span class="w-6 h-6 rounded-lg bg-[var(--forest)]/5 text-[var(--forest)] flex items-center justify-center shrink-0 mt-0.5">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"></path><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"></path></svg>
                    </span>
                    <span><?php echo htmlspecialchars($t['sustain3']); ?></span>
                  </li>
                </ul>
              </div>

              <div class="mt-4 text-[10px] text-[var(--forest)]/40 flex items-center justify-between px-2">
                <span><?php echo htmlspecialchars($t['category']); ?>: <?php echo htmlspecialchars($product['category_name'] ?: ''); ?></span>
                <span><?php echo $createdStr; ?></span>
              </div>
            </div>
          </div>

          <!-- Related products -->
          <?php if (!empty($related)): ?>
            <div class="mt-24 border-t border-[var(--forest)]/10 pt-16">
              <h3 class="display text-3xl text-[var(--forest-deep)] mb-8 font-medium"><?php echo htmlspecialchars($t['related_products']); ?></h3>
              <div id="related-grid" class="grid md:grid-cols-3 gap-6">
                <?php foreach ($related as $r): ?>
                  <a href="product.php?id=<?php echo $r['id']; ?>" class="product-card group relative rounded-3xl bg-white border border-[var(--forest)]/10 shadow-sm p-4 flex flex-col overflow-hidden transition-all duration-300 will-change-transform no-underline">
                    <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-[var(--bone)]">
                      <img src="<?php echo htmlspecialchars(ltrim($r['images'][0] ?? $r['img'], '/')); ?>" alt="<?php echo htmlspecialchars($r['title']); ?>" loading="lazy" class="w-full h-full object-cover transition-transform duration-[1200ms] group-hover:scale-110" />
                    </div>
                    <div class="pt-6 pb-2 px-2 flex-1 flex items-end justify-between gap-4">
                      <div class="flex-1">
                        <span class="text-[10px] uppercase tracking-[0.25em] text-[var(--forest)]/50 mb-2 block">
                          <?php echo htmlspecialchars($r['tag'] ?: ''); ?>
                        </span>
                        <h3 class="display text-2xl text-[var(--forest-deep)]">
                          <?php echo htmlspecialchars($r['title'] ?: ''); ?>
                        </h3>
                        <p class="mt-2 text-sm text-[var(--forest)]/65 leading-relaxed">
                          <?php echo htmlspecialchars($r['desc'] ?: ''); ?>
                        </p>
                      </div>
                      <div class="w-12 h-12 shrink-0 rounded-full bg-[var(--forest-deep)] text-[var(--cream)] flex items-center justify-center group-hover:bg-[var(--forest)] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                      </div>
                    </div>
                  </a>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

        </div>
      </section>
    </main>

    <!-- Footer -->
    <footer class="bg-[var(--forest-deep)] text-[var(--cream)]/70 py-12">
      <div class="container mx-auto px-6 max-w-7xl flex flex-wrap items-center justify-between gap-4 text-sm">
        <div class="font-display text-2xl text-[var(--cream)]">
          aqcha<span class="text-[var(--amber)]">.</span>
        </div>
        <p class="text-xs text-[var(--cream)]/50">
          <?php echo htmlspecialchars($t['footer_copy']); ?>
        </p>
        <div class="flex gap-5 text-xs uppercase tracking-[0.2em]">
          <a href="#" class="hover:text-[var(--amber)] transition"><?php echo htmlspecialchars($t['instagram']); ?></a>
          <a href="#" class="hover:text-[var(--amber)] transition"><?php echo htmlspecialchars($t['linkedin']); ?></a>
        </div>
      </div>
    </footer>
  </div>

  <!-- Hydration data scripts -->
  <script>
    window.__serverRenderedProduct = true;
    window.__productData = <?php echo json_encode($product, JSON_UNESCAPED_UNICODE); ?>;
    window.__relatedProductsData = <?php echo json_encode($related, JSON_UNESCAPED_UNICODE); ?>;
  </script>
  
  <script src="js/translations.js" defer></script>
  <script src="js/main.js" defer></script>
</body>
</html>
