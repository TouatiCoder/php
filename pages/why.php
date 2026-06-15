<?php
// pages/why.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AQCHA — Why Us</title>
  <link rel="stylesheet" href="../css/react-build.css">
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
  <div id="app" data-page="why"></div>

  <!-- Pourquoi Nous Section -->
  <link rel="stylesheet" href="../assets/css/why.css">
  <?php
  $slides = [
      [
          'image' => '../assets/images/1.jpeg',
          'title' => 'Expertise',
          'description' => 'Des années d\'expérience à votre service.'
      ],
      [
          'image' => '../assets/images/2.jpeg',
          'title' => 'Qualité',
          'description' => 'Des matériaux et un rendu exceptionnels.'
      ],
      [
          'image' => '../assets/images/3.jpeg',
          'title' => 'Innovation',
          'description' => 'Toujours à la pointe de la technologie.'
      ],
      [
          'image' => '../assets/images/4.jpeg',
          'title' => 'Engagement',
          'description' => 'Une équipe dédiée à votre réussite.'
      ],
      [
          'image' => '../assets/images/5.jpeg',
          'title' => 'Durabilité',
          'description' => 'Des solutions pensées pour l\'avenir.'
      ],
  
  [
          'image' => '../assets/images/6.jpeg',
          'title' => 'Engagement',
          'description' => 'Une équipe dédiée à votre réussite.'
      ],
      [
          'image' => '../assets/images/7.jpeg',
          'title' => 'Durabilité',
          'description' => 'Des solutions pensées pour l\'avenir.'
            ],
      [
          'image' => '../assets/images/8.jpeg',
          'title' => 'Engagement',
          'description' => 'Une équipe dédiée à votre réussite.'
            ],
      [
          'image' => '../assets/images/9.jpeg',
          'title' => 'Engagement',
          'description' => 'Une équipe dédiée à votre réussite.'
      ],
      [
          'image' => '../assets/images/10.jpeg',
          'title' => 'Engagement',
          'description' => 'Une équipe dédiée à votre réussite.'
            ],
      [
          'image' => '../assets/images/11.jpeg',
          'title' => 'Engagement',
          'description' => 'Une équipe dédiée à votre réussite.'
      ],
      [
          'image' => '../assets/images/12.jpeg',
          'title' => 'Engagement',
          'description' => 'Une équipe dédiée à votre réussite.'
      ]

  ];
  ?>

  <section class="why-section">
      <div class="why-container">
          <div class="text-center mb-5">
              <h2 class="why-title">POURQUOI NOUS ?</h2>
              <p class="why-subtitle">Découvrez ce qui nous rend uniques et pourquoi vous devriez nous choisir.</p>
          </div>

          <div class="why-carousel-wrapper" id="whyCarousel">
              <div class="why-carousel-container">
                  <?php foreach ($slides as $index => $slide): ?>
                      <div class="why-carousel-slide" data-index="<?= $index ?>">
                          <img src="<?= htmlspecialchars($slide['image']) ?>" alt="<?= htmlspecialchars($slide['title']) ?>" onerror="this.src='https://via.placeholder.com/600x400.jpeg?text=Image+<?= $index+1 ?>'">
                          <div class="why-card-content text-center">
                              <h5><?= htmlspecialchars($slide['title']) ?></h5>
                              <p><?= htmlspecialchars($slide['description']) ?></p>
                          </div>
                      </div>
                  <?php endforeach; ?>
              </div>

              <button type="button" class="why-carousel-btn why-prev-btn" aria-label="Précédent">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
              </button>
              <button type="button" class="why-carousel-btn why-next-btn" aria-label="Suivant">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
              </button>
              
              <div class="why-carousel-pagination">
                  <?php foreach ($slides as $index => $slide): ?>
                      <button type="button" class="why-dot <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>" aria-label="Aller au slide <?= $index + 1 ?>"></button>
                  <?php endforeach; ?>
              </div>
          </div>
      </div>
  </section>

  <script src="../assets/js/why.js"></script>
  <script src="../js/translations.js" defer></script>
  <script src="../js/main.js" defer></script>
</body>
</html>