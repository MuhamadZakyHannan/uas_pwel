<?php

function connect()
{
  $host = 'localhost';
  $user = 'root';
  $password = '';
  $database = 'ebookapps';

  $conn = mysqli_connect($host, $user, $password, $database);

  if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
  }

  mysqli_report(MYSQLI_REPORT_OFF);
  return $conn;
}
