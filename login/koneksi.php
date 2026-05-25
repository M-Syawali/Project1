<?php

$conn = mysqli_connect(
    "127.0.0.1",
    "root",
    "",
    "sagalalada_db"
);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>