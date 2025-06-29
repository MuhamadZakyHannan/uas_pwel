<?php
$title = 'Update eBook - eBook Apps';
include 'partials/header.php';
include 'partials/navbar.php';
?>

<main class="container my-3 p-3 px-lg-5">
  <h1 class="text-center fs-3 fw-bold">Update eBook</h1>
  <h2 class="text-center fs-6 mb-4">Please enter the required information below</h2>
  <form class="row justify-content-center" action="index.php?action=update" method="POST" enctype="multipart/form-data" autocomplete="off">
    <div class="col-md-3 text-center">
      <figure class="figure">
        <img class="figure-img img-thumbnail" src="assets/img/ebook/<?= $ebook['cover'] ?>" alt="Cover <?= $ebook['title'] ?>">
        <figcaption class="figure-caption">
          <input class="form-control-plaintext text-center" id="oldCover" name="oldCover" type="text" value="<?= $ebook['cover'] ?>" required readonly>
        </figcaption>
      </figure>
    </div>
    <div class="col-md-9">
      <div class="row g-3">
        <div class="col-md-2">
          <label class="form-label" for="id">ID</label>
          <input class="form-control" id="id" name="id" type="text" value="<?= $ebook['id'] ?>" required readonly>
        </div>
        <div class="col-md-10">
          <label class="form-label" for="title">Title</label>
          <input class="form-control" id="title" name="title" type="text" value="<?= $ebook['title'] ?>" maxlength="255" autofocus required>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="author">Author</label>
          <input class="form-control" id="author" name="author" type="text" value="<?= $ebook['author'] ?>" maxlength="100" required>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="category">Category</label>
          <select class="form-select" id="category" name="category">
            <option <?= $ebook['category'] === 'Artificial Intelligence' ? 'selected' : '' ?> value="Artificial Intelligence">Artificial Intelligence</option>
            <option <?= $ebook['category'] === 'Computer Science' ? 'selected' : '' ?> value="Computer Science">Computer Science</option>
            <option <?= $ebook['category'] === 'Cyber Security' ? 'selected' : '' ?> value="Cyber Security">Cyber Security</option>
            <option <?= $ebook['category'] === 'Data Science' ? 'selected' : '' ?> value="Data Science">Data Science</option>
            <option <?= $ebook['category'] === 'Design' ? 'selected' : '' ?> value="Design">Design</option>
            <option <?= $ebook['category'] === 'Development' ? 'selected' : '' ?> value="Development">Development</option>
            <option <?= $ebook['category'] === 'IT and Software' ? 'selected' : '' ?> value="IT and Software">IT and Software</option>
            <option <?= $ebook['category'] === 'Machine Learning' ? 'selected' : '' ?> value="Machine Learning">Machine Learning</option>
            <option <?= $ebook['category'] === 'Network and Security' ? 'selected' : '' ?> value="Network and Security">Network and Security</option>
            <option <?= $ebook['category'] === 'Operating System' ? 'selected' : '' ?> value="Operating System">Operating System</option>
            <option <?= $ebook['category'] === 'Programming Languages' ? 'selected' : '' ?> value="Programming Languages">Programming Languages</option>
            <option <?= $ebook['category'] === 'Others' ? 'selected' : '' ?> value="Others">Others</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="link">Link</label>
          <input class="form-control" id="link" name="link" type="text" value="<?= $ebook['link'] ?>" maxlength="255" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Type</label>
          <div class="row align-items-center mt-md-2">
            <div class="col-2 form-check form-check-inline ms-3">
              <input class="form-check-input" id="free" name="type" type="radio" <?= $ebook['type'] === 'Free' ? 'checked' : '' ?> value="Free">
              <label class="form-check-label" for="free">Free</label>
            </div>
            <div class="col-2 form-check form-check-inline">
              <input class="form-check-input" id="paid" name="type" type="radio" <?= $ebook['type'] === 'Paid' ? 'checked' : '' ?> value="Paid">
              <label class="form-check-label" for="paid">Paid</label>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="cover">
            Cover <span class="fw-light">(Optional)</span>
          </label>
          <input class="form-control" id="cover" name="cover" type="file" accept=".jpg, .jpeg, .png" onchange="validateUploadCover()">
          <div class="form-text" id="coverInfo">Maximum File Size: 1 MB, Format File: jpg, jpeg, png</div>
        </div>
        <div class="col-md-6">
          <label class="form-label">Status</label>
          <div class="row align-items-center mt-md-2">
            <div class="col-3 form-check form-check-inline ms-3">
              <input class="form-check-input" id="verified" name="status" type="radio" <?= $ebook['status'] === 'Verified' ? 'checked' : '' ?> value="Verified">
              <label class="form-check-label" for="verified">Verified</label>
            </div>
            <div class="col-3 form-check form-check-inline">
              <input class="form-check-input" id="unverified" name="status" type="radio" <?= $ebook['status'] === 'Unverified' ? 'checked' : '' ?> value="Unverified">
              <label class="form-check-label" for="unverified">Unverified</label>
            </div>
          </div>
        </div>
        <div class="col-md-12 mt-4 text-center">
          <button class="btn btn-primary fw-semibold" name="submit" type="submit">Submit</button>
        </div>
      </div>
    </div>
  </form>
</main>

<footer class="bg-dark text-light px-0 py-4 p-sm-4">
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
</footer>

<?php include 'partials/footer.php'; ?>