<?php
$title = 'Join Bukoo';
$htmlClass = 'h-100';
// Gunakan class auth-bg untuk background gradien
$bodyClass = 'auth-bg';
include 'partials/header.php';
?>

<div class="auth-container">
  <div class="card auth-card shadow-lg">
    <div class="row g-0">
      <div class="col-md-6">
        <div class="auth-card-left">
          <div class="text-center mb-4">
            <h1 class="h3 fw-bold">Buat Akun Baru</h1>
            <p class="text-muted">Gratis dan hanya butuh satu menit.</p>
          </div>

          <?php if (isset($result['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?= htmlspecialchars($result['message']) ?>
              <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <form action="index.php?action=signup" method="POST" autocomplete="off">
            <div class="form-floating mb-2">
              <input class="form-control" id="username" name="username" type="text" placeholder="Username" maxlength="20" onkeyup="validateSignUp()" autofocus required>
              <label for="username">Username</label>
              <div class="invalid-feedback text-start">Silakan pilih username.</div>
            </div>
            <div class="form-floating mb-2">
              <input class="form-control" id="password" name="password" type="password" placeholder="Password" onkeyup="validateSignUp()" required>
              <label for="password">Password</label>
              <div class="invalid-feedback text-start">Password minimal 8 karakter.</div>
            </div>
            <div class="form-floating mb-2">
              <input class="form-control" id="confirmPassword" name="confirmPassword" type="password" placeholder="Confirm Password" onkeyup="validateSignUp()" required>
              <label for="confirmPassword">Konfirmasi Password</label>
              <div class="invalid-feedback text-start">Password tidak cocok.</div>
            </div>
            <div class="form-check my-3">
              <input class="form-check-input" id="show" type="checkbox" onclick="showPassword()">
              <label class="form-check-label" for="show">Tampilkan Password</label>
            </div>
            <button class="w-100 btn btn-primary btn-lg fw-semibold" name="signup" type="submit">Sign Up</button>
            <div class="text-center my-3">
              <small>
                Sudah punya akun?
                <a class="link-primary text-decoration-none fw-bold" href="index.php?action=login">Masuk di sini</a>
              </small>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-6 d-none d-md-flex auth-card-right">
        <div class="text-center">
          <img src="assets/img/logo_bukoo.png" alt="Bukoo Logo" style="width: 120px;">
          <h2 class="mt-4 text-white">Bergabung dengan Komunitas</h2>
          <p class="text-white-50 mt-2">Temukan, bagikan, dan kelola buku digital favorit Anda.</p>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
$footerScripts = '';
if (isset($result['success'])) {
  $footerScripts = <<<SCRIPT
  <script>
    Swal.fire({
      title: 'Registrasi Berhasil!',
      text: 'Anda akan diarahkan ke halaman login.',
      icon: 'success',
      timer: 2000,
      timerProgressBar: true,
      showConfirmButton: false,
      willClose: () => {
        window.location.href = 'index.php?action=login';
      }
    });
  </script>
SCRIPT;
}
include 'partials/footer.php';
echo $footerScripts;
?>