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

<?php include 'partials/footer.php'; ?>