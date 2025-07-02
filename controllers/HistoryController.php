<?php
require_once 'models/User.php';
require_once 'controllers/AuthController.php';

class HistoryController
{

  public function index()
  {
    AuthController::checkUserLogin();

    $conn = connect();
    $userModel = new User();
    $currentUser = $userModel->findByUsername($_SESSION['username']);
    $user_id = $currentUser['id'];

    // --- LOGIKA BARU: PERIKSA PERAN PENGGUNA ---
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
      // Jika admin, ambil SEMUA transaksi dan gabungkan dengan data user
      $query = "
                SELECT t.*, u.username 
                FROM transactions t
                JOIN users u ON t.user_id = u.id
                ORDER BY t.id DESC
            ";
      $stmt = $conn->prepare($query);
    } else {
      // Jika bukan admin (member), hanya ambil transaksi milik sendiri
      $query = "
                SELECT t.*, u.username 
                FROM transactions t
                JOIN users u ON t.user_id = u.id
                WHERE t.user_id = ? 
                ORDER BY t.id DESC
            ";
      $stmt = $conn->prepare($query);
      $stmt->bind_param('i', $user_id);
    }

    $stmt->execute();
    $transactions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    require 'views/history.php';
  }

  public function invoice()
  {
    AuthController::checkUserLogin();

    if (!isset($_GET['order_id'])) {
      header('Location: index.php?action=history');
      exit();
    }

    $order_id = $_GET['order_id'];
    $userModel = new User();
    $currentUser = $userModel->findByUsername($_SESSION['username']);
    $user_id = $currentUser['id'];

    $conn = connect();

    // Admin bisa melihat semua invoice, member hanya invoice miliknya
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
      $stmt = $conn->prepare("SELECT * FROM transactions WHERE order_id = ?");
      $stmt->bind_param('s', $order_id);
    } else {
      $stmt = $conn->prepare("SELECT * FROM transactions WHERE order_id = ? AND user_id = ?");
      $stmt->bind_param('si', $order_id, $user_id);
    }

    $stmt->execute();
    $transaction = $stmt->get_result()->fetch_assoc();

    if (!$transaction) {
      header('Location: index.php?action=history');
      exit();
    }

    require 'views/invoice.php';
  }
}
