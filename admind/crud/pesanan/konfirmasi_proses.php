<?php
include "koneksi.php";

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $status_baru = mysqli_real_escape_string($conn, $_GET['status']);

    // 1. Ambil status saat ini dari database
    $query_cek = "SELECT status_pesanan FROM pesanan WHERE id_pesanan = '$id'";
    $res_cek = mysqli_query($conn, $query_cek);
    $data_cek = mysqli_fetch_assoc($res_cek);

    if (!$data_cek) {
        die("Pesanan tidak ditemukan");
    }

    $status_lama = strtolower(trim($data_cek['status_pesanan']));

    // 2. Logika Validasi Alur (State Machine)
    $boleh_update = false;

    // Batalkan boleh dari status apa pun selain selesai
    if ($status_baru == 'dibatalkan' && $status_lama != 'selesai') {

        $boleh_update = true;

    }
    // Pending -> Dibayar
    elseif (
        $status_lama == '' ||
        $status_lama == 'pending' ||
        $status_lama == 'menunggu_bayar'
    ) {

        if ($status_baru == 'dibayar') {
            $boleh_update = true;
        }

    }
    // Dibayar -> Diproses
    elseif ($status_lama == 'dibayar') {

        if ($status_baru == 'diproses') {
            $boleh_update = true;
        }

    }
    // Diproses -> Selesai
    elseif ($status_lama == 'diproses') {

        if ($status_baru == 'selesai') {
            $boleh_update = true;
        }

    }

    // 3. Eksekusi jika valid
    if ($boleh_update) {
        $query_update = "UPDATE pesanan SET status_pesanan = '$status_baru' WHERE id_pesanan = '$id'";
        if (mysqli_query($conn, $query_update)) {
            echo "<script>alert('Status berhasil diubah menjadi $status_baru.'); window.location='admin_pesanan.php';</script>";
        } else {
            echo "<script>alert('Gagal update database.'); window.location='admin_pesanan.php';</script>";
        }
    } else {
        echo "<script>alert('Error: Alur pesanan tidak sah! Anda tidak bisa melompati tahapan.'); window.location='admin_pesanan.php';</script>";
    }
} else {
    header("location:admin_pesanan.php");
}
?>