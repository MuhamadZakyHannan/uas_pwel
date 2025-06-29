<?php

require_once __DIR__ . '/../config/database.php';

class User
{
  public function findByUsername($username)
  {
    $conn = connect();
    $username = mysqli_real_escape_string($conn, $username);
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    return mysqli_fetch_assoc($result);
  }

  public function findById($id)
  {
    $conn = connect();
    $id = mysqli_real_escape_string($conn, $id);
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'");
    return mysqli_fetch_assoc($result);
  }

  public function create($data)
  {
    $conn = connect();
    $username = str_replace(' ', '', strtolower(mysqli_real_escape_string($conn, $data['username'])));
    $password = mysqli_real_escape_string($conn, $data['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $data['confirmPassword']);

    if (empty(trim($username)) || empty(trim($password))) {
      return ['error' => true, 'message' => 'Nama pengguna atau kata sandi tidak valid!'];
    }

    if ($this->findByUsername($username)) {
      return ['error' => true, 'message' => 'Nama pengguna sudah ada!'];
    }

    if (!preg_match("/^.{8,}$/", $password)) {
      return ['error' => true, 'message' => 'Kata sandi harus memiliki panjang minimal 8 karakter!'];
    }

    if ($password !== $confirmPassword) {
      return ['error' => true, 'message' => "Kata sandi tidak cocok!"];
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')");

    if (mysqli_affected_rows($conn) > 0) {
      return ['success' => true, 'message' => 'Pendaftaran berhasil!'];
    } else {
      return ['error' => true, 'message' => 'Gagal mendaftar. Coba lagi!'];
    }
  }
}
