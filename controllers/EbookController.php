<?php

require_once 'models/Ebook.php';
require_once 'controllers/AuthController.php';

class EbookController
{
  private $ebookModel;

  public function __construct()
  {
    $this->ebookModel = new Ebook();
  }

  /**
   * Menampilkan halaman utama daftar buku dengan paginasi.
   */
  public function index()
  {
    // Mengatur item per halaman menjadi 6
    $ebookPerPage = 6;
    $totalEbook = $this->ebookModel->countAll();
    $totalPage = ceil($totalEbook / $ebookPerPage);
    $activePage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $index = ($activePage - 1) * $ebookPerPage;
    $ebooks = $this->ebookModel->getAll($index, $ebookPerPage);

    // Inisialisasi keyword agar tidak error di view saat halaman list biasa dimuat
    $keyword = '';

    require 'views/list.php';
  }

  /**
   * Menangani pencarian buku, baik untuk request biasa maupun AJAX.
   */
  public function search()
  {
    $keyword = htmlspecialchars($_GET['keyword'] ?? '');
    $ebookPerPage = 6;
    $totalEbook = $this->ebookModel->countSearch($keyword);
    $totalPage = ceil($totalEbook / $ebookPerPage);
    $activePage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $index = ($activePage - 1) * $ebookPerPage;
    $ebooks = $this->ebookModel->search($keyword, $index, $ebookPerPage);

    // Cek jika request datang dari JavaScript (AJAX)
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      // Jika ya, hanya kirim file hasil pencarian (tanpa header/footer)
      require 'views/ajax_search_results.php';
    } else {
      // Jika tidak, muat halaman lengkap seperti biasa
      require 'views/list.php';
    }
  }

  /**
   * Menampilkan halaman detail satu buku.
   */
  public function detail()
  {
    if (!isset($_GET['id'])) {
      header('Location: index.php?action=list');
      exit();
    }

    $ebook = $this->ebookModel->findById((int)$_GET['id']);

    if (!$ebook) {
      header('Location: index.php?action=list');
      exit();
    }

    require 'views/detail.php';
  }

  /**
   * Menampilkan form untuk membuat eBook baru.
   */
  public function create()
  {
    AuthController::checkUserLogin();
    require 'views/create.php';
  }

  /**
   * Memproses data dari form dan menyimpan eBook baru.
   */
  public function store()
  {
    AuthController::checkUserLogin();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (!validate_csrf_token()) die('Invalid CSRF token');

      $result = $this->ebookModel->create($_POST, $_FILES);
      unset_csrf_token();

      if ($result > 0) {
        header('Location: index.php?action=list&status=create_success');
      } else {
        header('Location: index.php?action=list&status=create_failed');
      }
      exit();
    }
  }

  /**
   * Menampilkan form untuk mengedit eBook.
   */
  public function edit()
  {
    AuthController::checkUserLogin();
    AuthController::checkUserRole();
    if (!isset($_GET['id'])) {
      header('Location: index.php?action=list');
      exit();
    }
    $ebook = $this->ebookModel->findById((int)$_GET['id']);
    require 'views/update.php';
  }

  /**
   * Memproses data dari form dan memperbarui eBook.
   */
  public function update()
  {
    AuthController::checkUserLogin();
    AuthController::checkUserRole();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (!validate_csrf_token()) die('Invalid CSRF token');

      $result = $this->ebookModel->update($_POST, $_FILES);
      unset_csrf_token();

      if ($result >= 0) {
        header('Location: index.php?action=list&status=update_success');
      } else {
        header('Location: index.php?action=edit&id=' . $_POST['id'] . '&status=update_failed');
      }
      exit();
    }
  }

  /**
   * Menghapus eBook.
   */
  public function delete()
  {
    AuthController::checkUserLogin();
    AuthController::checkUserRole();
    if (!isset($_GET['id'])) {
      header('Location: index.php?action=list');
      exit();
    }
    $result = $this->ebookModel->delete((int)$_GET['id']);
    if ($result > 0) {
      header('Location: index.php?action=list&status=delete_success');
    } else {
      header('Location: index.php?action=list&status=delete_failed');
    }
    exit();
  }
}
