

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-xxxxxxxxxxxxxxxxxxxx"></script>

<script src="assets/js/script.js?v=<?= time(); ?>"></script>

<?php if (isset($_GET['status'])): ?>
  <script>
    const status = "<?= htmlspecialchars($_GET['status']) ?>";
    if (status === 'create_success') {
      Swal.fire('Sukses!', 'eBook telah berhasil ditambahkan.', 'success');
    } else if (status === 'update_success') {
      Swal.fire('Sukses!', 'eBook telah berhasil diperbarui.', 'success');
    }
  </script>
<?php endif; ?>

<script>
  document.addEventListener('click', function(e) {
    // Cari elemen terdekat yang memiliki class 'buy-now-btn'
    const buyButton = e.target.closest('.buy-now-btn');

    // Jika tombol "Beli" yang diklik
    if (buyButton) {
      e.preventDefault(); // Mencegah link default berjalan

      // Ambil data dari tombol
      const ebookId = buyButton.dataset.id;
      const ebookTitle = buyButton.dataset.title;
      const ebookPrice = buyButton.dataset.price;

      // Tampilkan pesan loading
      Swal.fire({
        title: 'Memproses Transaksi...',
        text: 'Harap tunggu sebentar.',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      // Kirim request ke backend untuk membuat token pembayaran
      fetch('index.php?action=create_transaction', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `id=${ebookId}&title=${ebookTitle}&price=${ebookPrice}`
        })
        .then(response => {
          if (!response.ok) {
            return response.json().then(err => {
              throw new Error(err.error || 'Terjadi kesalahan pada server.')
            });
          }
          return response.json();
        })
        .then(data => {
          Swal.close(); // Tutup pesan loading

          if (data.snap_token) {
            // Jika token berhasil didapat, BUKA POP-UP PEMBAYARAN MIDTRANS
            snap.pay(data.snap_token, {
              onSuccess: function(result) {
                Swal.fire('Pembayaran Berhasil!', 'Terima kasih! Anda akan segera mendapatkan akses.', 'success');
              },
              onPending: function(result) {
                Swal.fire('Menunggu Pembayaran', 'Selesaikan pembayaran Anda.', 'info');
              },
              onError: function(result) {
                Swal.fire('Pembayaran Gagal', 'Silakan coba lagi.', 'error');
              }
            });
          } else {
            // Jika tidak ada token (misal: belum login)
            Swal.fire('Error', data.error || 'Gagal membuat transaksi.', 'error');
          }
        })
        .catch(error => {
          Swal.close();
          Swal.fire('Error', error.message, 'error');
        });
    }
  });
</script>

</body>

</html>