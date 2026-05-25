<?php
include '../menu/koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM kategori_menu WHERE id_kategori_menu='$id'");
$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $nama = $_POST['nama_kategori_menu'];

    mysqli_query($conn, "UPDATE kategori_menu SET nama_kategori_menu='$nama' WHERE id_kategori_menu='$id'");
    header("Location: index_kategori.php");
}
?>

<h2>Edit Kategori</h2>

<form method="POST">
    <input type="text" name="nama_kategori_menu" value="<?= $row['nama_kategori_menu']; ?>" required>
    <button type="submit" name="update">Update</button>
</form>