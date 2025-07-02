<?php
// helpers/csrf_helper.php

/**
 * Memastikan session sudah dimulai sebelum digunakan.
 */
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

/**
 * Membuat token CSRF jika belum ada dan menyimpannya di session.
 * @return string Token CSRF.
 */
function generate_csrf_token()
{
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

/**
 * Memvalidasi token CSRF yang dikirim dari form dengan yang ada di session.
 * @return bool True jika valid, false jika tidak.
 */
function validate_csrf_token()
{
  if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token'])) {
    return false;
  }
  return hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
}

/**
 * Menghapus token CSRF dari session. Panggil setelah validasi berhasil.
 */
function unset_csrf_token()
{
  if (isset($_SESSION['csrf_token'])) {
    unset($_SESSION['csrf_token']);
  }
}
