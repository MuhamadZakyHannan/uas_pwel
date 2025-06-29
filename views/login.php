<?php
$title = 'Sign In - Bukoo';
include 'partials/header.php';
?>

<div class="auth-bg">
  <div class="container auth-container">
    <div class="card auth-card shadow-lg">
      <div class="row g-0">
        <div class="col-md-6 auth-card-left">
          <div class="text-center mb-5">
            <a class="navbar-brand d-inline-flex align-items-center" href="index.php?action=home">
              <img class="me-2" src="assets/img/logo_bukoo.png" style="width: 40px;">
              <span class="fw-bold fs-3 text-info">Bukoo</span>
            </a>
            <h1 class="h3 mt-3">Selamat Datang Kembali</h1>
            <p class="text-muted">Silakan masuk untuk melanjutkan.</p>
          </div>

          <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
              <?= $error ?>
            </div>
          <?php endif; ?>

          <form action="index.php?action=login" method="POST" autocomplete="off">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" name="username" id="username" autofocus required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" id="password" required>
            </div>

            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="remember" name="remember">
              <label class="form-check-label" for="remember">Ingat Saya</label>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary btn-lg fw-semibold">Sign In</button>
            </div>
          </form>
          <div class="text-center mt-4">
            <p class="text-muted">Belum punya akun? <a href="index.php?action=signup" class="link-primary text-decoration-none">Buat akun</a></p>
          </div>
        </div>
        <div class="col-md-6 auth-card-right d-none d-md-flex">
          <div class="text-center text-white">
            <h2 class="mb-3">Jelajahi Dunia Pengetahuan</h2>
            <p>Ribuan buku digital menanti untuk Anda baca dan pelajari.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'partials/footer.php'; ?>