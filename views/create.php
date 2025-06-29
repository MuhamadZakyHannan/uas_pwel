<?php
$title = 'Add eBook - eBook Apps';
include 'partials/header.php';
include 'partials/navbar.php';
?>

<main class="container my-3 p-3 px-lg-5">
  <h1 class="text-center fs-3 fw-bold">Add eBook</h1>
  <h2 class="text-center fs-6 mb-4">Please enter the required information below</h2>
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
        <option value="Development" selected>Development</option>
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
        <span class="input-group-text">https://</span>
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
      <label class="form-label" for="price">Harga (Rp)</label>
      <input class="form-control" id="price" name="price" type="number" min="0" value="0" placeholder="Contoh: 50000" required>
      <div class="form-text">Isi 0 jika buku ini gratis.</div>
    </div>
    <div class="col-md-12 col-lg-10 mt-4 text-center">
      <button class="btn btn-primary fw-semibold" name="submit" type="submit">Submit</button>
    </div>
  </form>
</main>

<footer class="bg-dark text-light px-0 py-4 p-sm-4">
  <div class="container text-center">
    <p class="mb-0">&copy; <?= date('Y') ?> Bukoo. All rights reserved.</p>
  </div>
</footer>
<?php include 'partials/footer.php'; ?>