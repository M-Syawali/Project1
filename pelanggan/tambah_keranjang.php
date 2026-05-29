<?php
session_start();
include "koneksi.php";

if (isset($_GET['id'])) {
    $id_menu = $_GET['id'];

    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    // Jika menu sudah ada di keranjang, tambah jumlahnya saja
    if (isset($_SESSION['keranjang'][$id_menu])) {
        $_SESSION['keranjang'][$id_menu]['jumlah'] += 1;
    } else {
        // Jika belum ada, buat array baru dengan nilai default
        $_SESSION['keranjang'][$id_menu] = [
            'jumlah' => 1,
            'pedas' => 'Original', // Nilai default
            'catatan' => ''        // Nilai default
        ];
    }

    echo "<script>alert('Menu berhasil ditambahkan ke keranjang!'); window.location='menu.php';</script>";
} else {
    header("location:menu.php");
    exit();
}
?>