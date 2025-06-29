<?php
$title = 'Add eBook - eBook Apps';
include 'partials/header.php';
include 'partials/navbar.php';

?>


<main class="container my-3 p-3 px-lg-5">
  <h1 class="text-center fs-3 fw-bold">Tambah buku</h1>
  <h2 class="text-center fs-6 mb-4">Tambahkan Info Buku Sesuai Dengan Tabel yang disediakan</h2>
  <form class="row justify-content-center g-3" action="index.php?action=store" method="POST" enctype="multipart/form-data" autocomplete="off">
    <div class="col-md-12 col-lg-10">
      <label class="form-label" for="title">Title</label>
      <input class="form-control" id="title" name="title" type="text" placeholder="Tutorial Programming" maxlength="255" autofocus required>
    </div>
    <div class="col-md-6 col-lg-5">
      <label class="form-label" for="author">Author</label>
      <input class="form-control" id="author" name="author" type="text" placeholder="W3Schools" maxlength="100" required>
    </div>
    <div class="col-md-6 col-lg-5">
      <label class="form-label" for="category">Category</label>
      <select class="form-select" id="category" name="category">
        <option value="Artificial Intelligence">Artificial Intelligence</option>
        <option value="Computer Science">Computer Science</option>
        <option value="Cyber Security">Cyber Security</option>
        <option value="Data Science">Data Science</option>
        <option value="Design">Design</option>
        <option value="Development">Development</option>
        <option value="IT and Software">IT and Software</option>
        <option value="Machine Learning">Machine Learning</option>
        <option value="Network and Security">Network and Security</option>
        <option value="Operating System">Operating System</option>
        <option value="Programming Languages">Programming Languages</option>
        <option value="Others">Others</option>
      </select>
    </div>
    <div class="col-md-12 col-lg-10">
      <label class="form-label" for="link">Link</label>
      <div class="input-group">
        <div class="input-group-text">https://</div>
        <input class="form-control" id="link" name="link" type="text" placeholder="w3schools.com" maxlength="255" required>
      </div>
    </div>
    <div class="col-md-6 col-lg-5">
      <label class="form-label" for="cover">
        Cover <span class="fw-light">(Optional)</span>
      </label>
      <input class="form-control" id="cover" name="cover" type="file" accept=".jpg, .jpeg, .png" onchange="validateUploadCover()">
      <div class="form-text" id="coverInfo">Maximum File Size: 1 MB, Format File: jpg, jpeg, png</div>
    </div>
    <div class="col-md-6 col-lg-5">
      <label class="form-label">Type</label>
      <div class="row align-items-center mt-md-2">
        <div class="col-2 form-check form-check-inline ms-3">
          <input class="form-check-input" id="free" name="type" type="radio" value="Free" checked>
          <label class="form-check-label" for="free">Free</label>
        </div>
        <div class="col-2 form-check form-check-inline">
          <input class="form-check-input" id="paid" name="type" type="radio" value="Paid">
          <label class="form-check-label" for="paid">Paid</label>
        </div>
      </div>
    </div>
    <div class="col-md-12 col-lg-10 mt-4 text-center">
      <button class="btn btn-primary fw-semibold" name="submit" type="submit">Submit</button>
    </div>
  </form>
</main>


<footer class="home-footer py-5 bg-dark text-white">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 mb-4">
        <h5 class="fw-bold text-info mb-3">Bukoo</h5>
        <p class="text-white-50">Gerbang Anda menuju dunia buku digital. Baca, belajar, dan jelajahi dengan platform eBook modern kami.</p>
      </div>

      <div class="col-lg-2 col-md-6 mb-4">
        <h6 class="fw-bold mb-3">Tautan</h6>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="index.php?action=home" class="text-white-50 text-decoration-none">Home</a></li>
          <li class="mb-2"><a href="index.php?action=list" class="text-white-50 text-decoration-none">Koleksi</a></li>
          <?php if (isset($_SESSION['username'])): ?>
            <li class="mb-2"><a href="index.php?action=create" class="text-white-50 text-decoration-none">Tambah Buku</a></li>
          <?php else: ?>
            <li class="mb-2"><a href="index.php?action=login" class="text-white-50 text-decoration-none">Sign In</a></li>
          <?php endif; ?>
        </ul>
      </div>

      <div class="col-lg-2 col-md-6 mb-4">
        <h6 class="fw-bold mb-3">Legal</h6>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Terms of Use</a></li>
          <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Privacy Policy</a></li>
        </ul>
      </div>

      <div class="col-lg-4 mb-4">
        <h6 class="fw-bold mb-3">Hubungi Kami</h6>
        <p class="text-white-50 mb-2"><i class="bi bi-envelope-fill me-2"></i>support@bukoo.com</p>
        <p class="text-white-50 mb-0"><i class="bi bi-geo-alt-fill me-2"></i>Depok, Yogyakarta, Indonesia</p>
      </div>
    </div>
    <hr class="border-secondary my-4">
    <div class="row align-items-center">
      <div class="col-md-6">
        <p class="text-white-50 mb-0">&copy; <?= date('Y') ?> Bukoo. All rights reserved.</p>
      </div>
      <div class="col-md-6 text-md-end social-links">
        <a href="#" class="text-white-50 text-decoration-none me-3"><i class="bi bi-facebook fs-5"></i></a>
        <a href="#" class="text-white-50 text-decoration-none me-3"><i class="bi bi-twitter fs-5"></i></a>
        <a href="#" class="text-white-50 text-decoration-none"><i class="bi bi-instagram fs-5"></i></a>
      </div>
    </div>
  </div>
</footer>
<?php include 'partials/footer.php'; ?>