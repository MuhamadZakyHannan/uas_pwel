<?php
session_start();

require_once 'config/database.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/EbookController.php';
require_once 'controllers/AuthController.php';

$action = $_GET['action'] ?? 'home';

switch ($action) {
  // Auth Routes
  case 'login':
    $controller = new AuthController();
    $controller->login();
    break;
  case 'signup':
    $controller = new AuthController();
    $controller->signup();
    break;
  case 'logout':
    $controller = new AuthController();
    $controller->logout();
    break;

  // Ebook Routes
  case 'list':
    $controller = new EbookController();
    $controller->index();
    break;
  case 'create':
    $controller = new EbookController();
    $controller->create();
    break;
  case 'store':
    $controller = new EbookController();
    $controller->store();
    break;
  case 'edit':
    $controller = new EbookController();
    $controller->edit();
    break;
  case 'update':
    $controller = new EbookController();
    $controller->update();
    break;
  case 'delete':
    $controller = new EbookController();
    $controller->delete();
    break;
  case 'search':
    $controller = new EbookController();
    $controller->search();
    break;

  // Home Route
  case 'home':
  default:
    $controller = new HomeController();
    $controller->index();
    break;
}
