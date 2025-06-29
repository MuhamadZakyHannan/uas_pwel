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
    $type = htmlspecialchars($data['type']);
    $link = htmlspecialchars($data['link']);
    $cover = $this->uploadCover($files['cover']);

    if (empty($title) || empty($author) || empty($category) || empty($type) || empty($link)) {
      return false;
    }

    if ($cover === false) {
      return false;
    }

    if (is_null($cover)) {
      $cover = 'default-cover.jpg';
    }

    if (!filter_var($link, FILTER_VALIDATE_URL)) {
      $link = "https://$link";
    } else {
      $link = str_replace('http://', 'https://', $link);
    }

    mysqli_query($conn, "INSERT INTO ebooks (added_by, title, author, category, type, link, cover) VALUES ('$username', '$title', '$author', '$category', '$type', '$link', '$cover')");

    if (mysqli_affected_rows($conn) < 0 && $cover !== 'default-cover.jpg') {
      unlink("assets/img/ebook/$cover");
    }

    return mysqli_affected_rows($conn);
  }

  public function update($data, $files)
  {
    $conn = connect();
    $id = htmlspecialchars($data['id']);
    $title = htmlspecialchars($data['title']);
    $author = htmlspecialchars($data['author']);
    $category = htmlspecialchars($data['category']);
    $type = htmlspecialchars($data['type']);
    $link = htmlspecialchars($data['link']);
    $status = htmlspecialchars($data['status']);
    $oldCover = htmlspecialchars($data['oldCover']);

    $cover = $this->uploadCover($files['cover']);

    if (empty($id) || empty($title) || empty($author) || empty($category) || empty($type) || empty($link) || empty($status) || empty($oldCover)) {
      return false;
    }

    if (is_null($cover)) {
      $cover = $oldCover;
    } elseif ($cover === false) {
      return false;
    }

    if (!filter_var($link, FILTER_VALIDATE_URL) && !str_contains($link, 'https://')) {
      $link = "https://$link";
    } else {
      $link = str_replace('http://', 'https://', $link);
    }

    mysqli_query($conn, "UPDATE ebooks SET title = '$title', author = '$author', category = '$category', type = '$type', link = '$link', status = '$status', cover = '$cover' WHERE id = $id");

    $affected_rows = mysqli_affected_rows($conn);

    if ($affected_rows > 0 && $cover !== $oldCover && $oldCover !== 'default-cover.jpg') {
      unlink("assets/img/ebook/$oldCover");
    } elseif ($affected_rows < 0 && $cover !== $oldCover) {
      unlink("assets/img/ebook/$cover");
    }

    return $affected_rows;
  }

  public function delete($id)
  {
    $conn = connect();
    $id = htmlspecialchars($id);
    $ebook = $this->findById($id);
    $cover = $ebook['cover'];

    mysqli_query($conn, "DELETE FROM ebooks WHERE id = $id");
    $affected_rows = mysqli_affected_rows($conn);

    if ($affected_rows > 0 && $cover !== 'default-cover.jpg') {
      unlink("assets/img/ebook/$cover");
    }
    return $affected_rows;
  }

  public function search($keyword, $index = null, $limit = null)
  {
    $conn = connect();
    $query = "SELECT * FROM ebooks WHERE title LIKE '%$keyword%' OR author LIKE '%$keyword%' OR category LIKE '%$keyword%' OR type LIKE '%$keyword%' OR status LIKE '%$keyword%' ORDER BY id DESC";
    if ($index !== null && $limit !== null) {
      $query .= " LIMIT $index, $limit";
    }
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
  }

  public function countSearch($keyword)
  {
    $conn = connect();
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM ebooks WHERE title LIKE '%$keyword%' OR author LIKE '%$keyword%' OR category LIKE '%$keyword%' OR type LIKE '%$keyword%' OR status LIKE '%$keyword%'");
    return mysqli_fetch_assoc($result)['total'];
  }

  private function uploadCover($coverFile)
  {
    $coverName = $coverFile['name'];
    $coverType = $coverFile['type'];
    $coverTmpName = $coverFile['tmp_name'];
    $coverError = $coverFile['error'];
    $coverSize = $coverFile['size'];

    if ($coverError === 4) {
      return null; // Tidak ada file yang diunggah
    }

    $coverExtension = strtolower(pathinfo($coverName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png'];

    if (!in_array($coverExtension, $allowedExtensions) || ($coverType !== 'image/jpeg' && $coverType !== 'image/png') || $coverSize > 1048576) {
      return false; // Validasi gagal
    }

    $newId = $this->getNewId();

    if ($newId < 10) {
      $newCoverName = 'IMG-' . date('dmY') . "-EA00$newId.$coverExtension";
    } elseif ($newId < 100) {
      $newCoverName = 'IMG-' . date('dmY') . "-EA0$newId.$coverExtension";
    } else {
      $newCoverName = 'IMG-' . date('dmY') . "-EA$newId.$coverExtension";
    }

    $pathFile = "assets/img/ebook/$newCoverName";

    if (file_exists($pathFile)) {
      return false; // File sudah ada
    }

    move_uploaded_file($coverTmpName, $pathFile);
    return $newCoverName;
  }

  private function getNewId()
  {
    $conn = connect();
    $result = mysqli_query($conn, "SELECT cover FROM ebooks ORDER BY id DESC");
    $ebooks = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (!empty($ebooks)) {
      foreach ($ebooks as $ebook) {
        if (strpos($ebook['cover'], 'IMG') !== false) {
          $cover = $ebook['cover'];
          break;
        }
      }
      if (isset($cover)) {
        $coverParts = explode('-', $cover);
        $coverDate = $coverParts[1] ?? null;
        $coverIdPart = $coverParts[2] ?? null;

        if ($coverDate === date('dmY') && $coverIdPart) {
          $newId = (int)explode('EA', $coverIdPart)[1] + 1;
        } else {
          $newId = 1;
        }
      } else {
        $newId = 1;
      }
    } else {
      $newId = 1;
    }
    return $newId;
  }
}
