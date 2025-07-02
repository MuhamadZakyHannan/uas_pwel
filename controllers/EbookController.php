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
    $ebookPerPage = 6;
    $totalEbook = $this->ebookModel->countAll();
    $totalPage = ceil($totalEbook / $ebookPerPage);
    $activePage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $index = ($activePage - 1) * $ebookPerPage;
    $ebooks = $this->ebookModel->getAll($index, $ebookPerPage);

    $keyword = '';
    require 'views/list.php';
  }

  public function search()
  {
    $keyword = htmlspecialchars($_GET['keyword'] ?? '');
    $ebookPerPage = 6;
    $totalEbook = $this->ebookModel->countSearch($keyword);
    $totalPage = ceil($totalEbook / $ebookPerPage);
    $activePage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $index = ($activePage - 1) * $ebookPerPage;
    $ebooks = $this->ebookModel->search($keyword, $index, $ebookPerPage);

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      require 'views/ajax_search_results.php';
    } else {
      require 'views/list.php';
    }
  }

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

  public function create()
  {
    AuthController::checkUserLogin();
    AuthController::checkUserRole();
    require 'views/create.php';
  }

  public function store()
  {
    AuthController::checkUserLogin();
    AuthController::checkUserRole();

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
    AuthController::checkUserLogin();
    AuthController::checkUserRole();
    if (!isset($_GET['id'])) {
      header('Location: index.php?action=list');
      exit();
    }
    $ebook = $this->ebookModel->findById((int)$_GET['id']);
    require 'views/update.php';
  }

  public function update()
  {
    AuthController::checkUserLogin();
    AuthController::checkUserRole();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $result = $this->ebookModel->update($_POST, $_FILES);
      if ($result >= 0) {
        header('Location: index.php?action=list&status=update_success');
      } else {
        header('Location: index.php?action=edit&id=' . $_POST['id'] . '&status=update_failed');
      }
      exit();
    }
  }

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
