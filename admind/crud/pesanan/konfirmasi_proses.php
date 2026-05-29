<?php
include 'koneksi.php';

if(isset($_GET['id']) && isset($_GET['status'])){
    $id = $_GET['id'];
    $status = $_GET['status'];

    // Update status berdasarkan ID yang dikirim
    $query = "UPDATE pesanan SET status_pesanan = '$status' WHERE id_pesanan = '$id'";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Status berhasil diperbarui!'); window.location='admin_pesanan.php';</script>";
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}
?>