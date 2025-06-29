<?php
$title = 'Sign in to Bukoo';
$htmlClass = 'h-100';
// Gunakan class auth-bg untuk background gradien
$bodyClass = 'auth-bg';
include 'partials/header.php';
?>

<div class="auth-container">
  <div class="card auth-card shadow-lg">
    <div class="row g-0">
      <div class="col-md-6 d-none d-md-flex auth-card-right">
        <div class="text-center">
          <img src="assets/img/logo_bukoo.png" alt="Bukoo Logo" style="width: 120px;">
          <h2 class="mt-4 text-white">Bukoo</h2>
          <p class="text-white-50 mt-2">Perpustakaan digital Anda, di mana saja.</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="auth-card-left">
          <div class="text-center mb-4">
            <h1 class="h3 fw-bold">Selamat Datang Kembali!</h1>
            <p class="text-muted">Silakan masuk untuk melanjutkan.</p>
          </div>

          <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Username atau password salah!
              <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <form action="index.php?action=login" method="POST" autocomplete="off">
            <div class="form-floating mb-3">
              <input class="form-control" id="username" name="username" type="text" placeholder="Username" maxlength="20" autofocus required>
              <label for="username">Username</label>
            </div>
            <div class="form-floating mb-3">
              <input class="form-control" id="password" name="password" type="password" placeholder="Password" required>
              <label for="password">Password</label>
            </div>
            <div class="form-check mb-3">
              <input class="form-check-input" id="remember" name="remember" type="checkbox">
              <label class="form-check-label" for="remember">Ingat saya</label>
            </div>
            <button class="w-100 btn btn-primary btn-lg fw-semibold" name="signin" type="submit">Sign In</button>
            <div class="text-center my-3">
              <small>
                Belum punya akun?
                <a class="link-primary text-decoration-none fw-bold" href="index.php?action=signup">Daftar di sini</a>
              </small>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'partials/footer.php'; ?>