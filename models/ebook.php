<?php

require_once __DIR__ . '/../config/database.php';

class Ebook
{
  /**
   * Mengambil semua eBook dari database dengan paginasi.
   */
  public function getAll($index = null, $limit = null)
  {
    $conn = connect();
    $query = "SELECT * FROM ebooks ORDER BY id DESC";
    if ($index !== null && $limit !== null) {
      $query .= " LIMIT ?, ?";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, 'ii', $index, $limit);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
    } else {
      $result = mysqli_query($conn, $query);
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
  }

  /**
   * Menghitung total semua eBook di database.
   */
  public function countAll()
  {
    $conn = connect();
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM ebooks");
    return mysqli_fetch_assoc($result)['total'];
  }

  /**
   * Mencari satu eBook berdasarkan ID-nya.
   */
  public function findById($id)
  {
    $conn = connect();
    $id = (int)$id;
    $stmt = mysqli_prepare($conn, "SELECT * FROM ebooks WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
  }

  /**
   * Membuat entri eBook baru di database dengan aman menggunakan Prepared Statements.
   */
  public function create($data, $files)
  {
    $conn = connect();
    // Sanitasi dan persiapan data
    $username = $_SESSION['username'];
    $title = htmlspecialchars($data['title']);
    $description = htmlspecialchars($data['description'] ?? '');
    $author = htmlspecialchars($data['author']);
    $year = !empty($data['year']) ? htmlspecialchars($data['year']) : null;
    $category = htmlspecialchars($data['category']);
    $price = (int)htmlspecialchars($data['price'] ?? 0);
    $type = ($price > 0) ? 'Paid' : 'Free';
    $link = htmlspecialchars($data['link']);
    $cover = $this->uploadCover($files['cover']);

    if ($cover === false) return false;
    if (is_null($cover)) $cover = 'default-cover.jpg';

    // Menggunakan Prepared Statement untuk mencegah SQL Injection
    $query = "INSERT INTO ebooks (added_by, title, description, author, year, category, type, price, link, cover, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Verified')";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt === false) {
      error_log('MySQL prepare error: ' . mysqli_error($conn));
      return -1;
    }

    mysqli_stmt_bind_param($stmt, "ssssssssis", $username, $title, $description, $author, $year, $category, $type, $price, $link, $cover);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_affected_rows($stmt);
  }

  /**
   * Memperbarui data eBook yang ada dengan aman menggunakan Prepared Statements.
   */
  public function update($data, $files)
  {
    $conn = connect();
    // Sanitasi dan persiapan data
    $id = (int)htmlspecialchars($data['id']);
    $title = htmlspecialchars($data['title']);
    $description = htmlspecialchars($data['description'] ?? '');
    $author = htmlspecialchars($data['author']);
    $year = !empty($data['year']) ? htmlspecialchars($data['year']) : null;
    $category = htmlspecialchars($data['category']);
    $price = (int)htmlspecialchars($data['price'] ?? 0);
    $type = ($price > 0) ? 'Paid' : 'Free';
    $link = htmlspecialchars($data['link']);
    $status = htmlspecialchars($data['status']);
    $oldCover = htmlspecialchars($data['oldCover']);
    $cover = $this->uploadCover($files['cover']);

    if (is_null($cover)) {
      $cover = $oldCover;
    } elseif ($cover === false) {
      return false;
    }

    // Menggunakan Prepared Statement untuk mencegah SQL Injection
    $query = "UPDATE ebooks SET title = ?, description = ?, author = ?, year = ?, category = ?, type = ?, price = ?, link = ?, status = ?, cover = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt === false) {
      error_log('MySQL prepare error: ' . mysqli_error($conn));
      return -1;
    }

    mysqli_stmt_bind_param($stmt, "ssssssisssi", $title, $description, $author, $year, $category, $type, $price, $link, $status, $cover, $id);
    mysqli_stmt_execute($stmt);

    $affected_rows = mysqli_stmt_affected_rows($stmt);
    // Hapus cover lama jika update berhasil dan cover diganti
    if ($affected_rows > 0 && $cover !== $oldCover && $oldCover !== 'default-cover.jpg') {
      if (file_exists("assets/img/ebook/$oldCover")) {
        unlink("assets/img/ebook/$oldCover");
      }
    }

    return $affected_rows;
  }

  /**
   * Menghapus eBook dari database.
   */
  public function delete($id)
  {
    $conn = connect();
    $id = (int)$id;
    $ebook = $this->findById($id);

    if ($ebook) {
      $cover = $ebook['cover'];
      $stmt = mysqli_prepare($conn, "DELETE FROM ebooks WHERE id = ?");
      mysqli_stmt_bind_param($stmt, 'i', $id);
      mysqli_stmt_execute($stmt);
      $affected_rows = mysqli_stmt_affected_rows($stmt);

      if ($affected_rows > 0 && $cover !== 'default-cover.jpg' && file_exists("assets/img/ebook/$cover")) {
        unlink("assets/img/ebook/$cover");
      }
      return $affected_rows;
    }
    return 0;
  }

  /**
   * Mencari eBook berdasarkan kata kunci.
   */
  public function search($keyword, $index = null, $limit = null)
  {
    $conn = connect();
    $searchTerm = '%' . mysqli_real_escape_string($conn, $keyword) . '%';
    $query = "SELECT * FROM ebooks WHERE title LIKE ? OR author LIKE ? OR category LIKE ? ORDER BY id DESC";

    if ($index !== null && $limit !== null) {
      $query .= " LIMIT ?, ?";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, 'sssii', $searchTerm, $searchTerm, $searchTerm, $index, $limit);
    } else {
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, 'sss', $searchTerm, $searchTerm, $searchTerm);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
  }

  /**
   * Menghitung hasil pencarian.
   */
  public function countSearch($keyword)
  {
    $conn = connect();
    $searchTerm = '%' . mysqli_real_escape_string($conn, $keyword) . '%';
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) as total FROM ebooks WHERE title LIKE ? OR author LIKE ? OR category LIKE ?");
    mysqli_stmt_bind_param($stmt, 'sss', $searchTerm, $searchTerm, $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result)['total'];
  }

  /**
   * Mengunggah file cover dengan aman.
   */
  private function uploadCover($coverFile)
  {
    if (!isset($coverFile) || $coverFile['error'] === UPLOAD_ERR_NO_FILE) return null;

    // Validasi error upload
    if ($coverFile['error'] !== UPLOAD_ERR_OK) return false;

    // Validasi ukuran dan tipe
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $coverExtension = strtolower(pathinfo($coverFile['name'], PATHINFO_EXTENSION));
    if (!in_array($coverExtension, $allowedExtensions)) return false;
    if ($coverFile['size'] > 1048576) return false; // 1MB

    // Membuat nama file yang unik untuk mencegah konflik
    $newCoverName = uniqid('cover-', true) . '.' . $coverExtension;
    $destination = 'assets/img/ebook/' . $newCoverName;

    if (move_uploaded_file($coverFile['tmp_name'], $destination)) {
      return $newCoverName;
    }

    return false; // Gagal memindahkan file
  }
}
