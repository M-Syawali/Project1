<?php
session_start();
include 'koneksi.php';

if (empty($_SESSION['keranjang'])) {
    echo "<script>alert('Keranjang kosong!'); window.location='menu.php';</script>";
    exit;
}

// Cek apakah ada session meja (dari scan barcode)
// Jika tidak ada, kita set NULL (untuk pesan dari rumah)
$id_meja = isset($_SESSION['id_meja']) ? $_SESSION['id_meja'] : "NULL";

$id_pelanggan = isset($_SESSION['pelanggan']['id_pelanggan']) ? $_SESSION['pelanggan']['id_pelanggan'] : "NULL";
$tanggal = date("Y-m-d H:i:s");
$total_bayar = 0;

// Hitung total bayar
foreach ($_SESSION['keranjang'] as $id_menu => $item) {
    $ambil = mysqli_query($conn, "SELECT harga FROM menu WHERE id_menu='$id_menu'");
    $m = mysqli_fetch_assoc($ambil);
    $total_bayar += ($m['harga'] * $item['jumlah']);
}

// INSERT ke tabel pesanan
// Perhatikan: $id_meja dan $id_pelanggan tidak pakai tanda petik jika nilainya NULL
$query_pesanan = "INSERT INTO pesanan (tanggal, id_meja, total_harga, status_pesanan, id_pelanggan) 
                  VALUES ('$tanggal', $id_meja, '$total_bayar', 'menunggu', $id_pelanggan)";

if (mysqli_query($conn, $query_pesanan)) {
    $id_pesanan_baru = mysqli_insert_id($conn);

    foreach ($_SESSION['keranjang'] as $id_menu => $item) {
        $qty = $item['jumlah'];
        $pedas = $item['pedas'];
        $catatan = mysqli_real_escape_string($conn, $item['catatan']);

        mysqli_query($conn, "INSERT INTO detail_pesanan (id_pesanan, id_menu, jumlah, pedas, catatan) 
                             VALUES ('$id_pesanan_baru', '$id_menu', '$qty', '$pedas', '$catatan')");
    }

    unset($_SESSION['keranjang']);
    echo "<script>alert('Pesanan Berhasil! Silahkan tunggu konfirmasi.'); window.location='histori.php';</script>";
} else {
    echo "Gagal Simpan: " . mysqli_error($conn);
}
?>