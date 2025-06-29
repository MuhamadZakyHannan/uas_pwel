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

  public function index()
  {
    // AuthController::checkUserLogin(); // <-- BARIS INI DIHAPUS
    $ebookPerPage = 10;
    $totalEbook = $this->ebookModel->countAll();
    $totalPage = ceil($totalEbook / $ebookPerPage);
    $activePage = $_GET['page'] ?? 1;
    $index = $ebookPerPage * $activePage - $ebookPerPage;
    $ebooks = $this->ebookModel->getAll($index, $ebookPerPage);

    require 'views/list.php';
  }

  public function search()
  {
    // AuthController::checkUserLogin(); // <-- BARIS INI JUGA DIHAPUS
    $keyword = htmlspecialchars($_GET['keyword'] ?? '');
    $ebookPerPage = 10;
    $totalEbook = $this->ebookModel->countSearch($keyword);
    $totalPage = ceil($totalEbook / $ebookPerPage);
    $activePage = $_GET['page'] ?? 1;
    $index = $ebookPerPage * $activePage - $ebookPerPage;
    $ebooks = $this->ebookModel->search($keyword, $index, $ebookPerPage);

    // Cek jika ini adalah request AJAX untuk live search
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      require 'views/ajax/search.php';
    } else {
      require 'views/list.php';
    }
  }

  public function create()
  {
    AuthController::checkUserLogin(); // <-- TETAP ADA (Wajib Login)
    require 'views/create.php';
  }

  public function store()
  {
    AuthController::checkUserLogin(); // <-- TETAP ADA (Wajib Login)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $result = $this->ebookModel->create($_POST, $_FILES);
      if ($result > 0) {
        header('Location: index.php?action=list&status=create_success');
      } else {
        header('Location: index.php?action=list&status=create_failed');
      }
      exit();
    }
  }

  public function edit()
  {
    AuthController::checkUserLogin(); // <-- TETAP ADA (Wajib Login)
    AuthController::checkUserRole(); // <-- Peran admin juga dicek
    if (!isset($_GET['id'])) {
      header('Location: index.php?action=list');
      exit();
    }
    $ebook = $this->ebookModel->findById($_GET['id']);
    require 'views/update.php';
  }

  public function update()
  {
    AuthController::checkUserLogin(); // <-- TETAP ADA (Wajib Login)
    AuthController::checkUserRole();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $result = $this->ebookModel->update($_POST, $_FILES);
      if ($result > 0) {
        header('Location: index.php?action=edit&id=' . $_POST['id'] . '&status=update_success');
      } elseif ($result === 0) {
        header('Location: index.php?action=edit&id=' . $_POST['id'] . '&status=no_update');
      } else {
        header('Location: index.php?action=edit&id=' . $_POST['id'] . '&status=update_failed');
      }
      exit();
    }
  }

  public function delete()
  {
    AuthController::checkUserLogin(); // <-- TETAP ADA (Wajib Login)
    AuthController::checkUserRole();
    if (!isset($_GET['id'])) {
      header('Location: index.php?action=list');
      exit();
    }
    $result = $this->ebookModel->delete($_GET['id']);
    if ($result > 0) {
      header('Location: index.php?action=list&status=delete_success');
    } else {
      header('Location: index.php?action=list&status=delete_failed');
    }
    exit();
  }
}
