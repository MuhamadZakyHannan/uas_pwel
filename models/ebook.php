<?php

class Ebook
{
  private $conn;

  public function __construct()
  {
    $this->conn = connect();
  }

  // --- Fungsi-fungsi untuk mengambil data ---

  public function getAll($index, $limit)
  {
    $stmt = $this->conn->prepare("SELECT * FROM ebooks ORDER BY id DESC LIMIT ?, ?");
    $stmt->bind_param('ii', $index, $limit);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  }

  public function findById($id)
  {
    $stmt = $this->conn->prepare("SELECT * FROM ebooks WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  public function countAll()
  {
    $result = $this->conn->query("SELECT COUNT(id) as total FROM ebooks");
    return $result->fetch_assoc()['total'];
  }

  public function countSearch($keyword)
  {
    $query_keyword = "%" . $keyword . "%";
    $stmt = $this->conn->prepare("SELECT COUNT(id) as total FROM ebooks WHERE title LIKE ? OR author LIKE ?");
    $stmt->bind_param('ss', $query_keyword, $query_keyword);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc()['total'];
  }

  public function search($keyword, $index, $limit)
  {
    $query_keyword = "%" . $keyword . "%";
    $stmt = $this->conn->prepare("SELECT * FROM ebooks WHERE title LIKE ? OR author LIKE ? ORDER BY id DESC LIMIT ?, ?");
    $stmt->bind_param('ssii', $query_keyword, $query_keyword, $index, $limit);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  }

  // --- Fungsi-fungsi untuk memodifikasi data (CRUD) ---

  public function create($data, $files)
  {
    $_FILES = $files; // Set global $_FILES agar bisa dibaca oleh uploadCover()

    $newCoverName = $this->uploadCover();
    if ($newCoverName === false) {
      return 0; // Gagal upload, hentikan proses
    }

    // Gunakan cover baru jika ada, jika tidak, gunakan default
    $cover = $newCoverName ?: 'default-cover.jpg';

    $stmt = $this->conn->prepare("INSERT INTO ebooks (added_by, title, description, author, year, category, type, price, link, cover, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
      'ssssisssiss',
      $_SESSION['username'],
      $data['title'],
      $data['description'],
      $data['author'],
      $data['year'],
      $data['category'],
      $data['type'],
      $data['price'],
      $data['link'],
      $cover,
      $data['status']
    );

    return $stmt->execute() ? $stmt->affected_rows : 0;
  }

  public function update($data, $files)
  {
    $_FILES = $files;
    $newCoverName = $this->uploadCover();

    if ($newCoverName === false) {
      return -1; // Gagal upload, hentikan proses
    }

    $coverToUpdate = $newCoverName ?: $data['old_cover'];

    // Jika ada file cover baru yang di-upload, hapus file lama
    if ($newCoverName && $data['old_cover'] && $data['old_cover'] !== 'default-cover.jpg') {
      $oldCoverPath = 'assets/img/ebook/' . $data['old_cover'];
      if (file_exists($oldCoverPath)) {
        unlink($oldCoverPath);
      }
    }

    $stmt = $this->conn->prepare("UPDATE ebooks SET title = ?, description = ?, author = ?, year = ?, category = ?, type = ?, price = ?, link = ?, cover = ?, status = ? WHERE id = ?");
    $stmt->bind_param(
      'sssisssissi',
      $data['title'],
      $data['description'],
      $data['author'],
      $data['year'],
      $data['category'],
      $data['type'],
      $data['price'],
      $data['link'],
      $coverToUpdate,
      $data['status'],
      $data['id']
    );

    return $stmt->execute() ? $stmt->affected_rows : -1;
  }

  public function delete($id)
  {
    $ebook = $this->findById($id);
    if ($ebook && $ebook['cover'] && $ebook['cover'] !== 'default-cover.jpg') {
      $coverPath = 'assets/img/ebook/' . $ebook['cover'];
      if (file_exists($coverPath)) {
        unlink($coverPath);
      }
    }

    $stmt = $this->conn->prepare("DELETE FROM ebooks WHERE id = ?");
    $stmt->bind_param('i', $id);
    return $stmt->execute() ? $stmt->affected_rows : 0;
  }

  // --- Fungsi Helper untuk Upload Cover yang Aman ---

  private function uploadCover()
  {
    // Jika tidak ada file yang diunggah, kembalikan null
    if (!isset($_FILES['cover']) || $_FILES['cover']['error'] === UPLOAD_ERR_NO_FILE) {
      return null;
    }

    $fileName = $_FILES['cover']['name'];
    $fileSize = $_FILES['cover']['size'];
    $fileTmpName = $_FILES['cover']['tmp_name'];
    $fileError = $_FILES['cover']['error'];

    // 1. Cek jika ada error saat upload
    if ($fileError !== UPLOAD_ERR_OK) {
      error_log("Upload error code: " . $fileError);
      return false;
    }

    // 2. Validasi ekstensi file
    $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $validExtensions)) {
      return false;
    }

    // 3. Validasi tipe MIME (pengecekan paling aman)
    $validMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileMimeType = mime_content_type($fileTmpName);
    if (!in_array($fileMimeType, $validMimeTypes)) {
      return false;
    }

    // 4. Validasi ukuran file (maksimal 2MB)
    if ($fileSize > 2000000) {
      return false;
    }

    // 5. Buat nama file baru yang unik
    $newFileName = uniqid('cover-', true) . '.' . $fileExtension;
    $uploadPath = 'assets/img/ebook/' . $newFileName;

    // 6. Pindahkan file jika semua validasi lolos
    if (move_uploaded_file($fileTmpName, $uploadPath)) {
      return $newFileName; // Kembalikan nama file baru
    } else {
      return false;
    }
  }
}
