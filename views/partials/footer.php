

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-xxxxxxxxxxxxxxxxxxxx"></script>
<script src="assets/js/script.js?v=<?= time(); ?>"></script>

<script>
  // --- Event Listener Utama untuk Semua Aksi ---

  // 1. Aksi yang memicu perubahan (klik)
  document.addEventListener('click', function(e) {
    const addToCartButton = e.target.closest('.add-to-cart-btn');
    const buyNowButton = e.target.closest('.buy-now-btn');
    const checkoutButton = e.target.closest('#checkout-btn');

    // --- Logika Tombol TAMBAH KE KERANJANG ---
    if (addToCartButton) {
      e.preventDefault();
      fetch('index.php?action=add_to_cart', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `id=${addToCartButton.dataset.id}`
        })
        .then(response => response.json())
        .then(handleCartUpdate);
    }

    // --- Logika Tombol BELI SEKARANG ---
    if (buyNowButton) {
      e.preventDefault();
      Swal.fire({
        title: 'Memproses...',
        didOpen: () => Swal.showLoading()
      });
      fetch('index.php?action=create_transaction', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `ebook_id=${buyNowButton.dataset.id}`
        })
        .then(res => res.json()).then(handleSnapPay);
    }

    // --- Logika Tombol CHECKOUT KERANJANG ---
    if (checkoutButton) {
      e.preventDefault();
      Swal.fire({
        title: 'Memproses Keranjang...',
        didOpen: () => Swal.showLoading()
      });
      fetch('index.php?action=create_transaction', {
          method: 'POST'
        })
        .then(res => res.json()).then(handleSnapPay);
    }
  });

  // 2. Aksi yang memicu perubahan (input pada kuantitas)
  document.addEventListener('input', function(e) {
    if (e.target.classList.contains('cart-quantity-input')) {
      const input = e.target;
      const ebookId = input.dataset.id;
      const quantity = input.value;

      if (quantity < 0) return; // Abaikan jika angka negatif

      fetch('index.php?action=updateQuantity', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `id=${ebookId}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            document.getElementById('total-price-display').innerText = data.new_total_price;
            document.getElementById('cart-count').innerText = data.new_cart_count;
            if (quantity == 0) {
              input.closest('.cart-item-row').remove();
              if (data.new_cart_count <= 0) location.reload();
            }
          }
        });
    }
  });

  // --- Fungsi Helper ---

  // Fungsi untuk menangani update tampilan keranjang
  function handleCartUpdate(data) {
    if (data.success) {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: data.message,
        timer: 1500,
        showConfirmButton: false
      });
      document.getElementById('cart-count').innerText = data.cart_count;
    } else {
      Swal.fire({
        icon: 'info',
        title: 'Oops!',
        text: data.message
      });
    }
  }

  // Fungsi untuk menangani pembayaran Midtrans
  function handleSnapPay(data) {
    Swal.close();
    if (data.snap_token) {
      snap.pay(data.snap_token, {
        onSuccess: (result) => Swal.fire('Pembayaran Berhasil!', 'Terima kasih!', 'success'),
        onPending: (result) => Swal.fire('Menunggu Pembayaran', 'Selesaikan pembayaran Anda.', 'info'),
        onError: (result) => Swal.fire('Pembayaran Gagal', 'Silakan coba lagi.', 'error')
      });
    } else {
      Swal.fire('Error', data.error || 'Gagal memproses transaksi.', 'error');
    }
  }
</script>

</body>

</html>