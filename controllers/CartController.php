<?php
require_once __DIR__ . '/../models/Ebook.php';

class CartController
{

    public function __construct()
    {
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    /**
     * Menambahkan item ke keranjang. Tidak menambah kuantitas jika sudah ada.
     */
    public function addToCart()
    {
        header('Content-Type: application/json');
        if (!isset($_POST['id'])) {
            echo json_encode(['success' => false, 'message' => 'ID produk tidak valid.']);
            return;
        }
        $ebookId = (int)$_POST['id'];

        if (!isset($_SESSION['cart'][$ebookId])) {
            $_SESSION['cart'][$ebookId] = 1; // Kuantitas default 1
            $message = 'Buku berhasil ditambahkan ke keranjang!';
        } else {
            $message = 'Buku sudah ada di dalam keranjang.';
        }

        // LOGIKA BARU: Hitung jumlah item unik (jenis barang)
        $uniqueItemCount = count($_SESSION['cart']);

        echo json_encode(['success' => true, 'message' => $message, 'cart_count' => $uniqueItemCount]);
    }

    /**
     * Memperbarui kuantitas via AJAX.
     */
    public function updateQuantity()
    {
        header('Content-Type: application/json');
        if (isset($_POST['id']) && isset($_POST['quantity'])) {
            $ebookId = (int)$_POST['id'];
            $quantity = (int)$_POST['quantity'];

            if (isset($_SESSION['cart'][$ebookId])) {
                if ($quantity > 0) {
                    $_SESSION['cart'][$ebookId] = $quantity;
                } else {
                    unset($_SESSION['cart'][$ebookId]);
                }
            }

            $ebookModel = new Ebook();
            $total_price = 0;
            // LOGIKA BARU: Hitung jumlah item unik
            $uniqueItemCount = count($_SESSION['cart']);

            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $id => $qty) {
                    $item = $ebookModel->findById($id);
                    if ($item) {
                        $total_price += (int)$item['price'] * $qty;
                    }
                }
            }
            echo json_encode([
                'success' => true,
                'new_total_price' => 'Rp ' . number_format($total_price),
                'new_cart_count' => $uniqueItemCount // Kirim jumlah unik
            ]);
            exit();
        }
        echo json_encode(['success' => false]);
    }

    // --- Fungsi lain tetap sama ---
    public function viewCart()
    {
        $cart_items = [];
        $total_price = 0;
        $ebookModel = new Ebook();

        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $ebookId => $quantity) {
                $item = $ebookModel->findById($ebookId);
                if ($item) {
                    $item['quantity'] = $quantity;
                    $cart_items[] = $item;
                    $total_price += (int)($item['price'] ?? 0) * $quantity;
                }
            }
        }

        require 'views/cart.php';
    }
    public function clearCart()
    {
        $_SESSION['cart'] = [];
        header('Location: index.php?action=cart');
        exit();
    }
    public function removeFromCart()
    {
        if (isset($_GET['id'])) {
            $ebookId = (int)$_GET['id'];
            if (isset($_SESSION['cart'][$ebookId])) {
                unset($_SESSION['cart'][$ebookId]);
            }
        }
        header('Location: index.php?action=cart');
        exit();
    }
}
