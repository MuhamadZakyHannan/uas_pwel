<?php

require_once 'models/User.php';

class AuthController
{
  private $userModel;

  public function __construct()
  {
    $this->userModel = new User();
    $this->checkCookieLogin();
  }

  // Metode BARU untuk menghancurkan session yang rusak
  public function resetSession()
  {
    // Menghancurkan semua data di session
    session_destroy();
    // Mengarahkan kembali ke halaman utama
    header('Location: index.php');
    exit();
  }

  public function login()
  {
    if (isset($_SESSION['username'])) {
      header('Location: index.php?action=list');
      exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user = $this->userModel->findByUsername($_POST['username']);

      if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['cart'] = []; // Pastikan keranjang direset saat login

        if (isset($_POST['remember'])) {
          setcookie('user_id', $user['id'], time() + (86400 * 3), "/");
          setcookie('user_key', hash('sha256', $user['username']), time() + (86400 * 3), "/");
        }
        header('Location: index.php?action=list');
        exit();
      } else {
        $error = true;
      }
    }
    require 'views/login.php';
  }

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
