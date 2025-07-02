<?php
$title = htmlspecialchars($ebook['title']) . ' - Bukoo';
include 'partials/header.php';
include 'partials/navbar.php';
?>

<div class="bg-light">
  <div class="container py-5">
    <div class="row">
      <div class="col-lg-4 text-center mb-4 mb-lg-0">
        <img src="assets/img/ebook/<?= htmlspecialchars($ebook['cover']) ?>" class="img-fluid rounded shadow-lg" alt="Cover <?= htmlspecialchars($ebook['title']) ?>" style="max-height: 500px;">
      </div>

      <div class="col-lg-8">
        <h1 class="display-5 fw-bold"><?= htmlspecialchars($ebook['title']) ?></h1>
        <p class="text-muted fs-4 mb-3">
          oleh <?= htmlspecialchars($ebook['author']) ?>
          <?php if (!empty($ebook['year'])): ?>
            (<?= htmlspecialchars($ebook['year']) ?>)
          <?php endif; ?>
        </p>

        <div class="mb-4">
          <span class="badge bg-primary p-2 fs-6 me-2"><?= htmlspecialchars($ebook['category']) ?></span>
          <?php if ($ebook['status'] === 'Verified'): ?>
            <span class="text-success fw-bold"><i class="bi bi-patch-check-fill"></i> Terverifikasi</span>
          <?php endif; ?>
        </div>

        <h4 class="fw-bold">Tentang Buku Ini</h4>
        <p class="text-secondary" style="text-align: justify;">
          <?= nl2br(htmlspecialchars($ebook['description'] ?? 'Tidak ada deskripsi untuk buku ini. Silakan tambahkan deskripsi melalui halaman update.')) ?>
        </p>

        <hr class="my-4">

        <div class="card border-0">
          <div class="card-body p-0">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
              <div class="mb-3 mb-sm-0">
                <?php if (($ebook['price'] ?? 0) > 0): ?>
                  <span class="fs-2 fw-bold text-danger">Rp <?= number_format($ebook['price']) ?></span>
                <?php else: ?>
                  <span class="fs-2 fw-bold text-success">Gratis</span>
                <?php endif; ?>
              </div>
              <div class="d-grid gap-2 d-sm-flex">
                <?php if (($ebook['price'] ?? 0) > 0): ?>
                  <button class="btn btn-outline-primary btn-lg fw-semibold add-to-cart-btn" data-id="<?= $ebook['id'] ?>">
                    <i class="bi bi-cart-plus-fill me-2"></i>Keranjang
                  </button>
                  <button class="btn btn-primary btn-lg fw-semibold buy-now-btn" data-id="<?= $ebook['id'] ?>">
                    <i class="bi bi-lightning-charge-fill me-2"></i>Beli Sekarang
                  </button>
                <?php else: ?>
                  <a href="<?= htmlspecialchars($ebook['link']) ?>" target="_blank" class="btn btn-success btn-lg fw-semibold">
                    <i class="bi bi-cloud-arrow-down-fill me-1"></i> Unduh Gratis
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
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