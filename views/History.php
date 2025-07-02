<?php
$title = 'Riwayat Transaksi - Bukoo';
include 'partials/header.php';
include 'partials/navbar.php';
?>

<div class="container my-5">
  <div class="text-center mb-5">
    <h1 class="display-5 fw-bold">Riwayat Transaksi</h1>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
      <p class="lead text-muted">Menampilkan semua transaksi dari seluruh pengguna.</p>
    <?php endif; ?>
  </div>

  <?php if (empty($transactions)): ?>
    <div class="text-center py-5">
      <h3 class="mt-4">Belum ada riwayat transaksi.</h3>
    </div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>Order ID</th>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
              <th>Pembeli</th>
            <?php endif; ?>
            <th>Detail</th>
            <th>Total</th>
            <th>Waktu Transaksi</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($transactions as $trx): ?>
            <tr>
              <td><code><?= htmlspecialchars($trx['order_id']) ?></code></td>
              <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <td><?= htmlspecialchars($trx['username']) ?></td>
              <?php endif; ?>
              <td>
                <?php
                $details = json_decode($trx['ebook_details'], true);
                if (is_array($details)) {
                  foreach ($details as $item) {
                    echo '<div>' . htmlspecialchars($item['name']) . ' (x' . $item['quantity'] . ')</div>';
                  }
                }
                ?>
              </td>
              <td>Rp <?= number_format($trx['gross_amount']) ?></td>
              <td><?= $trx['transaction_time'] ? date('d M Y, H:i', strtotime($trx['transaction_time'])) : 'N/A' ?></td>
              <td>
                <?php
                $status = $trx['transaction_status'];
                $badge_class = 'bg-secondary';
                if ($status == 'settlement' || $status == 'capture') $badge_class = 'bg-success';
                if ($status == 'pending') $badge_class = 'bg-warning text-dark';
                if ($status == 'expire' || $status == 'cancel' || $status == 'deny') $badge_class = 'bg-danger';
                ?>
                <span class="badge <?= $badge_class ?> p-2"><?= ucfirst($status ?? 'Pending') ?></span>
              </td>
              <td>
                <a href="index.php?action=invoice&order_id=<?= $trx['order_id'] ?>" class="btn btn-sm btn-primary">Lihat Invoice</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
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