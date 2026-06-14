<?php
// Konfigurasi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sagalalada_db";

$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>