<?php
$title = 'Invoice ' . htmlspecialchars($transaction['order_id']);
include 'partials/header.php';
include 'partials/navbar.php';

$ebook_details = json_decode($transaction['ebook_details'], true);
?>

<div class="container my-5">
  <div class="card shadow-lg">
    <div class="card-header bg-dark text-white p-4">
      <h2 class="mb-0">Invoice / Detail Transaksi</h2>
      <p class="mb-0">Order ID: <strong><?= htmlspecialchars($transaction['order_id']) ?></strong></p>
    </div>
    <div class="card-body p-4">
      <div class="row mb-4">
        <div class="col-md-6">
          <strong>Tanggal Transaksi:</strong>
          <p><?= $transaction['transaction_time'] ? date('d F Y, H:i', strtotime($transaction['transaction_time'])) : 'N/A' ?></p>
        </div>
        <div class="col-md-6 text-md-end">
          <strong>Status Pembayaran:</strong>
          <p>
            <?php
            $status = $transaction['transaction_status'];
            $badge_class = 'bg-secondary';
            if ($status == 'settlement' || $status == 'capture') $badge_class = 'bg-success';
            if ($status == 'pending') $badge_class = 'bg-warning text-dark';
            if ($status == 'expire' || $status == 'cancel' || $status == 'deny') $badge_class = 'bg-danger';
            ?>
            <span class="badge <?= $badge_class ?> p-2 fs-6"><?= ucfirst($status ?? 'Pending') ?></span>
          </p>
        </div>
      </div>

      <h5 class="mb-3">Detail Item:</h5>
      <div class="table-responsive mb-4">
        <table class="table">
          <thead>
            <tr>
              <th>Nama Buku</th>
              <th class="text-center">Kuantitas</th>
              <th class="text-end">Harga</th>
              <th class="text-end">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php if (is_array($ebook_details)) foreach ($ebook_details as $item): ?>
              <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td class="text-center"><?= htmlspecialchars($item['quantity']) ?></td>
                <td class="text-end">Rp <?= number_format($item['price']) ?></td>
                <td class="text-end">Rp <?= number_format($item['price'] * $item['quantity']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="row">
        <div class="col-md-6">
          <strong>Metode Pembayaran:</strong>
          <p><?= ucfirst(str_replace('_', ' ', $transaction['payment_type'] ?? 'Belum Dipilih')) ?></p>
        </div>
        <div class="col-md-6 text-md-end">
          <h4 class="fw-bold">Total Pembayaran:</h4>
          <h3 class="fw-bold text-danger">Rp <?= number_format($transaction['gross_amount']) ?></h3>
        </div>
      </div>
    </div>
    <div class="card-footer text-center p-3">
      <a href="index.php?action=history" class="btn btn-secondary">Kembali ke Riwayat Transaksi</a>
    </div>
  </div>
</div>
 <br>
 <br>
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