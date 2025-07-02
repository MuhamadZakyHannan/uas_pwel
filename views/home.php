<?php
$title = 'Home - Bukoo eBook Apps';
// Hapus class body yang tidak perlu, karena akan di-handle oleh CSS
include 'partials/header.php';
// Panggil navbar terpusat yang sudah kita buat
include 'partials/navbar.php';
?>

<section class="home-hero text-center text-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 fade-in-up">
        <h1 class="display-3 fw-bold mb-4">
          Selamat Datang di <span class="text-info">Bukoo</span>
        </h1>
        <p class="lead mb-5">
          Temukan ribuan buku digital di ujung jari Anda. Baca, belajar, dan jelajahi dari mana saja dengan platform eBook modern kami.
        </p>
        <?php if (!isset($_SESSION['username'])): ?>
          <div>
            <a class="btn btn-info btn-lg fw-semibold me-3 btn-pulse" href="index.php?action=signup">
              <i class="bi bi-rocket-takeoff-fill me-2"></i>Mulai Sekarang
            </a>
            <a class="btn btn-outline-light btn-lg fw-semibold" href="index.php?action=list">
              <i class="bi bi-book me-2"></i>Lihat Koleksi
            </a>
          </div>
        <?php else: ?>
          <div>
            <a class="btn btn-info btn-lg fw-semibold me-3" href="index.php?action=list">
              <i class="bi bi-book-half me-2"></i>Lihat Koleksi
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<section class="features-section py-5 bg-light">
  <div class="container py-5">
    <div class="row text-center mb-5">
      <div class="col-lg-8 mx-auto">
        <h2 class="display-5 fw-bold mb-4">Kenapa Memilih Bukoo?</h2>
        <p class="lead text-muted">Rasakan masa depan membaca digital dengan fitur-fitur canggih kami.</p>
      </div>
    </div>
    <div class="row g-4">
      <div class="col-lg-4 col-md-6">
        <div class="card feature-card h-100 text-center p-4">
          <div class="feature-icon-bg bg-primary mx-auto mb-3">
            <i class="bi bi-phone-fill fs-2"></i>
          </div>
          <h4 class="fw-bold mb-3">Mobile Friendly</h4>
          <p class="text-muted">Akses perpustakaan Anda dari perangkat apa pun. Pengalaman membaca yang mulus di semua platform.</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="card feature-card h-100 text-center p-4">
          <div class="feature-icon-bg bg-success mx-auto mb-3">
            <i class="bi bi-search-heart-fill fs-2"></i>
          </div>
          <h4 class="fw-bold mb-3">Penemuan Mudah</h4>
          <p class="text-muted">Temukan buku favorit Anda berikutnya dengan sistem kami.</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="card feature-card h-100 text-center p-4">
          <div class="feature-icon-bg bg-info mx-auto mb-3">
            <i class="bi bi-cloud-arrow-down-fill fs-2"></i>
          </div>
          <h4 class="fw-bold mb-3">Koleksi Lengkap</h4>
          <p class="text-muted">Temukan ribuan buku dari berbagai kategori seperti fiksi, non-fiksi, pendidikan, dan banyak lagi. Semua tersedia dalam satu tempat untuk pengalaman membaca terbaik Anda.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if (!isset($_SESSION['username'])): ?>
  <section class="cta-section py-5 text-white">
    <div class="container text-center py-5">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <h2 class="display-5 fw-bold mb-4">Siap untuk Memulai?</h2>
          <p class="lead mb-5">Bergabunglah dengan ribuan pembaca yang telah menemukan buku favorit mereka berikutnya bersama Bukoo.</p>
          <a class="btn btn-info btn-lg fw-semibold btn-pulse" href="index.php?action=signup">
            <i class="bi bi-person-plus-fill me-2"></i>Buat Akun Gratis
          </a>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<footer class="home-footer py-5 bg-dark text-white">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 mb-4">
        <h5 class="fw-bold text-info mb-3">Bukoo</h5>
        <p class="text-white-50">Gerbang Anda menuju dunia buku digital. Baca, belajar, dan jelajahi dengan platform eBook modern kami.</p>
      </div>
      <div class="col-lg-2 col-md-6 mb-4">
        <h6 class="fw-bold mb-3">Tautan</h6>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="index.php?action=home" class="text-white-50 text-decoration-none">Home</a></li>
          <li class="mb-2"><a href="index.php?action=list" class="text-white-50 text-decoration-none">Koleksi</a></li>
          <?php if (isset($_SESSION['username'])): ?>
            <li class="mb-2"><a href="index.php?action=create" class="text-white-50 text-decoration-none">Tambah Buku</a></li>
          <?php else: ?>
            <li class="mb-2"><a href="index.php?action=login" class="text-white-50 text-decoration-none">Sign In</a></li>
          <?php endif; ?>
        </ul>
      </div>
      <div class="col-lg-2 col-md-6 mb-4">
        <h6 class="fw-bold mb-3">Legal</h6>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Terms of Use</a></li>
          <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Privacy Policy</a></li>
        </ul>
      </div>
      <div class="col-lg-4 mb-4">
        <h6 class="fw-bold mb-3">Hubungi Kami</h6>
        <p class="text-white-50 mb-2"><i class="bi bi-envelope-fill me-2"></i>support@bukoo.com</p>
        <p class="text-white-50 mb-0"><i class="bi bi-geo-alt-fill me-2"></i>Depok, Yogyakarta, Indonesia</p>
      </div>
    </div>
    <hr class="border-secondary my-4">
    <div class="row align-items-center">
      <div class="col-md-6">
        <p class="text-white-50 mb-0">&copy; <?= date('Y') ?> Bukoo. All rights reserved.</p>
      </div>
      <div class="col-md-6 text-md-end social-links">
        <a href="#" class="text-white-50 text-decoration-none me-3"><i class="bi bi-facebook fs-5"></i></a>
        <a href="#" class="text-white-50 text-decoration-none me-3"><i class="bi bi-twitter fs-5"></i></a>
        <a href="#" class="text-white-50 text-decoration-none"><i class="bi bi-instagram fs-5"></i></a>
      </div>
    </div>
  </div>
</footer>

<?php include 'partials/footer.php'; ?>