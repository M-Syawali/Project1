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
// TAMBAHAN: Menambahkan validasi untuk metode_pembayaran
if (!isset($_POST['nama']) || !isset($_POST['nomor_pesanan']) || !isset($_POST['metode_pembayaran'])) {
    die("Data tidak lengkap");
}

$nama_pelanggan = mysqli_real_escape_string($conn, $_POST['nama']);
$nomor_pesanan = mysqli_real_escape_string($conn, $_POST['nomor_pesanan']);
$metode_pembayaran = mysqli_real_escape_string($conn, $_POST['metode_pembayaran']);

$tanggal = date("Y-m-d H:i:s");
$total = 0;
$nama_file_bukti = ""; // Default kosong jika bayar di kasir

/* =========================
   PROSES UPLOAD BUKTI PEMBAYARAN (JIKA QRIS)
========================= */
if ($metode_pembayaran === 'QRIS') {
    if (isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] == 0) {
        
        // Tentukan folder tujuan upload (Pastikan folder ini sudah Anda buat: upload/bukti/)
        $target_dir = "upload/bukti/"; 
        
        // Buat folder otomatis jika belum ada di server
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $nama_file_asli = $_FILES["bukti_pembayaran"]["name"];
        $ekstensi = strtolower(pathinfo($nama_file_asli, PATHINFO_EXTENSION));
        
        // Validasi Ekstensi File
        $ekstensi_diperbolehkan = array("jpg", "jpeg", "png");
        if (!in_array($ekstensi, $ekstensi_diperbolehkan)) {
            echo "<script>alert('Format file tidak didukung! Hanya diperbolehkan .jpg, .jpeg, atau .png'); window.history.back();</script>";
            exit;
        }

        // Rename nama file gambar menggunakan nomor pesanan agar unik dan tidak duplikat
        $nama_file_bukti = $nomor_pesanan . "." . $ekstensi;
        $target_file = $target_dir . $nama_file_bukti;

        // Pindahkan file dari temporary cache ke folder tujuan
        if (!move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file)) {
            die("Gagal mengunggah bukti pembayaran.");
        }
    } else {
        // Jika memilih QRIS tetapi tidak menyertakan berkas gambar
        echo "<script>alert('Wajib mengunggah bukti pembayaran untuk metode QRIS!'); window.history.back();</script>";
        exit;
    }
}

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
    // PERUBAHAN: Menambahkan kolom metode_pembayaran dan bukti_pembayaran ke dalam SQL query
    if ($no_meja) {
        $sql = "INSERT INTO pesanan 
        (nomor_pesanan, tanggal, total_harga, status_pesanan, id_pelanggan, id_meja, metode_pembayaran, bukti_pembayaran)
        VALUES 
        ('$nomor_pesanan', '$tanggal', '$total', 'pending', '$id_pelanggan', '$no_meja', '$metode_pembayaran', '$nama_file_bukti')";
    } else {
        $sql = "INSERT INTO pesanan 
        (nomor_pesanan, tanggal, total_harga, status_pesanan, id_pelanggan, metode_pembayaran, bukti_pembayaran)
        VALUES 
        ('$nomor_pesanan', '$tanggal', '$total', 'pending', '$id_pelanggan', '$metode_pembayaran', '$nama_file_bukti')";
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

        // 2. Kurangi stok di tabel menu
        mysqli_query($conn, "UPDATE menu SET stok = stok - $qty WHERE id_menu = '$id_menu'");

        // 3. Otomatis set status jadi 'habis' jika stok <= 0
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