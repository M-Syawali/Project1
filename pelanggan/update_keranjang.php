<?php
session_start();

if (isset($_GET['id']) && isset($_GET['aksi'])) {
    $id_menu = $_GET['id'];
    $aksi = $_GET['aksi'];

    if ($aksi == "tambah") {
        $_SESSION['keranjang'][$id_menu] += 1;
    } 
    elseif ($aksi == "kurang") {
        if ($_SESSION['keranjang'][$id_menu] > 1) {
            $_SESSION['keranjang'][$id_menu] -= 1;
        } else {
            // Jika jumlah sudah 1 lalu dikurangi, otomatis hapus dari keranjang
            unset($_SESSION['keranjang'][$id_menu]);
        }
    } 
    elseif ($aksi == "hapus") {
        unset($_SESSION['keranjang'][$id_menu]);
    }
}

// Kembali ke halaman keranjang
header("location: keranjang.php");
exit();
?>