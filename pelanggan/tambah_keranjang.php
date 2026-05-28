<?php
session_start();
include "koneksi.php";

// 1. Ambil ID menu dari URL
if (isset($_GET['id'])) {
    $id_menu = $_GET['id'];

    // 2. Cek apakah session keranjang sudah ada, jika belum buat array kosong
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    // 3. Jika menu sudah ada di keranjang, tambah jumlahnya. Jika belum, set 1.
    if (isset($_SESSION['keranjang'][$id_menu])) {
        $_SESSION['keranjang'][$id_menu] += 1;
    } else {
        $_SESSION['keranjang'][$id_menu] = 1;
    }

    // 4. Alihkan kembali ke halaman menu dengan pesan sukses
    echo "<script>alert('Menu berhasil ditambahkan ke keranjang!'); window.location='menu.php';</script>";
} else {
    // Jika tidak ada ID, balikkan ke menu
    header("location:menu.php");
}

if (isset($_GET['ajax'])) {
    // Jika lewat animasi/ajax, hentikan agar halaman tidak reload
    exit;
} else {
    // Jika diakses manual (opsional), tetap lakukan redirect
    header("Location: menu.php"); 
}
?>