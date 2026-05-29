<?php
session_start();

// Update via POST (Pedas & Catatan)
if (isset($_POST['id_menu'])) {
    $id = $_POST['id_menu'];
    $_SESSION['keranjang'][$id]['pedas'] = $_POST['pedas'];
    $_SESSION['keranjang'][$id]['catatan'] = $_POST['catatan'];
    header("location:keranjang.php");
    exit;
}

// Update via GET (Tambah, Kurang, Hapus)
if (isset($_GET['id']) && isset($_GET['aksi'])) {
    $id = $_GET['id'];
    $aksi = $_GET['aksi'];

    if ($aksi == "tambah") {
        $_SESSION['keranjang'][$id]['jumlah'] += 1;
    } elseif ($aksi == "kurang") {
        if ($_SESSION['keranjang'][$id]['jumlah'] > 1) {
            $_SESSION['keranjang'][$id]['jumlah'] -= 1;
        }
    } elseif ($aksi == "hapus") {
        unset($_SESSION['keranjang'][$id]);
    }
    header("location:keranjang.php");
    exit;
}
?>