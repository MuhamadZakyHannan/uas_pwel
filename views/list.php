<?php
$title = 'List eBook - eBook Apps';
include 'partials/header.php';
include 'partials/navbar.php';
?>

<main class="container my-4" id="content">
  <h1 class="fs-3 mb-4">Total eBooks: <?= $totalEbook ?></h1>
  <?php if ($totalEbook === 0): ?>
    <div class="not-found d-flex flex-column justify-content-center align-items-center" style="min-height: 50vh;">
      <i class="bi bi-search display-1"></i>
      <h2 class="my-4">Oops! Tidak ada buku yang ditemukan.</h2>
    </div>
  <?php else: ?>
    <div class="list-ebook">
      <div class="row row-cols-1 row-cols-lg-2 g-4">
        <?php foreach ($ebooks as $ebook): ?>
          <div class="col">
            <?php if (isset($_SESSION['username']) && $_SESSION['role'] === 'admin'): ?>
              <div class="text-end mb-1">
                <div class="btn-group" role="group">
                  <a class="btn btn-sm btn-outline-success" href="index.php?action=edit&id=<?= $ebook['id'] ?>">Update</a>
                  <a class="btn btn-sm btn-outline-danger" href="index.php?action=delete&id=<?= $ebook['id'] ?>" onclick="deleteEbook(event)">Delete</a>
                </div>
              </div>
            <?php endif; ?>
            <div class="card shadow-sm h-100">
              <div class="row g-0">
                <div class="col-md-4 text-center p-3">
                  <a href="index.php?action=detail&id=<?= $ebook['id'] ?>">
                    <img class="img-fluid rounded" src="assets/img/ebook/<?= htmlspecialchars($ebook['cover']) ?>" alt="Cover <?= htmlspecialchars($ebook['title']) ?>" style="max-height: 260px;">
                  </a>
                </div>
                <div class="col-md-8 d-flex flex-column">
                  <div class="card-body pb-0">
                    <h5 class="card-title fw-bold">
                      <a class="text-dark text-decoration-none" href="index.php?action=detail&id=<?= $ebook['id'] ?>">
                        <?= htmlspecialchars($ebook['title']) ?>
                      </a>
                    </h5>
                    <p class="card-text text-muted mb-2">
                      by <?= htmlspecialchars($ebook['author']) ?>
                      <?php if (!empty($ebook['year'])): ?>
                        <span class="text-muted">(<?= htmlspecialchars($ebook['year']) ?>)</span>
                      <?php endif; ?>
                    </p>
                  </div>

                  <div class="mt-auto">
                    <ul class="list-group list-group-flush mx-2">
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Kategori:</strong>
                        <span class="badge bg-secondary"><?= htmlspecialchars($ebook['category']) ?></span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Status:</strong>
                        <?php if ($ebook['status'] === 'Verified'): ?>
                          <span class="text-primary fw-bold"><i class="bi bi-patch-check-fill"></i> Verified</span>
                        <?php else: ?>
                          <span class="text-danger fw-bold"><i class="bi bi-patch-exclamation-fill"></i> Unverified</span>
                        <?php endif; ?>
                      </li>
                      <li class="list-group-item text-center bg-light">
                        <?php if (($ebook['price'] ?? 0) > 0): ?>
                          <button class="btn btn-info fw-semibold w-100 buy-now-btn"
                            data-id="<?= $ebook['id'] ?>"
                            data-title="<?= htmlspecialchars($ebook['title']) ?>"
                            data-price="<?= $ebook['price'] ?>">
                            <i class="bi bi-cart-check-fill me-1"></i> Beli (Rp <?= number_format($ebook['price']) ?>)
                          </button>
                        <?php else: ?>
                          <a href="<?= htmlspecialchars($ebook['link']) ?>" target="_blank" class="btn btn-success fw-semibold w-100">
                            <i class="bi bi-cloud-arrow-down-fill me-1"></i> Unduh Gratis
                          </a>
                        <?php endif; ?>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

  <?php if ($totalEbook > 0 && $totalPage > 1): ?>
    <nav class="my-5">
      <ul class="pagination justify-content-center">
        <li class="page-item <?= $activePage <= 1 ? 'disabled' : '' ?>">
          <a class="page-link" href="?action=<?= isset($keyword) ? 'search' : 'list' ?>&page=<?= $activePage - 1 ?><?= isset($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">Previous</a>
        </li>
        <?php for ($page = 1; $page <= $totalPage; $page++): ?>
          <li class="page-item <?= $page == $activePage ? 'active' : '' ?>" aria-current="page">
            <a class="page-link" href="?action=<?= isset($keyword) ? 'search' : 'list' ?>&page=<?= $page ?><?= isset($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>"><?= $page ?></a>
          </li>
        <?php endfor; ?>
        <li class="page-item <?= $activePage >= $totalPage ? 'disabled' : '' ?>">
          <a class="page-link" href="?action=<?= isset($keyword) ? 'search' : 'list' ?>&page=<?= $activePage + 1 ?><?= isset($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">Next</a>
        </li>
      </ul>
    </nav>
  <?php endif; ?>
</main>
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