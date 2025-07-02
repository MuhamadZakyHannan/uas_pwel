<?php

require_once 'models/User.php';

class AuthController
{
  private $userModel;
  // Pengaturan untuk Rate Limiting
  private const MAX_LOGIN_ATTEMPTS = 5; // Batasi 5 kali percobaan salah
  private const LOCKOUT_TIME = 900;     // Kunci selama 15 menit (900 detik)

  public function __construct()
  {
    $this->userModel = new User();
    $this->checkCookieLogin();
  }

  public function login()
  {
    if (isset($_SESSION['username'])) {
      header('Location: index.php?action=list');
      exit();
    }

    // --- AWAL DARI KODE RATE LIMITING ---
    $ip_address = $_SERVER['REMOTE_ADDR'];
    if ($this->isLoginLocked($ip_address)) {
      // Jika terkunci, tampilkan pesan error dan hentikan proses
      $error = "Anda telah mencoba login terlalu banyak. Silakan coba lagi dalam 15 menit.";
      require 'views/login.php';
      exit();
    }
    // --- AKHIR DARI KODE RATE LIMITING ---

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user = $this->userModel->findByUsername($_POST['username']);

      if ($user && password_verify($_POST['password'], $user['password'])) {
        // Jika login berhasil, hapus catatan percobaan gagal
        $this->clearLoginAttempts($ip_address);

        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if (isset($_POST['remember'])) {
          setcookie('user_id', $user['id'], time() + (86400 * 3), "/");
          setcookie('user_key', hash('sha256', $user['username']), time() + (86400 * 3), "/");
        }
        header('Location: index.php?action=list');
        exit();
      } else {
        // Jika login gagal, catat percobaan ini
        $this->recordLoginAttempt($ip_address);
        $error = "Username atau password salah.";
      }
    }
    require 'views/login.php';
  }

  // --- FUNGSI-FUNGSI BARU UNTUK RATE LIMITING ---

  /**
   * Memeriksa apakah login terkunci untuk IP tertentu.
   */
  private function isLoginLocked($ip_address)
  {
    $conn = connect();
    $lockout_period = date('Y-m-d H:i:s', time() - self::LOCKOUT_TIME);

    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM login_attempts WHERE ip_address = ? AND attempt_time > ?");
    $stmt->bind_param('ss', $ip_address, $lockout_period);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    return $result['total'] >= self::MAX_LOGIN_ATTEMPTS;
  }

  /**
   * Mencatat percobaan login yang gagal.
   */
  private function recordLoginAttempt($ip_address)
  {
    $conn = connect();
    $current_time = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO login_attempts (ip_address, attempt_time) VALUES (?, ?)");
    $stmt->bind_param('ss', $ip_address, $current_time);
    $stmt->execute();
  }

  /**
   * Membersihkan catatan percobaan login setelah login berhasil.
   */
  private function clearLoginAttempts($ip_address)
  {
    $conn = connect();
    $stmt = $conn->prepare("DELETE FROM login_attempts WHERE ip_address = ?");
    $stmt->bind_param('s', $ip_address);
    $stmt->execute();
  }

  // --- Sisa fungsi lain tidak berubah ---

  public function signup()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $result = $this->userModel->create($_POST);
    }
    require 'views/signup.php';
  }

  public function logout()
  {
    $_SESSION = [];
    session_unset();
    session_destroy();

    setcookie('user_id', '', time() - 3600, '/');
    setcookie('user_key', '', time() - 3600, '/');

    header('Location: index.php?action=home');
    exit();
  }

  private function checkCookieLogin()
  {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_key']) && !isset($_SESSION['username'])) {
      $user = $this->userModel->findById($_COOKIE['user_id']);
      if ($user && hash('sha256', $user['username']) === $_COOKIE['user_key']) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
      }
    }
  }

  public static function checkUserLogin()
  {
    if (!isset($_SESSION['username'])) {
      header('Location: index.php?action=login');
      exit();
    }
  }

  public static function checkUserRole()
  {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
      header('Location: index.php?action=list');
      exit();
    }
  }
}
