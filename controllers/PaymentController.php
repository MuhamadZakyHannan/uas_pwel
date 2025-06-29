<?php
require_once __DIR__ . '/../config/midtrans.php';
require_once __DIR__ . '/../models/Ebook.php';

class PaymentController
{
  public function createTransaction()
  {
    // Pastikan pengguna sudah login untuk membeli
    if (!isset($_SESSION['username'])) {
      http_response_code(401);
      echo json_encode(['error' => 'Silakan login terlebih dahulu untuk membeli.']);
      exit();
    }

    // Ambil data dari request frontend
    $ebookId = $_POST['id'];
    $ebookPrice = (int)$_POST['price']; // Pastikan harga adalah integer
    $ebookTitle = $_POST['title'];

    // Buat order ID yang unik
    $order_id = 'BUKOO-' . $ebookId . '-' . time();

    // Siapkan parameter untuk Midtrans
    $params = [
      'transaction_details' => [
        'order_id' => $order_id,
        'gross_amount' => $ebookPrice,
      ],
      'item_details' => [[
        'id' => $ebookId,
        'price' => $ebookPrice,
        'quantity' => 1,
        'name' => $ebookTitle,
      ]],
      'customer_details' => [
        // Menggunakan username sebagai nama depan
        'first_name' => $_SESSION['username'],
        // Asumsi email, bisa diganti jika Anda menyimpan email user
        'email' => $_SESSION['username'] . '@bukoo.com',
      ],
    ];

    try {
      // Dapatkan Snap Token dari Midtrans
      $snapToken = \Midtrans\Snap::getSnapToken($params);
      // Kirim token kembali ke frontend
      echo json_encode(['snap_token' => $snapToken]);
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(['error' => $e->getMessage()]);
    }
  }
}
