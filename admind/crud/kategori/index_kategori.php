<style>
    /* Reset dasar */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f6f9;
    padding: 20px;
}

/* Judul */
h2 {
    margin-bottom: 15px;
    color: #2c3e50;
}

/* Tombol tambah */
a {
    text-decoration: none;
}
.btn{
    display:inline-block;
    padding:10px 15px;
    border:2px solid green;
    color:green;
    text-decoration:none;
    border-radius:5px;
    margin-bottom:15px;
}

.btn:hover{
    background:green;
    color:white;
}
a[href="tambah_kategori.php"] {
    display: inline-block;
    margin-bottom: 15px;
    padding: 10px 15px;
    background-color: #2ecc71;
    color: white;
    border-radius: 6px;
    font-weight: bold;
    transition: 0.3s;
}

a[href="tambah_kategori.php"]:hover {
    background-color: #27ae60;
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* Header tabel */
table th {
    background-color: #34495e;
    color: white;
    padding: 12px;
    text-align: center;
}

/* Isi tabel */
table td {
    padding: 10px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

/* Hover row */
table tr:hover {
    background-color: #f2f2f2;
}

/* Tombol aksi */
td a {
    padding: 6px 10px;
    border-radius: 5px;
    font-size: 13px;
    margin: 0 3px;
    color: white;
}

/* Edit */
td a:first-child {
    background-color: #3498db;
}

td a:first-child:hover {
    background-color: #2980b9;
}

/* Hapus */
td a:last-child {
    background-color: #e74c3c;
}

td a:last-child:hover {
    background-color: #c0392b;
}
</style>

<?php
include '../menu/koneksi.php';

$data = mysqli_query($conn, "SELECT * FROM kategori_menu");

if (!$data) {
    die("Query error: " . mysqli_error($conn));
}
?>
<h2>Data Kategori</h2>
<a href="tambah_kategori.php" class="btn">+ Tambah Kategori</a>
<a href="../menu/index_admin.php" class="btn">kembali ke Menu</a>
<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama Kategori</th>
        <th>Aksi</th>
    </tr>

    <?php $no = 1; ?>
    <?php while($row = mysqli_fetch_assoc($data)) : ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($row['nama_kategori_menu']); ?></td>
        <td>
            <a href="edit_kategori.php?id=<?= $row['id_kategori_menu']; ?>">Edit</a>
            <a href="hapus_kategori.php?id=<?= $row['id_kategori_menu']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>