<?php

require_once __DIR__ . '/../config/database.php';

class Ebook
{
  public function getAll($index = null, $limit = null)
  {
    $conn = connect();
    $query = "SELECT * FROM ebooks ORDER BY id DESC";
    if ($index !== null && $limit !== null) {
      $query .= " LIMIT $index, $limit";
    }
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
  }

  public function countAll()
  {
    $conn = connect();
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM ebooks");
    return mysqli_fetch_assoc($result)['total'];
  }

  public function findById($id)
  {
    $conn = connect();
    $id = mysqli_real_escape_string($conn, $id);
    $result = mysqli_query($conn, "SELECT * FROM ebooks WHERE id = $id");
    return mysqli_fetch_assoc($result);
  }

  public function create($data, $files)
  {
    $conn = connect();
    $username = $_SESSION['username'];
    $title = htmlspecialchars($data['title']);
    $author = htmlspecialchars($data['author']);
    $category = htmlspecialchars($data['category']);
    $price = (int)htmlspecialchars($data['price'] ?? 0);
    $type = ($price > 0) ? 'Paid' : 'Free'; // Tipe ditentukan otomatis dari harga
    $link = htmlspecialchars($data['link']);
    $cover = $this->uploadCover($files['cover']);

    if ($cover === false) return false;
    if (is_null($cover)) $cover = 'default-cover.jpg';
    if (!filter_var($link, FILTER_VALIDATE_URL)) $link = "https://$link";

    $query = "INSERT INTO ebooks (added_by, title, author, category, type, price, link, cover, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Verified')";
    $stmt = mysqli_prepare($conn, $query);

    // Error handling jika query gagal
    if ($stmt === false) {
      die('MySQL prepare error: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ssssisss", $username, $title, $author, $category, $type, $price, $link, $cover);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_affected_rows($stmt);
  }

  public function update($data, $files)
  {
    $conn = connect();
    $id = htmlspecialchars($data['id']);
    $title = htmlspecialchars($data['title']);
    $author = htmlspecialchars($data['author']);
    $category = htmlspecialchars($data['category']);
    $price = (int)htmlspecialchars($data['price'] ?? 0);
    $type = ($price > 0) ? 'Paid' : 'Free';
    $link = htmlspecialchars($data['link']);
    $status = htmlspecialchars($data['status']);
    $oldCover = htmlspecialchars($data['oldCover']);
    $cover = $this->uploadCover($files['cover']);

    if (is_null($cover)) $cover = $oldCover;
    elseif ($cover === false) return false;

    $query = "UPDATE ebooks SET title = ?, author = ?, category = ?, type = ?, price = ?, link = ?, status = ?, cover = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt === false) {
      die('MySQL prepare error: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ssssisssi", $title, $author, $category, $type, $price, $link, $status, $cover, $id);
    mysqli_stmt_execute($stmt);

    $affected_rows = mysqli_stmt_affected_rows($stmt);
    if ($affected_rows > 0 && $cover !== $oldCover && $oldCover !== 'default-cover.jpg') {
      unlink("assets/img/ebook/$oldCover");
    }

    return $affected_rows;
  }

  public function delete($id)
  {
    $conn = connect();
    $id = htmlspecialchars($id);
    $ebook = $this->findById($id);
    if ($ebook) {
      $cover = $ebook['cover'];
      mysqli_query($conn, "DELETE FROM ebooks WHERE id = $id");
      $affected_rows = mysqli_affected_rows($conn);

      if ($affected_rows > 0 && $cover !== 'default-cover.jpg' && file_exists("assets/img/ebook/$cover")) {
        unlink("assets/img/ebook/$cover");
      }
      return $affected_rows;
    }
    return 0;
  }

  public function search($keyword, $index = null, $limit = null)
  {
    $conn = connect();
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $query = "SELECT * FROM ebooks WHERE title LIKE '%$keyword%' OR author LIKE '%$keyword%' OR category LIKE '%$keyword%' ORDER BY id DESC";
    if ($index !== null && $limit !== null) {
      $query .= " LIMIT $index, $limit";
    }
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
  }

  public function countSearch($keyword)
  {
    $conn = connect();
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM ebooks WHERE title LIKE '%$keyword%' OR author LIKE '%$keyword%' OR category LIKE '%$keyword%'");
    return mysqli_fetch_assoc($result)['total'];
  }

  private function uploadCover($coverFile)
  {
    if (!isset($coverFile) || $coverFile['error'] === 4) return null;
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $coverExtension = strtolower(pathinfo($coverFile['name'], PATHINFO_EXTENSION));
    if (!in_array($coverExtension, $allowedExtensions) || $coverFile['size'] > 1048576) return false;
    $newCoverName = uniqid('cover-') . '.' . $coverExtension;
    move_uploaded_file($coverFile['tmp_name'], 'assets/img/ebook/' . $newCoverName);
    return $newCoverName;
  }
}
