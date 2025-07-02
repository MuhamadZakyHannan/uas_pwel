<?php
session_start();
// Memuat semua library dari Composer (termasuk Midtrans)
require_once __DIR__ . '/vendor/autoload.php';

// Memuat semua file konfigurasi dan controller yang dibutuhkan
require_once 'helpers/csrf_helper.php';
require_once 'config/database.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/EbookController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/PaymentController.php';
require_once 'controllers/CartController.php';
require_once 'controllers/HistoryController.php';
require_once 'controllers/NotificationController.php';

// Menentukan aksi default jika tidak ada parameter di URL
$action = $_GET['action'] ?? 'home';

// Router utama untuk mengarahkan ke controller yang sesuai
switch ($action) {
  // Rute untuk Autentikasi dan Reset
  case 'login':
  case 'signup':
  case 'logout':
  case 'reset_session':
    (new AuthController())->$action();
    break;

  // Rute untuk mengelola eBook
  case 'list':
    (new EbookController())->index();
    break;
  case 'search':
  case 'create':
  case 'store':
  case 'edit':
  case 'update':
  case 'delete':
  case 'detail':
    (new EbookController())->$action();
    break;

  // Rute untuk Keranjang Belanja
  case 'cart':
    (new CartController())->viewCart();
    break;
  case 'add_to_cart':
    (new CartController())->addToCart();
    break;
  case 'remove_from_cart':
    (new CartController())->removeFromCart();
    break;
  case 'updateQuantity':
    (new CartController())->updateQuantity();
    break;
  case 'clearCart':
    (new CartController())->clearCart();
    break;

  // Rute untuk Transaksi Pembayaran
  case 'create_transaction':
    (new PaymentController())->createTransaction();
    break;

  // Rute untuk Riwayat dan Notifikasi
  case 'history':
    (new HistoryController())->index();
    break;
  case 'invoice':
    (new HistoryController())->invoice();
    break;
  case 'notification':
    (new NotificationController())->handle();
    break;

  // Rute Halaman Utama (default)
  case 'home':
  default:
    (new HomeController())->index();
    break;
}
