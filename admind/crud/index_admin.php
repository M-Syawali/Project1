<?php
include 'menu/koneksi.php';
global $conn;
global $query;

// Mengambil data menu sekalian di-join dengan kategori_menu agar tampil nama kategorinya
$query = "SELECT menu.*, kategori_menu.nama_kategori_menu
          FROM menu
          LEFT JOIN kategori_menu 
          ON menu.id_kategori_menu = kategori_menu.id_kategori_menu";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Menu - SagalaLada</title>

    <style>
    :root {
        --primary: #1e293b;
        --accent: #f97316;
        --success: #22c55e;
        --danger: #ef4444;
        --bg: #f1f5f9;
        --text: #0f172a;
    }

    body {
        font-family: 'Segoe UI', sans-serif;
        background: var(--bg);
        margin: 0;
        padding: 20px;
        color: var(--text);
    }

    .container {
        max-width: 1100px;
        margin: auto;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    h2 {
        margin: 0;
        color: var(--primary);
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }

    .btn {
        padding: 8px 14px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: 0.2s;
    }

    .btn-primary {
        background: var(--accent);
        color: white;
    }

    .btn-primary:hover {
        background: #ea580c;
    }

    .btn-success {
        background: var(--success);
        color: white;
    }

    .btn-success:hover {
        background: #16a34a;
    }

    .btn-danger {
        background: var(--danger);
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: var(--primary);
        color: white;
        padding: 12px;
        font-size: 14px;
    }

    td {
        padding: 12px;
        font-size: 14px;
        border-bottom: 1px solid #e5e7eb;
    }

    tr:hover {
        background: #f9fafb;
    }

    .menu-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .aksi a {
        margin-right: 5px;
    }

    </style>
</head>
<body>

<div class="container">

    <div class="header">
        <h2>Menu SagalaLada</h2>
        <a href="menu/tambah.php" class="btn btn-success">+ Tambah Menu</a>
    </div>

    <div class="card">

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            <?php 
            $no = 1;
            while($row = mysqli_fetch_assoc($result)) { 
            ?>

            <tr>
                <td><?= $no++; ?></td>

                <td>
                <?php if (!empty($row['gambar'])) { ?>
                    <img src="menu/upload/<?= $row['gambar']; ?>" class="menu-img">
                <?php } else { ?>
                    <span>-</span>
                <?php } ?>
                </td>

                <td><b><?= htmlspecialchars($row['nama_menu']); ?></b></td>

                <td><?= htmlspecialchars($row['nama_kategori_menu'] ?? 'Tanpa Kategori'); ?></td>

                <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>

                <td class="aksi">
                    <a href="menu/edit.php?id=<?= $row['id_menu']; ?>" class="btn btn-primary">Edit</a>
                    <a href="menu/hapus.php?id=<?= $row['id_menu']; ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('Yakin ingin menghapus menu ini?')">
                       Hapus
                    </a>
                </td>
            </tr>

            <?php } ?>

            </tbody>
        </table>

    </div>
   <br>
    <a href="../main_page/dashboard.html" class="btn btn-success">Dashboard</a>
    <a href="kategori/index_kategori.php" class="btn btn-success">Kategori</a>

</div>

</body>
</html>