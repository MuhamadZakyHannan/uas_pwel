<?php
require_once 'vendor/autoload.php';
require_once 'config/midtrans.php';

try {
  $notif = new \Midtrans\Notification();
  $transaction_status = $notif->transaction_status;
  $order_id = $notif->order_id;
  error_log("Midtrans notification. Order ID: $order_id, Status: $transaction_status");

  if ($transaction_status == 'settlement' || $transaction_status == 'capture') {
    // TODO: Logika untuk memberikan akses buku ke user setelah pembayaran berhasil
  }
} catch (Exception $e) {
  error_log("Error processing notification: " . $e->getMessage());
  http_response_code(500);
}
