<?php
session_start();
include "koneksi.php";

if (empty($_SESSION['keranjang'])) {
    echo "<script>alert('Keranjang kosong!'); window.location='keranjang.php';</script>";
    exit;
}

date_default_timezone_set('Asia/Jakarta');

/* =========================
   VALIDASI INPUT
========================= */
if (!isset($_POST['nama']) || !isset($_POST['nomor_pesanan'])) {
    die("Data tidak lengkap");
}

$nama_pelanggan = mysqli_real_escape_string($conn, $_POST['nama']);
$nomor_pesanan = mysqli_real_escape_string($conn, $_POST['nomor_pesanan']);

$tanggal = date("Y-m-d H:i:s");
$total = 0;

/* =========================
   AMBIL MEJA
========================= */
$no_meja = $_SESSION['no_meja'] ?? null;

/* =========================
   TRANSAKSI START
========================= */
mysqli_begin_transaction($conn);

try {

    /* =========================
       CEK / INSERT PELANGGAN
    ========================= */
    $cek = mysqli_query($conn, "SELECT id_pelanggan FROM pelanggan WHERE nama_pelanggan='$nama_pelanggan'");

    if (mysqli_num_rows($cek) > 0) {
        $id_pelanggan = mysqli_fetch_assoc($cek)['id_pelanggan'];
    } else {
        mysqli_query($conn, "INSERT INTO pelanggan (nama_pelanggan) VALUES ('$nama_pelanggan')");
        $id_pelanggan = mysqli_insert_id($conn);
    }

    /* =========================
       HITUNG TOTAL
    ========================= */
    foreach ($_SESSION['keranjang'] as $id_menu => $item) {

        $q = mysqli_query($conn, "SELECT harga FROM menu WHERE id_menu='$id_menu'");
        $d = mysqli_fetch_assoc($q);

        $total += $d['harga'] * $item['jumlah'];
    }

    /* =========================
       INSERT PESANAN
    ========================= */
    if ($no_meja) {

    $sql = "INSERT INTO pesanan 
    (nomor_pesanan, tanggal, total_harga, status_pesanan, id_pelanggan, id_meja)
    VALUES 
    ('$nomor_pesanan', '$tanggal', '$total', 'pending', '$id_pelanggan', '$no_meja')";

    } else {

        $sql = "INSERT INTO pesanan 
        (nomor_pesanan, tanggal, total_harga, status_pesanan, id_pelanggan)
        VALUES 
        ('$nomor_pesanan', '$tanggal', '$total', 'pending', '$id_pelanggan')";
    }

    mysqli_query($conn, $sql);

    $id_pesanan = mysqli_insert_id($conn);

    if (!$id_pesanan) {
        throw new Exception("Gagal membuat pesanan");
    }

   /* =========================
       INSERT DETAIL PESANAN
    ========================= */
    foreach ($_SESSION['keranjang'] as $id_menu => $item) {

        $qty = $item['jumlah'];
        $pedas = mysqli_real_escape_string($conn, $item['pedas']);
        $catatan = mysqli_real_escape_string($conn, $item['catatan']);

        $q = mysqli_query($conn, "SELECT harga FROM menu WHERE id_menu='$id_menu'");
        $d = mysqli_fetch_assoc($q);

        $subtotal = $d['harga'] * $qty;

        // 1. Masukkan ke detail_pesanan
        mysqli_query($conn, "
            INSERT INTO detail_pesanan
            (id_pesanan, id_menu, jumlah, subtotal, pedas, catatan)
            VALUES
            ('$id_pesanan', '$id_menu', '$qty', '$subtotal', '$pedas', '$catatan')
        ");

        // 2. TAMBAHKAN INI: Kurangi stok di tabel menu
        mysqli_query($conn, "UPDATE menu SET stok = stok - $qty WHERE id_menu = '$id_menu'");

        // 3. TAMBAHKAN INI: Otomatis set status jadi 'habis' jika stok <= 0
        mysqli_query($conn, "UPDATE menu SET status = 'habis' WHERE id_menu = '$id_menu' AND stok <= 0");
    }
    /* =========================
       COMMIT
    ========================= */
    mysqli_commit($conn);

    /* =========================
       CLEAR KERANJANG
    ========================= */
    unset($_SESSION['keranjang']);

    echo "<script>
        alert('Pesanan berhasil dikirim!');
        window.location='status_pesanan.php?id=$id_pesanan';
    </script>";

} catch (Exception $e) {

    mysqli_rollback($conn);

    die("Gagal checkout: " . $e->getMessage());
}
?>