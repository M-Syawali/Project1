<?php
session_start();

// Aktifkan pelaporan error agar tidak muncul halaman putih kosong jika ada salah ketik
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. KONEKSI DATABASE
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sagalalada_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

date_default_timezone_set('Asia/Jakarta');

// 2. VALIDASI INPUT FORM KASIR
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Jika nama_pelanggan kosong, otomatis diset sebagai 'Pelanggan Kasir'
    $nama_pelanggan = !empty($_POST['nama_pelanggan']) ? mysqli_real_escape_string($conn, $_POST['nama_pelanggan']) : 'Pelanggan Kasir';
    
    // LOGIKA DINAMIS: MEJA TIDAK DIISI = TAKE AWAY
    $no_meja = !empty($_POST['no_meja']) ? mysqli_real_escape_string($conn, $_POST['no_meja']) : '';
    
    if ($no_meja !== '') {
        // Jika meja diisi, jenis pesanan menjadi Dine In diikuti nomor mejanya
        $jenis_pesanan = "Dine In (Meja " . $no_meja . ")";
    } else {
        // Jika meja kosong/tidak diisi, otomatis menjadi Take Away
        $jenis_pesanan = "Take Away";
    }
    
    $total_harga    = intval($_POST['total_harga']);
    $uang_diterima  = intval($_POST['uang_diterima']);
    
    // Validasi dasar jika keranjang kasir kosong
    if (empty($_POST['id_menu']) || $total_harga <= 0) {
        echo "<script>
                alert('Gagal! Keranjang belanja masih kosong.');
                window.location.href = 'index_kasir.php';
              </script>";
        exit;
    }

    // Validasi jika uang tunai kurang dari total belanja
    if ($uang_diterima < $total_harga) {
        echo "<script>
                alert('Gagal! Uang yang diterima kurang dari total pembayaran.');
                window.history.back();
              </script>";
        exit;
    }

    // Hitung kembalian uang
    $kembalian = $uang_diterima - $total_harga;

    // Generate Nomor Pesanan Otomatis
    $tanggal_sekarang = date('Ymd');
    $angka_acak       = rand(100, 999);
    $nomor_pesanan    = "SGL-" . $tanggal_sekarang . "-" . $angka_acak;
    $tanggal_nota     = date("Y-m-d H:i:s");

    /* =========================================================
       START TRANSACTION
       ========================================================= */
    mysqli_begin_transaction($conn);

    try {

        /* ==========================================
           LOGIKA 1: CEK / INSERT DATA PELANGGAN
           ========================================== */
        $cek_pelanggan = mysqli_query($conn, "SELECT id_pelanggan FROM pelanggan WHERE nama_pelanggan='$nama_pelanggan'");

        if (mysqli_num_rows($cek_pelanggan) > 0) {
            $id_pelanggan = mysqli_fetch_assoc($cek_pelanggan)['id_pelanggan'];
        } else {
            mysqli_query($conn, "INSERT INTO pelanggan (nama_pelanggan, no_hp) VALUES ('$nama_pelanggan', NULL)");
            $id_pelanggan = mysqli_insert_id($conn);
        }

        /* ==========================================
           LOGIKA 2: INSERT DATA KE TABEL PESANAN
           ========================================== */
        // Kolom 'no_meja' dihapus dari query untuk menghindari error database, 
        // informasinya dipindahkan dengan aman ke dalam kolom 'jenis_pesanan'
        $sql_pesanan = "INSERT INTO pesanan 
                        (nomor_pesanan, tanggal, total_harga, status_pesanan, id_pelanggan, metode_pembayaran, jenis_pesanan, uang_diterima, id_admin)
                        VALUES 
                        ('$nomor_pesanan', '$tanggal_nota', '$total_harga', 'selesai', '$id_pelanggan', 'KASIR', '$jenis_pesanan', '$uang_diterima', NULL)";
        
        if (!mysqli_query($conn, $sql_pesanan)) {
            throw new Exception("Gagal query tabel pesanan: " . mysqli_error($conn));
        }

        $id_pesanan_baru = mysqli_insert_id($conn);

        /* ==========================================
           LOGIKA 3: INSERT DETAIL PESANAN & UPDATE STOK
           ========================================== */
        $array_id_menu  = $_POST['id_menu'];
        $array_jumlah   = $_POST['jumlah'];
        $array_subtotal = $_POST['subtotal'];

        for ($i = 0; $i < count($array_id_menu); $i++) {
            $id_menu  = intval($array_id_menu[$i]);
            $qty      = intval($array_jumlah[$i]);
            $subtotal = intval($array_subtotal[$i]);

            $query_detail = "INSERT INTO detail_pesanan (id_pesanan, id_menu, jumlah, subtotal, pedas, catatan) 
                             VALUES ('$id_pesanan_baru', '$id_menu', '$qty', '$subtotal', '-', '-')";
            
            if (!mysqli_query($conn, $query_detail)) {
                throw new Exception("Gagal query detail_pesanan: " . mysqli_error($conn));
            }

            // Kurangi stok menu
            mysqli_query($conn, "UPDATE menu SET stok = stok - $qty WHERE id_menu = '$id_menu'");
            mysqli_query($conn, "UPDATE menu SET status = 'habis' WHERE id_menu = '$id_menu' AND stok <= 0");
        }

        // Kunci data jika sukses semua
        mysqli_commit($conn);

        // Format mata uang kembalian
        $rp_kembalian = "Rp " . number_format($kembalian, 0, ',', '.');

        // Cetak & Redirect otomatis
        // Jalur Cetak Menggunakan Sub-Folder pesanan/ (Anti-Blokir Browser)
        echo "<script>
                alert('Transaksi Kasir Berhasil!\\nNomor Nota: $nomor_pesanan\\nKembalian: $rp_kembalian');
                window.location.href = 'pesanan/cetak_invoice.php?id=$id_pesanan_baru';
            </script>";

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script>
                alert('Transaksi Gagal: " . addslashes($e->getMessage()) . "');
                window.history.back();
              </script>";
    }
} else {
    header("Location: index_kasir.php");
    exit;
}
?>