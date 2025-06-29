<?php

class HomeController
{
  public function index()
  {
    $this->checkCookieLogin();
    require 'views/home.php';
  }

  private function checkCookieLogin()
  {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_key'])) {
      require_once 'models/User.php';
      $userModel = new User();
      $user = $userModel->findById($_COOKIE['user_id']);

      if ($user && hash('sha256', $user['username']) === $_COOKIE['user_key']) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
      }
    }
  }
}
