<?php
require_once __DIR__ . '/../config/midtrans.php';

class NotificationController
{
  public function handle()
  {
    header('Content-Type: application/json');

    try {
      $notif = new \Midtrans\Notification();
    } catch (Exception $e) {
      error_log("Midtrans Notification Error: " . $e->getMessage());
      http_response_code(500);
      exit('Internal Server Error');
    }

    $order_id = $notif->order_id;
    $transaction_status = $notif->transaction_status;
    $payment_type = $notif->payment_type;
    $transaction_time = $notif->transaction_time;

    error_log("Midtrans Webhook Received. Order ID: $order_id, Status: $transaction_status");

    $conn = connect();

    $stmt = $conn->prepare("UPDATE transactions SET transaction_status = ?, payment_type = ?, transaction_time = ? WHERE order_id = ?");
    $stmt->bind_param('ssss', $transaction_status, $payment_type, $transaction_time, $order_id);

    if ($stmt->execute()) {
      if ($transaction_status == 'settlement' || $transaction_status == 'capture') {
        // TODO: Berikan akses eBook ke user di sini jika diperlukan
      }
      http_response_code(200);
      echo json_encode(['status' => 'success', 'message' => 'Notification processed.']);
    } else {
      http_response_code(500);
      echo json_encode(['status' => 'error', 'message' => 'Failed to update transaction.']);
    }
  }
}
