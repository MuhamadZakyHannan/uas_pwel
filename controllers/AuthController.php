<?php

require_once 'models/User.php';

class AuthController
{
  private $userModel;
  // Pengaturan untuk Rate Limiting
  private const MAX_LOGIN_ATTEMPTS = 5; // Maksimal 5 kali percobaan
  private const LOCKOUT_TIME = 900;     // Kunci selama 15 menit (dalam detik)

  public function __construct()
  {
    $this->userModel = new User();
    // Jalankan pemeriksaan cookie setiap kali controller dibuat
    $this->checkCookieLogin();
  }

  public function login()
  {
    if (isset($_SESSION['username'])) {
      header('Location: index.php?action=list');
      exit();
    }

    $ip_address = $_SERVER['REMOTE_ADDR'];
    if ($this->isLoginLocked($ip_address)) {
      $error = "Anda telah mencoba login terlalu banyak. Silakan coba lagi dalam 15 menit.";
      require 'views/login.php';
      exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user = $this->userModel->findByUsername($_POST['username']);

      if ($user && password_verify($_POST['password'], $user['password'])) {
        $this->clearLoginAttempts($ip_address);

        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['cart'] = []; // Pastikan keranjang direset saat login

        // --- LOGIKA "INGAT SAYA" (COOKIE) YANG DIPERBAIKI ---
        if (!empty($_POST['remember'])) {
          $cookie_duration = time() + (86400 * 30); // 30 hari
          $user_agent = $_SERVER['HTTP_USER_AGENT'];

          $key = hash('sha256', $user['username'] . $user_agent);

          // Set cookie dengan path '/' dan atribut httponly untuk keamanan
          setcookie('user_id', $user['id'], [
            'expires' => $cookie_duration,
            'path' => '/',
            'httponly' => true
          ]);
          setcookie('user_key', $key, [
            'expires' => $cookie_duration,
            'path' => '/',
            'httponly' => true
          ]);
        }
        // --- AKHIR PERBAIKAN ---

        header('Location: index.php?action=list');
        exit();
      } else {
        $this->recordLoginAttempt($ip_address);
        $error = "Username atau password salah.";
      }
    }
    require 'views/login.php';
  }

  private function checkCookieLogin()
  {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_key']) && !isset($_SESSION['username'])) {
      $user = $this->userModel->findById($_COOKIE['user_id']);

      if ($user) {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $key_to_verify = hash('sha256', $user['username'] . $user_agent);

        if (hash_equals($key_to_verify, $_COOKIE['user_key'])) {
          $_SESSION['username'] = $user['username'];
          $_SESSION['role'] = $user['role'];
        } else {
          $this->forceLogout();
        }
      } else {
        $this->forceLogout();
      }
    }
  }

  public function logout()
  {
    $this->forceLogout();
    header('Location: index.php?action=home');
    exit();
  }

  // Fungsi baru untuk membersihkan session dan cookie secara paksa
  private function forceLogout()
  {
    $_SESSION = [];
    session_unset();
    session_destroy();

    setcookie('user_id', '', time() - 3600, '/');
    setcookie('user_key', '', time() - 3600, '/');
  }

  public function signup()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $result = $this->userModel->create($_POST);
    }
    require 'views/signup.php';
  }

  public function resetSession()
  {
    session_destroy();
    header('Location: index.php');
    exit();
  }

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

  private function recordLoginAttempt($ip_address)
  {
    $conn = connect();
    $current_time = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO login_attempts (ip_address, attempt_time) VALUES (?, ?)");
    $stmt->bind_param('ss', $ip_address, $current_time);
    $stmt->execute();
  }

  private function clearLoginAttempts($ip_address)
  {
    $conn = connect();
    $stmt = $conn->prepare("DELETE FROM login_attempts WHERE ip_address = ?");
    $stmt->bind_param('s', $ip_address);
    $stmt->execute();
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
