<?php
include '../menu/koneksi.php';

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan");
}

$id = $_GET['id'];

/* cek apakah kategori dipakai menu */
$cek = mysqli_query(
    $conn,
    "SELECT * FROM menu WHERE id_kategori_menu='$id'"
);

if(mysqli_num_rows($cek) > 0){
    echo "
    <script>
        alert('Kategori tidak bisa dihapus karena masih digunakan menu');
        window.location='index_kategori.php';
    </script>
    ";
    exit;
}

/* hapus kategori */
$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM kategori_menu WHERE id_kategori_menu = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

if(mysqli_stmt_execute($stmt)){
    header("Location: index_kategori.php");
    exit;
}else{
    echo "Gagal menghapus data";
}
?>