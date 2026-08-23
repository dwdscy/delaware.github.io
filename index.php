<?php
$services = [
    'graphic-design' => [
        'title' => 'graphic design',
        'items' => [
            'brand identity &amp; logos',
            'posters &amp; print',
            'social media graphics',
            'clothing graphic design',
        ],
        'images' => true,
    ],
    '3d-printing' => [
        'title' => '3d printing',
        'warning' => 'region limited to romania',
        'items' => [
            'custom prints &amp; prototypes',
            'functional parts',
            'figurines &amp; art objects',
        ],
    ],
    'video-editing' => [
        'title' => 'video editing',
        'items' => [
            'short-form &amp; reels',
            'youtube videos',
            'vod recaps',
        ],
        'videos' => [
            ['id' => 'GwoWQQ7DMCo', 'title' => 'video example 1'],
            ['id' => 'Ax9Mfp6j3d4', 'title' => 'video example 2'],
        ],
    ],
];

$galleryDir = __DIR__ . '/images';
$galleryImages = [];
if (is_dir($galleryDir)) {
    $files = scandir($galleryDir);
    foreach ($files as $file) {
        if (preg_match('/\.(png|jpe?g|gif|webp)$/i', $file)) {
            $galleryImages[] = 'images/' . $file;
        }
    }
    sort($galleryImages);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@gab._.fry</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <div class="lightbox" id="lightbox">
    <span class="lightbox-prev" onclick="prevImage()">&#8592;</span>
    <img src="" alt="preview" id="lightbox-img">
    <div class="lightbox-right">
      <span class="lightbox-close" onclick="closeLightbox()">close</span>
      <span class="lightbox-next" onclick="nextImage()">&#8594;</span>
    </div>
  </div>

  <aside class="location-aside">
    <p>delaware</p>
  </aside>

  <aside class="quote-aside">
    <p>"you're given a chance<br>to get closer to the creator,<br>what would you do for it"</p>
  </aside>

  <div class="main">
    <div class="content">

      <?php foreach ($services as $id => $service): ?>
      <section class="service-section" id="<?= $id ?>">
        <div class="service-header" onclick="toggleService(this)">
          <h2><?= $service['title'] ?></h2>
          <span class="toggle">+</span>
        </div>
        <div class="service-body">
          <div class="service-body-inner">
            <?php if (!empty($service['warning'])): ?>
              <p class="service-warning"><?= $service['warning'] ?></p>
            <?php endif; ?>
            <ul>
              <?php foreach ($service['items'] as $item): ?>
                <li><?= $item ?></li>
              <?php endforeach; ?>
            </ul>
            <?php if (!empty($service['images']) && !empty($galleryImages)): ?>
              <div class="service-images">
                <?php foreach ($galleryImages as $img): ?>
                  <img src="<?= $img ?>" alt="graphic design work">
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            <?php if (!empty($service['videos'])): ?>
              <div class="service-images">
                <?php foreach ($service['videos'] as $video): ?>
                  <a href="https://www.youtube.com/watch?v=<?= $video['id'] ?>" target="_blank" rel="noopener">
                    <img src="https://img.youtube.com/vi/<?= $video['id'] ?>/0.jpg" alt="<?= $video['title'] ?>">
                  </a>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            <?php if (empty($service['images']) && empty($service['videos'])): ?>
              <div class="image-placeholder">image examples coming soon</div>
            <?php endif; ?>
          </div>
        </div>
      </section>
      <?php endforeach; ?>

      <footer class="footer">
        <span>contact</span>
        <span><a href="https://instagram.com/gab._.fry" target="_blank" rel="noopener">@gab._.fry</a></span>
      </footer>

    </div>
  </div>

  <script>
    function toggleService(header) {
      const body = header.nextElementSibling;
      const isOpen = header.classList.contains('open');

      document.querySelectorAll('.service-header').forEach(h => {
        h.classList.remove('open');
        h.nextElementSibling.style.maxHeight = null;
      });

      if (!isOpen) {
        header.classList.add('open');
        body.style.maxHeight = body.scrollHeight + 'px';
      }
    }

    let currentImageIndex = 0;
    const galleryImages = [];

    document.querySelectorAll('.service-images img').forEach((img, i) => {
      if (img.parentElement.tagName === 'A') return;
      img.onload = () => img.classList.add('loaded');
      img.onerror = () => img.style.display = 'none';
      img.addEventListener('click', () => {
        currentImageIndex = i;
        openLightbox(img.src);
      });
      galleryImages.push(img);
    });

    function openLightbox(src) {
      document.getElementById('lightbox-img').src = src;
      document.getElementById('lightbox').classList.add('open');
    }

    function closeLightbox() {
      document.getElementById('lightbox').classList.remove('open');
    }

    function prevImage() {
      let index = currentImageIndex;
      do {
        index = (index - 1 + galleryImages.length) % galleryImages.length;
      } while (!galleryImages[index].classList.contains('loaded') && index !== currentImageIndex);
      currentImageIndex = index;
      updateLightbox();
    }

    function nextImage() {
      let index = currentImageIndex;
      do {
        index = (index + 1) % galleryImages.length;
      } while (!galleryImages[index].classList.contains('loaded') && index !== currentImageIndex);
      currentImageIndex = index;
      updateLightbox();
    }

    function updateLightbox() {
      const img = galleryImages[currentImageIndex];
      if (img && img.classList.contains('loaded')) {
        document.getElementById('lightbox-img').src = img.src;
      }
    }

    document.getElementById('lightbox').addEventListener('click', (e) => {
      if (e.target === e.currentTarget) closeLightbox();
    });
  </script>

</body>
</html>
