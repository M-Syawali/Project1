<?php
session_start();

// 1. Update via POST (Digunakan untuk Auto-Save Pedas & Catatan)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_menu'])) {
    $id = $_POST['id_menu'];
    
    // Pastikan item ada di keranjang sebelum diupdate
    if (isset($_SESSION['keranjang'][$id])) {
        $_SESSION['keranjang'][$id]['pedas'] = $_POST['pedas'];
        $_SESSION['keranjang'][$id]['catatan'] = $_POST['catatan'];
    }

    // CEK: Jika ini request dari JavaScript (AJAX), jangan lakukan redirect
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo "success"; // Kirim respon balik ke AJAX
        exit;
    }

    // Jika bukan AJAX (misal form disubmit manual), baru redirect
    header("location:keranjang.php");
    exit;
}

// 2. Update via GET (Digunakan untuk Tambah, Kurang, Hapus melalui Link)
if (isset($_GET['id']) && isset($_GET['aksi'])) {
    $id = $_GET['id'];
    $aksi = $_GET['aksi'];

    if (isset($_SESSION['keranjang'][$id])) {
        if ($aksi == "tambah") {
            $_SESSION['keranjang'][$id]['jumlah'] += 1;
        } elseif ($aksi == "kurang") {
            if ($_SESSION['keranjang'][$id]['jumlah'] > 1) {
                $_SESSION['keranjang'][$id]['jumlah'] -= 1;
            }
        } elseif ($aksi == "hapus") {
            unset($_SESSION['keranjang'][$id]);
        }
    }
    
    header("location:keranjang.php");
    exit;
}

// Jika akses langsung ke file ini tanpa parameter
header("location:keranjang.php");
exit;
?>