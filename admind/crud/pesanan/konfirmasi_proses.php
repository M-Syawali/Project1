<?php
include "koneksi.php";

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $status_baru = mysqli_real_escape_string($conn, $_GET['status']);

    // 1. Ambil data pesanan
    $query_cek = "SELECT status_pesanan FROM pesanan WHERE id_pesanan = '$id'";
    $res_cek = mysqli_query($conn, $query_cek);
    $data_cek = mysqli_fetch_assoc($res_cek);

    if (!$data_cek) {
        die("<script>alert('Pesanan tidak ditemukan!'); window.location='admin_pesanan.php';</script>");
    }

    $status_lama = strtolower(trim($data_cek['status_pesanan']));
    $boleh_update = false;

    // 2. LOGIKA STATE MACHINE & PENGEMBALIAN STOK
    
    // A. Jika DIBATALKAN (bisa dari status apa saja kecuali selesai)
    if ($status_baru == 'dibatalkan' && $status_lama != 'selesai') {
        
        // Ambil detail pesanan untuk kembalikan stok
        $q_detail = mysqli_query($conn, "SELECT id_menu, jumlah FROM detail_pesanan WHERE id_pesanan = '$id'");
        while ($row = mysqli_fetch_assoc($q_detail)) {
            $id_menu = $row['id_menu'];
            $jml = $row['jumlah'];
            
            // Tambah stok ke tabel menu
            mysqli_query($conn, "UPDATE menu SET stok = stok + $jml WHERE id_menu = '$id_menu'");
            // Pastikan status menu kembali jadi tersedia
            mysqli_query($conn, "UPDATE menu SET status = 'tersedia' WHERE id_menu = '$id_menu' AND stok > 0");
        }
        $boleh_update = true;

    } 
    // Cari bagian: elseif (($status_lama == 'pending' || $status_lama == '') && $status_baru == 'dibayar')
    elseif (($status_lama == 'pending' || $status_lama == '') && $status_baru == 'dibayar') {

    $uang_diterima = isset($_GET['uang']) ? (int)$_GET['uang'] : 0;

    $query_update = "UPDATE pesanan 
                     SET status_pesanan='dibayar',
                         uang_diterima='$uang_diterima'
                     WHERE id_pesanan='$id'";

    if (mysqli_query($conn, $query_update)) {

        header("Location: cetak_invoice.php?id=$id");
exit;
    }
}
    // C. Alur Normal: Dibayar -> Diproses
    elseif ($status_lama == 'dibayar' && $status_baru == 'diproses') {
        $boleh_update = true;
    } 
    // D. Alur Normal: Diproses -> Selesai
    elseif ($status_lama == 'diproses' && $status_baru == 'selesai') {
        $boleh_update = true;
    }

    // 3. EKSEKUSI UPDATE
    if ($boleh_update) {
        $query_update = "UPDATE pesanan SET status_pesanan = '$status_baru' WHERE id_pesanan = '$id'";
        if (mysqli_query($conn, $query_update)) {
            echo "<script>alert('Status berhasil diubah menjadi: " . ucfirst($status_baru) . "'); window.location='admin_pesanan.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui database.'); window.location='admin_pesanan.php';</script>";
        }
    } else {
        echo "<script>alert('Error: Alur pesanan tidak sah atau tidak diizinkan!'); window.location='admin_pesanan.php';</script>";
    }

} else {
    header("location:admin_pesanan.php");
}
?>