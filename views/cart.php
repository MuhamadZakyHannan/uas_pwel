<?php
$title = 'Keranjang Belanja - Bukoo';
include 'partials/header.php';
include 'partials/navbar.php';
?>

<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="display-5 fw-bold mb-0">Keranjang Belanja</h1>
    <?php if (!empty($cart_items)): ?>
      <a href="index.php?action=clearCart" class="btn btn-outline-danger">
        <i class="bi bi-trash-fill me-2"></i>Kosongkan Keranjang
      </a>
    <?php endif; ?>
  </div>

  <?php if (empty($cart_items)): ?>
    <div class="text-center py-5">
      <h3 class="mt-4">Keranjang Anda kosong.</h3>
      <a href="index.php?action=list" class="btn btn-primary mt-3">Mulai Belanja</a>
    </div>
  <?php else: ?>
    <div class="row">
      <div class="col-lg-8" id="cart-items-container">
        <?php foreach ($cart_items as $item): ?>
          <div class="card mb-3 cart-item-row" data-item-id="<?= $item['id'] ?>">
            <div class="row g-0">
              <div class="col-md-2 text-center p-2">
                <img src="assets/img/ebook/<?= htmlspecialchars($item['cover']) ?>" class="img-fluid rounded">
              </div>
              <div class="col-md-6 card-body">
                <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
                <p class="card-text text-muted">Rp <?= number_format($item['price']) ?> / item</p>
              </div>
              <div class="col-md-4 d-flex align-items-center p-2">
                <input type="number" class="form-control form-control-sm cart-quantity-input"
                  value="<?= $item['quantity'] ?>" min="0"
                  data-id="<?= $item['id'] ?>" style="width: 80px;">
                <a href="index.php?action=remove_from_cart&id=<?= $item['id'] ?>" class="btn btn-sm btn-link text-danger ms-2" title="Hapus"><i class="bi bi-trash-fill fs-5"></i></a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Ringkasan Pesanan</h5>
          </div>
          <div class="card-body">
            <li class="list-group-item d-flex justify-content-between fw-bold">
              <span>Total Harga</span>
              <span id="total-price-display">Rp <?= number_format($total_price) ?></span>
            </li>
          </div>
          <div class="card-footer p-3">
            <button class="btn btn-lg btn-success w-100 fw-semibold" id="checkout-btn">
              Bayar Sekarang
            </button>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
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