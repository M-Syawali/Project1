<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_menu = $_POST['id_menu'];
    $stok = $_POST['stok'];
    $status = $_POST['status'];

    for ($i = 0; $i < count($id_menu); $i++) {

        $id = (int)$id_menu[$i];
        $stok_menu = (int)$stok[$i];
        $status_menu = mysqli_real_escape_string($conn, $status[$i]);

        // Cegah angka negatif
        if ($stok_menu < 0) {
            $stok_menu = 0;
        }

        // Otomatis habis jika stok 0
        if ($stok_menu == 0) {
            $status_menu = 'habis';
        }

        $query = "UPDATE menu 
                  SET stok='$stok_menu',
                      status='$status_menu'
                  WHERE id_menu='$id'";

        mysqli_query($conn, $query);
    }

    echo "
    <script>
        alert('Semua data berhasil diupdate');
        window.location='index.php';
    </script>";
    exit;
}
?>