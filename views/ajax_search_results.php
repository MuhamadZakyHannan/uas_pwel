<?php if ($totalEbook === 0): ?>
  <div class="not-found d-flex flex-column justify-content-center align-items-center" style="min-height: 50vh;">
    <i class="bi bi-search display-1"></i>
    <h2 class="my-4">Oops! Tidak ada buku yang cocok dengan "<?= htmlspecialchars($keyword) ?>".</h2>
  </div>
<?php else: ?>
  <div class="list-ebook">
    <div class="row row-cols-1 row-cols-lg-2 g-4">
      <?php foreach ($ebooks as $ebook): ?>
        <div class="col d-flex">
          <div class="card shadow-sm h-100 w-100">

            <?php if (isset($_SESSION['username']) && $_SESSION['role'] === 'admin'): ?>
              <div class="card-header bg-transparent border-0 text-end py-2 px-3">
                <div class="btn-group" role="group">
                  <a class="btn btn-sm btn-outline-success" href="index.php?action=edit&id=<?= $ebook['id'] ?>">Update</a>
                  <a class="btn btn-sm btn-outline-danger" href="index.php?action=delete&id=<?= $ebook['id'] ?>" onclick="deleteEbook(event)">Hapus</a>
                </div>
              </div>
            <?php endif; ?>

            <div class="row g-0">
              <div class="col-md-4 text-center p-3">
                <a href="index.php?action=detail&id=<?= $ebook['id'] ?>">
                  <img class="img-fluid rounded" src="assets/img/ebook/<?= htmlspecialchars($ebook['cover']) ?>" alt="Cover <?= htmlspecialchars($ebook['title']) ?>" style="max-height: 260px;">
                </a>
              </div>
              <div class="col-md-8 d-flex flex-column">
                <div class="card-body pb-0">
                  <h5 class="card-title fw-bold">
                    <a class="text-dark text-decoration-none" href="index.php?action=detail&id=<?= $ebook['id'] ?>"><?= htmlspecialchars($ebook['title']) ?></a>
                  </h5>
                  <p class="card-text text-muted mb-2">by <?= htmlspecialchars($ebook['author']) ?><?php if (!empty($ebook['year'])): ?> (<?= htmlspecialchars($ebook['year']) ?>)<?php endif; ?></p>
                </div>
                <div class="mt-auto">
                  <ul class="list-group list-group-flush mx-2">
                    <li class="list-group-item d-flex justify-content-between align-items-center"><strong>Kategori:</strong><span class="badge bg-secondary"><?= htmlspecialchars($ebook['category']) ?></span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"><strong>Status:</strong><?php if ($ebook['status'] === 'Verified'): ?><span class="text-primary fw-bold"><i class="bi bi-patch-check-fill"></i> Verified</span><?php else: ?><span class="text-danger fw-bold"><i class="bi bi-patch-exclamation-fill"></i> Unverified</span><?php endif; ?></li>
                    <li class="list-group-item text-center bg-light"><?php if (($ebook['price'] ?? 0) > 0): ?><button class="btn btn-info fw-semibold w-100 buy-now-btn" data-id="<?= $ebook['id'] ?>" data-title="<?= htmlspecialchars($ebook['title']) ?>" data-price="<?= $ebook['price'] ?>"><i class="bi bi-cart-check-fill me-1"></i> Beli (Rp <?= number_format($ebook['price']) ?>)</button><?php else: ?><a href="<?= htmlspecialchars($ebook['link']) ?>" target="_blank" class="btn btn-success fw-semibold w-100"><i class="bi bi-cloud-arrow-down-fill me-1"></i> Gratis</a><?php endif; ?></li>
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
        <a class="page-link" href="?action=search&keyword=<?= urlencode($keyword) ?>&page=<?= $activePage - 1 ?>">Previous</a>
      </li>
      <?php for ($page = 1; $page <= $totalPage; $page++): ?>
        <li class="page-item <?= $page == $activePage ? 'active' : '' ?>">
          <a class="page-link" href="?action=search&keyword=<?= urlencode($keyword) ?>&page=<?= $page ?>"><?= $page ?></a>
        </li>
      <?php endfor; ?>
      <li class="page-item <?= $activePage >= $totalPage ? 'disabled' : '' ?>">
        <a class="page-link" href="?action=search&keyword=<?= urlencode($keyword) ?>&page=<?= $activePage + 1 ?>">Next</a>
      </li>
    </ul>
  </nav>
<?php endif; ?>