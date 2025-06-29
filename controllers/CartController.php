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

    public function clearCart()
    {
        $_SESSION['cart'] = [];
        header('Location: index.php?action=cart');
        exit();
    }

    public function addToCart()
    {
        header('Content-Type: application/json');
        if (!isset($_POST['id'])) {
            echo json_encode(['success' => false, 'message' => 'ID produk tidak valid.']);
            return;
        }

        $ebookId = (int)$_POST['id'];

        if (isset($_SESSION['cart'][$ebookId])) {
            $_SESSION['cart'][$ebookId]++;
            $message = 'Kuantitas buku di keranjang diperbarui!';
        } else {
            $_SESSION['cart'][$ebookId] = 1;
            $message = 'Buku berhasil ditambahkan ke keranjang!';
        }

        $totalItems = 0;
        foreach ($_SESSION['cart'] as $quantity) {
            $totalItems += $quantity;
        }

        echo json_encode(['success' => true, 'message' => $message, 'cart_count' => $totalItems]);
    }

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
            $total_items = 0;
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $id => $qty) {
                    $item = $ebookModel->findById($id);
                    if ($item) {
                        $total_price += (int)$item['price'] * $qty;
                    }
                    $total_items += $qty;
                }
            }

            echo json_encode([
                'success' => true,
                'new_total_price' => 'Rp ' . number_format($total_price),
                'new_cart_count' => $total_items
            ]);
            exit();
        }
        echo json_encode(['success' => false]);
    }
}
