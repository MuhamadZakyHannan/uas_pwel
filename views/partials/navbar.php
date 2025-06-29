<?php
// LOGIKA BARU: Hitung jumlah item unik dengan count()
$uniqueItemCount = isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php?action=home">
      <img class="me-2" src="assets/img/logo_bukoo.png" style="width: 35px;">
      <span class="fw-bold fs-4 text-info">Bukoo</span>
    </a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php?action=home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?action=list">Koleksi</a></li>
        <?php if (isset($_SESSION['username'])): ?>
          <li class="nav-item"><a class="nav-link" href="index.php?action=create">Tambah eBook</a></li>
        <?php endif; ?>
      </ul>
      <form class="d-flex w-50 me-auto" action="index.php" method="GET" id="search-form-nav">
        <input type="hidden" name="action" value="search">
        <input class="form-control" type="search" name="keyword" id="keyword-nav" placeholder="Cari judul buku...">
      </form>
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=cart">
            <i class="bi bi-cart-fill fs-5"></i>
            <span class="badge rounded-pill bg-danger" id="cart-count"><?= $uniqueItemCount ?></span>
          </a>
        </li>
        <?php if (isset($_SESSION['username'])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><?= htmlspecialchars($_SESSION['username']) ?></a>
            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
              <li><a class="dropdown-item text-danger" href="index.php?action=logout">Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item ms-lg-2"><a class="btn btn-outline-info btn-sm" href="index.php?action=login">Sign In</a></li>
          <li class="nav-item ms-lg-2 mt-2 mt-lg-0"><a class="btn btn-info btn-sm" href="index.php?action=signup">Sign Up</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>