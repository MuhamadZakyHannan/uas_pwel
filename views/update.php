<?php
$title = 'Update eBook - eBook Apps';
include 'partials/header.php';
include 'partials/navbar.php';
?>

<main class="container my-3 p-3 px-lg-5">
  <h1 class="text-center fs-3 fw-bold">Update eBook</h1>
  <form class="row justify-content-center" action="index.php?action=update" method="POST" enctype="multipart/form-data" autocomplete="off">
    <div class="col-md-3 text-center">
      <img class="img-fluid rounded" src="assets/img/ebook/<?= htmlspecialchars($ebook['cover']) ?>">
      <input name="oldCover" type="hidden" value="<?= htmlspecialchars($ebook['cover']) ?>">
      <input name="id" type="hidden" value="<?= htmlspecialchars($ebook['id']) ?>">
    </div>
    <div class="col-md-9">
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label" for="title">Title</label>
          <input class="form-control" id="title" name="title" type="text" value="<?= htmlspecialchars($ebook['title']) ?>" required>
        </div>
        <div class="col-12">
          <label for="description" class="form-label">Deskripsi Buku</label>
          <textarea class="form-control" id="description" name="description" rows="4"><?= htmlspecialchars($ebook['description'] ?? '') ?></textarea>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="author">Author</label>
          <input class="form-control" id="author" name="author" type="text" value="<?= htmlspecialchars($ebook['author']) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="year">Tahun Terbit</label>
          <input class="form-control" id="year" name="year" type="number" value="<?= htmlspecialchars($ebook['year'] ?? '') ?>" min="1900" max="<?= date('Y') ?>">
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
          <label class="form-label" for="price">Harga (Rp)</label>
          <input class="form-control" id="price" name="price" type="number" min="0" value="<?= htmlspecialchars($ebook['price'] ?? 0) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="link">Link</label>
          <input class="form-control" id="link" name="link" type="text" value="<?= htmlspecialchars($ebook['link']) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Status</label>
          <div class="pt-2">
            <div class="form-check form-check-inline">
              <input class="form-check-input" id="verified" name="status" type="radio" <?= $ebook['status'] === 'Verified' ? 'checked' : '' ?> value="Verified">
              <label class="form-check-label" for="verified">Verified</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" id="unverified" name="status" type="radio" <?= $ebook['status'] === 'Unverified' ? 'checked' : '' ?> value="Unverified">
              <label class="form-check-label" for="unverified">Unverified</label>
            </div>
          </div>
        </div>
        <div class="col-12 mt-4 text-center">
          <button class="btn btn-warning fw-semibold" name="submit" type="submit">Update</button>
        </div>
      </div>
    </div>
  </form>
</main>
<?php include 'partials/footer.php'; ?>