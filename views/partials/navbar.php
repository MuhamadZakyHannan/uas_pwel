<?php
$action = $_GET['action'] ?? 'home';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php?action=home">
      <img class="me-2" src="assets/img/logo_bukoo.png" alt="Logo Bukoo" style="width: 35px;">
      <span class="fw-bold fs-4 text-info">Bukoo</span>
    </a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav" type="button" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?= ($action === 'home') ? 'active' : '' ?>" href="index.php?action=home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($action === 'list' || $action === 'search') ? 'active' : '' ?>" href="index.php?action=list">Koleksi</a>
        </li>
        <?php if (isset($_SESSION['username'])): ?>
          <li class="nav-item">
            <a class="nav-link <?= ($action === 'create') ? 'active' : '' ?>" href="index.php?action=create">Tambah eBook</a>
          </li>
        <?php endif; ?>
      </ul>

      <?php if ($action === 'list' || $action === 'search'): ?>
        <form class="d-flex" action="index.php" method="GET" autocomplete="off">
          <input type="hidden" name="action" value="search">
          <input class="form-control me-2" id="keyword" name="keyword" type="search" value="<?= isset($keyword) ? htmlspecialchars($keyword) : '' ?>" placeholder="Cari buku...">
        </form>
      <?php endif; ?>

      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <?php if (isset($_SESSION['username'])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle me-2 fs-5"></i>
              <?= htmlspecialchars($_SESSION['username']) ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="navbarUserDropdown">
              <li><a class="dropdown-item text-danger" href="index.php?action=logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item ms-lg-2">
            <a class="btn btn-outline-info btn-sm" href="index.php?action=login">Sign In</a>
          </li>
          <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
            <a class="btn btn-info btn-sm" href="index.php?action=signup">Sign Up</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>