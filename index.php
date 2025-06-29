<?php
session_start();
// Memuat semua library dari Composer
require_once 'vendor/autoload.php';

require_once 'config/database.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/EbookController.php';
require_once 'controllers/AuthController.php';
// Memanggil Controller Pembayaran yang baru
require_once 'controllers/PaymentController.php';

$action = $_GET['action'] ?? 'home';

switch ($action) {
  // Rute Autentikasi
  case 'login':
    $controller = new AuthController();
    $controller->login();
    break;
  case 'signup':
    $controller = new AuthController();
    $controller->signup();
    break;
  case 'logout':
    $controller = new AuthController();
    $controller->logout();
    break;

  // Rute eBook
  case 'list':
    $controller = new EbookController();
    $controller->index();
    break;
  case 'create':
    $controller = new EbookController();
    $controller->create();
    break;
  case 'store':
    $controller = new EbookController();
    $controller->store();
    break;
  case 'edit':
    $controller = new EbookController();
    $controller->edit();
    break;
  case 'update':
    $controller = new EbookController();
    $controller->update();
    break;
  case 'delete':
    $controller = new EbookController();
    $controller->delete();
    break;
  case 'search':
    $controller = new EbookController();
    $controller->search();
    break;

  // Rute Pembayaran
  case 'create_transaction':
    $controller = new PaymentController();
    $controller->createTransaction();
    break;

  // Rute Beranda
  case 'home':
  default:
    $controller = new HomeController();
    $controller->index();
    break;
}
