<?php
$title = 'Add eBook - Bukoo';
include 'partials/header.php';
include 'partials/navbar.php';
?>

<div class="form-page-container py-5 bg-light">
  <div class="container">
    <div class="form-container mx-auto shadow-lg p-4 p-md-5 bg-white rounded">
      <div class="text-center mb-5">
        <h1 class="h2 fw-bold">Tambah eBook Baru</h1>
        <p class="text-muted">Bagikan buku digital baru untuk memperkaya koleksi.</p>
      </div>

      <form class="row g-3" action="index.php?action=store" method="POST" enctype="multipart/form-data" autocomplete="off">

        <div class="col-12">
          <label class="form-label fw-semibold" for="title">Judul Buku</label>
          <input class="form-control form-control-lg" id="title" name="title" type="text" placeholder="Contoh: Belajar Pemrograman PHP dari Dasar" maxlength="255" autofocus required>
        </div>

        <div class="col-12">
          <label for="description" class="form-label fw-semibold">Deskripsi</label>
          <textarea class="form-control" id="description" name="description" rows="4" placeholder="Tulis deskripsi singkat yang menarik tentang buku ini..."></textarea>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold" for="author">Penulis</label>
          <input class="form-control" id="author" name="author" type="text" placeholder="Contoh: John Doe" maxlength="100" required>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold" for="year">Tahun Terbit</label>
          <input class="form-control" id="year" name="year" type="number" placeholder="Contoh: 2023" min="1900" max="<?= date('Y') ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold" for="category">Kategori</label>
          <select class="form-select" id="category" name="category">
            <option value="Artificial Intelligence">Artificial Intelligence</option>
            <option value="Computer Science">Computer Science</option>
            <option value="Cyber Security">Cyber Security</option>
            <option value="Data Science">Data Science</option>
            <option value="Design">Design</option>
            <option value="Development" selected>Development</option>
            <option value="IT and Software">IT and Software</option>
            <option value="Machine Learning">Machine Learning</option>
            <option value="Network and Security">Network and Security</option>
            <option value="Operating System">Operating System</option>
            <option value="Programming Languages">Programming Languages</option>
            <option value="Others">Others</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold" for="price">Harga (Rp)</label>
          <input class="form-control" id="price" name="price" type="number" min="0" value="0" placeholder="Contoh: 50000" required>
          <div class="form-text">Isi 0 jika buku ini gratis.</div>
        </div>

        <div class="col-12">
          <label class="form-label fw-semibold" for="link">Tautan eBook</label>
          <div class="input-group">
            <span class="input-group-text">https://</span>
            <input class="form-control" id="link" name="link" type="text" placeholder="w3schools.com/php/default.asp" maxlength="255" required>
          </div>
        </div>

        <div class="col-12">
          <label class="form-label fw-semibold" for="cover">Cover <span class="fw-light text-muted">(Opsional)</span></label>
          <input class="form-control" id="cover" name="cover" type="file" accept=".jpg, .jpeg, .png" onchange="validateUploadCover()">
          <div class="form-text">Maksimum 1 MB. Format: JPG, JPEG, PNG.</div>
        </div>

        <div class="col-12 mt-4 text-center">
          <button class="btn btn-primary btn-lg fw-bold" name="submit" type="submit">
            <i class="bi bi-plus-circle-fill me-2"></i>Simpan Buku
          </button>
        </div>

      </form>
    </div>
  </div>
</div>

<?php include 'partials/footer.php'; ?>