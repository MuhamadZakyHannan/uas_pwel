<footer class="home-footer py-5 bg-dark text-white">
  <div class="container text-center">
    <p class="text-white-50 mb-0">&copy; <?= date('Y') ?> Bukoo. All rights reserved.</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-xxxxxxxxxxxxxxxxxxxx"></script>

<script src="assets/js/script.js?v=<?= time(); ?>"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {

    // --- LOGIKA LIVE SEARCH (Hanya berjalan di halaman list) ---
    const keywordInputNav = document.getElementById('keyword-nav');
    const container = document.getElementById('ebook-list-container');
    const listTitle = document.getElementById('ebook-list-title');
    const searchFormNav = document.getElementById('search-form-nav');

    if (keywordInputNav && container) {
      keywordInputNav.addEventListener('keyup', function() {
        const keyword = this.value;
        const url = `index.php?action=search&keyword=${encodeURIComponent(keyword)}`;

        fetch(url, {
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.text())
          .then(html => {
            container.innerHTML = html;
            if (listTitle && keyword.length > 0) {
              listTitle.innerText = `Menampilkan hasil untuk: "${keyword}"`;
            } else if (listTitle) {
              // Judul akan diupdate oleh controller saat keyword kosong dan halaman dimuat ulang
            }
          })
          .catch(error => console.error('Error fetching search results:', error));
      });

      if (searchFormNav) {
        searchFormNav.addEventListener('submit', function(e) {
          // Hentikan submit form penuh jika di halaman list, biarkan AJAX bekerja
          if (container) e.preventDefault();
        });
      }
    }

    // --- LOGIKA UNTUK NOTIFIKASI SETELAH REDIRECT ---
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'create_success') {
      Swal.fire('Sukses!', 'eBook telah berhasil ditambahkan.', 'success');
    } else if (status === 'update_success') {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data eBook telah berhasil diperbarui.',
        timer: 2000,
        showConfirmButton: false
      }).then(() => {
        window.history.replaceState(null, null, window.location.pathname + "?action=list");
      });
    }
  });

  // --- Event Listener untuk Aksi KLIK (Beli, Keranjang, Checkout) ---
  document.addEventListener('click', function(e) {
    const addToCartButton = e.target.closest('.add-to-cart-btn');
    const buyNowButton = e.target.closest('.buy-now-btn');
    const checkoutButton = e.target.closest('#checkout-btn');

    // Logika Tombol TAMBAH KE KERANJANG
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
        .then(handleCartUpdate)
        .catch(error => console.error('Error:', error));
    }

    // Logika Tombol BELI SEKARANG
    if (buyNowButton) {
      e.preventDefault();
      Swal.fire({
        title: 'Memproses...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
      });
      fetch('index.php?action=create_transaction', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `ebook_id=${buyNowButton.dataset.id}`
        })
        .then(handleFetchResponse)
        .then(handleSnapPay)
        .catch(handleFetchError);
    }

    // Logika Tombol CHECKOUT KERANJANG
    if (checkoutButton) {
      e.preventDefault();
      Swal.fire({
        title: 'Memproses Keranjang...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
      });
      fetch('index.php?action=create_transaction', {
          method: 'POST'
        })
        .then(handleFetchResponse)
        .then(handleSnapPay)
        .catch(handleFetchError);
    }
  });

  // --- Event Listener untuk Aksi INPUT (Update Kuantitas Otomatis) ---
  document.addEventListener('input', function(e) {
    if (e.target.classList.contains('cart-quantity-input')) {
      const input = e.target;
      const ebookId = input.dataset.id;
      const quantity = input.value;

      if (quantity < 0) return;

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
            if (document.getElementById('total-price-display')) {
              document.getElementById('total-price-display').innerText = data.new_total_price;
            }
            if (document.getElementById('cart-count')) {
              document.getElementById('cart-count').innerText = data.new_cart_count;
            }
            if (quantity == 0) {
              input.closest('.cart-item-row').remove();
              if (data.new_cart_count <= 0) location.reload();
            }
          }
        });
    }
  });

  // --- FUNGSI HELPER ---

  // Fungsi untuk menangani response dari fetch agar lebih aman
  function handleFetchResponse(response) {
    const contentType = response.headers.get("content-type");
    if (contentType && contentType.indexOf("application/json") !== -1) {
      if (!response.ok) {
        return response.json().then(err => {
          throw new Error(err.error || 'Terjadi kesalahan pada server.');
        });
      }
      return response.json();
    } else {
      throw new Error('Server tidak merespons dengan benar. Cek log server untuk melihat error PHP.');
    }
  }

  // Fungsi untuk menangani update tampilan keranjang setelah AJAX
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
    if (data.snap_token) {
      Swal.close();
      snap.pay(data.snap_token, {
        onSuccess: (result) => {
          Swal.fire('Pembayaran Berhasil!', 'Mengarahkan ke halaman invoice...', 'success')
            .then(() => window.location.href = `index.php?action=invoice&order_id=${result.order_id}`);
        },
        onPending: (result) => Swal.fire('Menunggu Pembayaran', 'Selesaikan pembayaran Anda.', 'info'),
        onError: (result) => Swal.fire('Pembayaran Gagal', 'Silakan coba lagi.', 'error')
      });
    } else {
      Swal.fire('Error', data.error || 'Gagal memproses transaksi.', 'error');
    }
  }

  // Fungsi untuk menangani error pada fetch
  function handleFetchError(error) {
    Swal.close();
    Swal.fire('Error', error.message, 'error');
  }
</script>

</body>

</html>