<?php if ($totalEbook === 0): ?>
  <div class="not-found text-center py-5">
    <i class="bi bi-emoji-frown display-1 text-muted"></i>
    <h2 class="my-4">Oops! Tidak Ada Buku yang Ditemukan</h2>
  </div>
<?php else: ?>
  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
    <?php foreach ($ebooks as $ebook): ?>
      <div class="col">
        <div class="card ebook-card h-100 shadow-sm">
          <?php if (isset($_SESSION['username']) && $_SESSION['role'] === 'admin'): ?>
            <div class="admin-actions">
              <a class="btn btn-sm btn-outline-primary" href="index.php?action=edit&id=<?= $ebook['id'] ?>"><i class="bi bi-pencil-fill"></i></a>
              <a class="btn btn-sm btn-outline-danger" href="index.php?action=delete&id=<?= $ebook['id'] ?>" onclick="deleteEbook(event)"><i class="bi bi-trash-fill"></i></a>
            </div>
          <?php endif; ?>

          <img src="assets/img/ebook/<?= htmlspecialchars($ebook['cover']) ?>" class="card-img-top" alt="Cover <?= htmlspecialchars($ebook['title']) ?>">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title fw-bold line-clamp">
              <a href="<?= ($ebook['price'] ?? 0) > 0 ? '#' : htmlspecialchars($ebook['link']) ?>"
                target="<?= ($ebook['price'] ?? 0) > 0 ? '_self' : '_blank' ?>"
                class="text-dark text-decoration-none">
                <?= htmlspecialchars($ebook['title']) ?>
              </a>
            </h5>
            <p class="card-text text-muted small mb-2">by <?= htmlspecialchars($ebook['author']) ?></p>
            <span class="badge bg-light text-dark mb-3 align-self-start"><?= htmlspecialchars($ebook['category']) ?></span>

            <div class="mt-auto d-flex justify-content-between align-items-center">
              <div>
                <?php if ($ebook['status'] === 'Verified'): ?>
                  <small class="text-primary"><i class="bi bi-patch-check-fill me-1"></i>Verified</small>
                <?php endif; ?>
              </div>
              <div>
                <?php if (($ebook['price'] ?? 0) > 0): ?>
                  <button class="btn btn-sm btn-info fw-semibold buy-now-btn"
                    data-id="<?= $ebook['id'] ?>"
                    data-title="<?= htmlspecialchars($ebook['title']) ?>"
                    data-price="<?= $ebook['price'] ?>">
                    <i class="bi bi-cart-check-fill me-1"></i> Beli Rp <?= number_format($ebook['price']) ?>
                  </button>
                <?php else: ?>
                  <a href="<?= htmlspecialchars($ebook['link']) ?>" target="_blank" class="btn btn-sm btn-success fw-semibold">
                    <i class="bi bi-cloud-arrow-down-fill me-1"></i> Gratis
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php if ($totalEbook > 0 && $totalPage > 1): ?>
  <nav class="mt-5" aria-label="Page navigation">
    <ul class="pagination justify-content-center">
      <li class="page-item <?= $activePage <= 1 ? 'disabled' : '' ?>">
        <a class="page-link" href="?action=<?= isset($keyword) ? 'search' : 'list' ?>&page=<?= $activePage - 1 ?><?= isset($keyword) ? '&keyword=' . $keyword : '' ?>">Previous</a>
      </li>
      <?php for ($page = 1; $page <= $totalPage; $page++): ?>
        <li class="page-item <?= $page == $activePage ? 'active' : '' ?>">
          <a class="page-link" href="?action=<?= isset($keyword) ? 'search' : 'list' ?>&page=<?= $page ?><?= isset($keyword) ? '&keyword=' . $keyword : '' ?>"><?= $page ?></a>
        </li>
      <?php endfor; ?>
      <li class="page-item <?= $activePage >= $totalPage ? 'disabled' : '' ?>">
        <a class="page-link" href="?action=<?= isset($keyword) ? 'search' : 'list' ?>&page=<?= $activePage + 1 ?><?= isset($keyword) ? '&keyword=' . $keyword : '' ?>">Next</a>
      </li>
    </ul>
  </nav>
<?php endif; ?>