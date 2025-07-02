<?php
// require_once __DIR__ . '/../config/midtrans.php';
require_once __DIR__ . '/../models/Ebook.php';

class PaymentController
{
  public function createTransaction()
  {
    if (!isset($_SESSION['username'])) {
      http_response_code(401);
      echo json_encode(['error' => 'Silakan login terlebih dahulu.']);
      exit();
    }

    $item_details = [];
    $gross_amount = 0;
    $order_id_prefix = '';

    // Skenario 1: Beli Sekarang (data dikirim dari tombol)
    if (isset($_POST['ebook_id'])) {
      $ebookModel = new Ebook();
      $ebook = $ebookModel->findById((int)$_POST['ebook_id']);

      if (!$ebook || $ebook['price'] <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Produk tidak valid untuk dibeli.']);
        exit();
      }

      $item_details[] = [
        'id' => $ebook['id'],
        'price' => (int)$ebook['price'],
        'quantity' => 1,
        'name' => $ebook['title']
      ];
      $gross_amount = (int)$ebook['price'];
      $order_id_prefix = 'BUKOO-DIRECT-';

      // Skenario 2: Checkout Keranjang (data dari session)
    } elseif (!empty($_SESSION['cart'])) {
      $ebookModel = new Ebook();
      foreach ($_SESSION['cart'] as $ebookId => $quantity) {
        $ebook = $ebookModel->findById($ebookId);
        if ($ebook && $ebook['price'] > 0) {
          $item_details[] = [
            'id' => $ebook['id'],
            'price' => (int)$ebook['price'],
            'quantity' => $quantity,
            'name' => $ebook['title']
          ];
          $gross_amount += (int)$ebook['price'] * $quantity;
        }
      }
      $order_id_prefix = 'BUKOO-CART-';
    }

    // Jika tidak ada item sama sekali
    if (empty($item_details)) {
      http_response_code(400);
      echo json_encode(['error' => 'Tidak ada item untuk dibayar.']);
      exit();
    }

    $params = [
      'transaction_details' => [
        'order_id' => $order_id_prefix . time(),
        'gross_amount' => $gross_amount,
      ],
      'item_details' => $item_details,
      'customer_details' => [
        'first_name' => $_SESSION['username'],
        'email' => $_SESSION['username'] . '@bukoo.com',
      ],
    ];

    try {
      $snapToken = \Midtrans\Snap::getSnapToken($params);
      echo json_encode(['snap_token' => $snapToken]);
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(['error' => $e->getMessage()]);
    }
  }
}
