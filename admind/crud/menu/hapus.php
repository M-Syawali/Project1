<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data gambar dulu
    $query = mysqli_query($conn, "SELECT gambar FROM menu WHERE id_menu = '$id'");
    $data = mysqli_fetch_assoc($query);

    // Hapus file gambar jika ada
    if (!empty($data['gambar']) && file_exists("upload/" . $data['gambar'])) {
        unlink("upload/" . $data['gambar']);
    }

    // Hapus data dari database
    $delete = "DELETE FROM menu WHERE id_menu = '$id'";
    
    if (mysqli_query($conn, $delete)) {
        header("Location:../index_admin.php");
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }

} else {
    header("Location:../index_admin.php");
}
?>