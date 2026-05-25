<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn,
    "SELECT * FROM admin 
     WHERE username='$username' 
     AND password='$password'"
);

$cek = mysqli_num_rows($query);

if ($cek > 0) {
    // AMBIL DATA ADMIN dari hasil query database
    $data = mysqli_fetch_assoc($query);

    // SIMPAN DI SESSION (Simpan username DAN id_admin-nya)
    $_SESSION['username'] = $username;
    $_SESSION['id_admin'] = $data['id_admin']; // <-- Ini kunci utamanya!

    header("Location: dashboard.php");
    exit(); // Tambahkan exit setelah header redirect
} else {
    echo "Login gagal";
}
?>