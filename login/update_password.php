<?php

include "koneksi.php";

$token = $_POST['token'];

$password = $_POST['password'];

$password_hash =
password_hash(
    $password,
    PASSWORD_DEFAULT
);

$cek = mysqli_query(
    $conn,
    "SELECT * FROM password_resets
    WHERE token='$token'"
);

$data = mysqli_fetch_assoc($cek);

$email = $data['email'];

mysqli_query(
    $conn,
    "UPDATE users
    SET password='$password_hash'
    WHERE email='$email'"
);

mysqli_query(
    $conn,
    "DELETE FROM password_resets
    WHERE token='$token'"
);

echo "Password berhasil diubah.";