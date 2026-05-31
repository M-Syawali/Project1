<?php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_menu = $_POST['id_menu'];
    $jumlah = (int)$_POST['jumlah'];

    // Pastikan session keranjang ada
    if (isset($_SESSION['keranjang'][$id_menu])) {
        
        // CEK PENTING: Jika ternyata isi session itu bukan array, 
        // kita reset supaya menjadi array yang benar
        if (!is_array($_SESSION['keranjang'][$id_menu])) {
            $_SESSION['keranjang'][$id_menu] = [
                'jumlah' => $jumlah,
                'pedas' => 'Original',
                'catatan' => ''
            ];
        } else {
            // Jika sudah benar array, baru update jumlahnya
            $_SESSION['keranjang'][$id_menu]['jumlah'] = $jumlah;
        }
    }

    header("Location: keranjang.php");
    exit();
}
?>