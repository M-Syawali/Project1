<?php
session_start();
include "koneksi.php";

// 1. TETAPKAN LOGIKA NOMOR MEJA (Tidak hilang)
if (isset($_GET['meja'])) {
    $_SESSION['no_meja'] = $_GET['meja'];
}

// 2. FUNGSI HELPER DENGAN CEK STOK
function tambahKeSession($id_menu, $conn) {
    // Cek stok & status di database
    $cek = mysqli_query($conn, "SELECT stok, status FROM menu WHERE id_menu = '$id_menu'");
    $data = mysqli_fetch_assoc($cek);

    // Jika menu tidak ditemukan, stok 0, atau status bukan 'tersedia', batalkan
    if (!$data || $data['stok'] <= 0 || $data['status'] !== 'tersedia') {
        return false; 
    }

    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    if (isset($_SESSION['keranjang'][$id_menu])) {
        // Cek apakah jumlah di keranjang sudah melebihi stok yang tersedia
        if ($_SESSION['keranjang'][$id_menu]['jumlah'] < $data['stok']) {
            $_SESSION['keranjang'][$id_menu]['jumlah'] += 1;
            return true;
        } else {
            return "limit"; 
        }
    } else {
        $_SESSION['keranjang'][$id_menu] = [
            'jumlah' => 1,
            'pedas' => 'Original',
            'catatan' => ''
        ];
        return true;
    }
}

// 3. LOGIKA TAMBAH MENU
if (isset($_GET['id_m']) && isset($_GET['id_min'])) {
    // Paket
    $cek1 = tambahKeSession($_GET['id_m'], $conn);
    $cek2 = tambahKeSession($_GET['id_min'], $conn);
    
    if ($cek1 === true && $cek2 === true) {
        echo "<script>alert('Paket berhasil ditambahkan!'); window.location='keranjang.php';</script>";
    } else {
        echo "<script>alert('Maaf, salah satu menu dalam paket sudah habis!'); window.location='menu.php';</script>";
    }

} elseif (isset($_GET['id'])) {
    // Satuan
    $result = tambahKeSession($_GET['id'], $conn);
    
    if ($result === true) {
        echo "<script>alert('Menu berhasil ditambahkan!'); window.location='menu.php';</script>";
    } elseif ($result === "limit") {
        echo "<script>alert('Stok tidak mencukupi!'); window.location='menu.php';</script>";
    } else {
        echo "<script>alert('Menu sudah habis!'); window.location='menu.php';</script>";
    }

} else {
    header("location:menu.php");
    exit();
}
?>