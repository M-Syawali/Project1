<?php
session_start();
include "koneksi.php";

// 1. CEK APAKAH KERANJANG KOSONG
if (empty($_SESSION['keranjang'])) {
    echo "<script>alert('Keranjang belanja Anda kosong!'); window.location='keranjang.php';</script>";
    exit;
}

// 2. SET TIMEZONE & AMBIL DATA DARI FORM
date_default_timezone_set('Asia/Jakarta');
$nama_pelanggan = mysqli_real_escape_string($conn, $_POST['nama']);
$tanggal_sekarang = date("Y-m-d H:i:s");
$total_harga_final = 0;

/* ---------------------------------------------------------
   A. PROSES DATA PELANGGAN
   --------------------------------------------------------- */
// Cek apakah pelanggan sudah ada di database atau belum
$cek_pelanggan = mysqli_query($conn, "SELECT id_pelanggan FROM pelanggan WHERE nama_pelanggan = '$nama_pelanggan'");

if (mysqli_num_rows($cek_pelanggan) > 0) {
    $data_plg = mysqli_fetch_assoc($cek_pelanggan);
    $id_pelanggan = $data_plg['id_pelanggan'];
} else {
    // Jika pelanggan baru, simpan ke tabel pelanggan
    mysqli_query($conn, "INSERT INTO pelanggan (nama_pelanggan) VALUES ('$nama_pelanggan')");
    $id_pelanggan = mysqli_insert_id($conn);
}

/* ---------------------------------------------------------
   B. HITUNG TOTAL HARGA (LOOP PERTAMA)
   --------------------------------------------------------- */
foreach ($_SESSION['keranjang'] as $id_menu => $item) {
    $qty = $item['jumlah'];
    $q_menu = mysqli_query($conn, "SELECT harga FROM menu WHERE id_menu = '$id_menu'");
    $d_menu = mysqli_fetch_assoc($q_menu);
    
    $subtotal = $d_menu['harga'] * $qty;
    $total_harga_final += $subtotal;
}

/* ---------------------------------------------------------
   C. SIMPAN KE TABEL PESANAN
   --------------------------------------------------------- */
// status_pesanan diisi 'diproses' sesuai ENUM di database kamu
$insert_pesanan = mysqli_query($conn, "INSERT INTO pesanan (tanggal, total_harga, status_pesanan, id_pelanggan) 
                                       VALUES ('$tanggal_sekarang', '$total_harga_final', 'diproses', '$id_pelanggan')");

if (!$insert_pesanan) {
    die("Gagal menyimpan pesanan: " . mysqli_error($conn));
}

$id_pesanan_baru = mysqli_insert_id($conn);

/* ---------------------------------------------------------
   D. SIMPAN KE TABEL DETAIL_PESANAN (LOOP KEDUA)
   --------------------------------------------------------- */
foreach ($_SESSION['keranjang'] as $id_menu => $item) {
    $qty = $item['jumlah'];
    $pedas = mysqli_real_escape_string($conn, $item['pedas']);
    $catatan = mysqli_real_escape_string($conn, $item['catatan']);
    
    // Ambil harga lagi untuk menghitung subtotal tiap baris
    $q_menu = mysqli_query($conn, "SELECT harga FROM menu WHERE id_menu = '$id_menu'");
    $d_menu = mysqli_fetch_assoc($q_menu);
    $subtotal_item = $d_menu['harga'] * $qty;

    // Simpan ke detail_pesanan (Pastikan kolom pedas, catatan, subtotal sudah kamu buat di SQL)
    $insert_detail = mysqli_query($conn, "INSERT INTO detail_pesanan (id_pesanan, id_menu, jumlah, subtotal, pedas, catatan) 
                                          VALUES ('$id_pesanan_baru', '$id_menu', '$qty', '$subtotal_item', '$pedas', '$catatan')");
    
    if (!$insert_detail) {
        die("Gagal menyimpan detail pesanan: " . mysqli_error($conn));
    }
}

/* ---------------------------------------------------------
   E. SELESAI
   --------------------------------------------------------- */
// Kosongkan keranjang
unset($_SESSION['keranjang']);

echo "
<script>
    alert('Pesanan Anda berhasil dikirim! Admin akan segera memproses.');
    window.location='status_pesanan.php?id=$id_pesanan_baru'; 
</script>
";
?>