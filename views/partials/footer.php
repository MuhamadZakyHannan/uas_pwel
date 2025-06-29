<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js" integrity="sha256-3A7QayeQTyaWMdcuWimEMzTIauIWscnhq/A3GfKCxiA=" crossorigin="anonymous"></script>
<script src="assets/js/script.js"></script>
<?php if (isset($_GET['status'])): ?>
  <script>
    // ... (kode sweetalert yang sudah ada tidak berubah) ...
    const status = "<?= htmlspecialchars($_GET['status']) ?>";
    if (status === 'create_success') {
      Swal.fire('Sukses!', 'eBook telah ditambahkan', 'success');
    } else if (status === 'create_failed') {
      Swal.fire('Error!', 'Gagal menambahkan eBook. Coba lagi!', 'error');
    } else if (status === 'update_success') {
      Swal.fire('Sukses!', 'eBook telah diperbarui.', 'success');
    } else if (status === 'no_update') {
      Swal.fire('Tidak Ada Perubahan!', 'Data eBook tidak berubah', 'warning');
    } else if (status === 'update_failed') {
      Swal.fire('Error!', 'Gagal memperbarui eBook. Coba lagi!', 'error');
    } else if (status === 'delete_success') {
      Swal.fire('Sukses!', 'eBook telah dihapus', 'success');
    } else if (status === 'delete_failed') {
      Swal.fire('Error!', 'Gagal menghapus eBook. Coba lagi!', 'error');
    }
  </script>
<?php endif; ?>

<script>
  const keyword = document.getElementById('keyword');
  const content = document.getElementById('content');

  if (keyword) {
    keyword.addEventListener('keyup', function() {
      const url = 'index.php?action=search&keyword=' + this.value;

      fetch(url, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(response => response.text())
        .then(data => {
          content.innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
    });
  }
</script>

</body>

</html>