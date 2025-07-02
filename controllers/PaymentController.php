<?php
require_once __DIR__ . '/../config/midtrans.php';
require_once __DIR__ . '/../models/Ebook.php';
// PASTIKAN FILE INI DIPANGGIL untuk mendapatkan data pengguna
require_once __DIR__ . '/../models/User.php';

class PaymentController
{
  public function createTransaction()
  {
    // Selalu set header JSON di awal, ini sangat penting
    header('Content-Type: application/json');

    try {
      // 1. Validasi Session Pengguna
      if (!isset($_SESSION['username'])) {
        throw new Exception('Anda harus login untuk melakukan pembayaran.', 401);
      }

      // 2. Inisialisasi Model dan Ambil Data Pengguna
      $ebookModel = new Ebook();
      $userModel = new User();
      $currentUser = $userModel->findByUsername($_SESSION['username']);

      if (!$currentUser) {
        throw new Exception('Data pengguna tidak valid atau tidak ditemukan.', 404);
      }
      $user_id = $currentUser['id'];

      $item_details = [];
      $gross_amount = 0;
      $order_id_prefix = '';

      // 3. Logika Pengumpulan Item (Beli Sekarang vs Keranjang)
      if (isset($_POST['ebook_id'])) { // Skenario "Beli Sekarang"
        $ebook = $ebookModel->findById((int)$_POST['ebook_id']);
        if ($ebook && $ebook['price'] > 0) {
          $item_details[] = ['id' => $ebook['id'], 'price' => (int)$ebook['price'], 'quantity' => 1, 'name' => $ebook['title']];
          $gross_amount = (int)$ebook['price'];
          $order_id_prefix = 'BUKOO-DIRECT-';
        }
      } elseif (!empty($_SESSION['cart'])) { // Skenario "Checkout Keranjang"
        foreach ($_SESSION['cart'] as $ebookId => $quantity) {
          $ebook = $ebookModel->findById($ebookId);
          if ($ebook && $ebook['price'] > 0) {
            $item_details[] = ['id' => $ebook['id'], 'price' => (int)$ebook['price'], 'quantity' => $quantity, 'name' => $ebook['title']];
            $gross_amount += (int)$ebook['price'] * $quantity;
          }
        }
        $order_id_prefix = 'BUKOO-CART-';
      }

      // 4. Validasi Akhir
      if (empty($item_details) || $gross_amount <= 0) {
        throw new Exception('Tidak ada item valid atau total harga nol untuk dibayar.', 400);
      }

      $order_id = $order_id_prefix . time();
      $params = [
        'transaction_details' => ['order_id' => $order_id, 'gross_amount' => $gross_amount],
        'item_details' => $item_details,
        'customer_details' => ['first_name' => $_SESSION['username'], 'email' => $_SESSION['username'] . '@bukoo.com'],
      ];

      // 5. Simpan Transaksi Awal ke Database
      $conn = connect();
      $stmt = $conn->prepare("INSERT INTO transactions (order_id, user_id, ebook_details, gross_amount, transaction_status, transaction_time) VALUES (?, ?, ?, ?, 'pending', NOW())");
      $ebook_details_json = json_encode($item_details);
      $stmt->bind_param('sisi', $order_id, $user_id, $ebook_details_json, $gross_amount);
      $stmt->execute();

      // 6. Dapatkan Snap Token dari Midtrans
      $snapToken = \Midtrans\Snap::getSnapToken($params);
      echo json_encode(['snap_token' => $snapToken]);
    } catch (Exception $e) {
      // Tangkap semua jenis error dan kirim response JSON yang benar
      $statusCode = $e->getCode() ?: 500;
      http_response_code($statusCode);
      error_log("PaymentController Error: " . $e->getMessage()); // Catat error di log server
      echo json_encode(['error' => $e->getMessage()]);
    }
  }
}
