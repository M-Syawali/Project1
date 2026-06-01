<?php
session_start();
include "koneksi.php";

// Fungsi helper untuk menambahkan satu menu ke session
function tambahKeSession($id_menu) {
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    if (isset($_SESSION['keranjang'][$id_menu])) {
        $_SESSION['keranjang'][$id_menu]['jumlah'] += 1;
    } else {
        $_SESSION['keranjang'][$id_menu] = [
            'jumlah' => 1,
            'pedas' => 'Original',
            'catatan' => ''
        ];
    }
}

// 1. Logika jika tombol Paket diklik (menerima id_m dan id_min)
if (isset($_GET['id_m']) && isset($_GET['id_min'])) {
    tambahKeSession($_GET['id_m']);
    tambahKeSession($_GET['id_min']);
    
    echo "<script>alert('Paket berhasil ditambahkan ke keranjang!'); window.location='keranjang.php';</script>";

// 2. Logika jika tombol Satuan diklik (menerima id)
} elseif (isset($_GET['id'])) {
    tambahKeSession($_GET['id']);
    
    echo "<script>alert('Menu berhasil ditambahkan ke keranjang!'); window.location='menu.php';</script>";

} else {
    header("location:menu.php");
    exit();
}
?>