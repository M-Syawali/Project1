<?php
// Karena konfirmasi_proses.php dan koneksi.php berada di folder yang sama (crud/pesanan)
include "koneksi.php";

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);

    // Proses Update ke Database
    $query = "UPDATE pesanan SET status_pesanan = '$status' WHERE id_pesanan = '$id'";
    $update = mysqli_query($conn, $query);

    if ($update) {
        // Jika berhasil, munculkan alert dan kembali ke halaman admin_pesanan yang ada di main_page
        echo "<script>
                alert('Pesanan #$id telah diubah statusnya menjadi $status.');
                window.location='admin_pesanan.php';
              </script>";
    } else {
        // Jika gagal karena masalah database
        echo "Gagal memperbarui status: " . mysqli_error($conn);
    }
} else {
    // Jika diakses tanpa parameter yang benar, tendang balik ke halaman utama di main_page
    header("location:admin_pesanan.php");
    exit;
}
?>