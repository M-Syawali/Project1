<?php
// PERBAIKAN: Keluar dari folder main_page, masuk ke crud/pesanan tempat koneksi.php berada
include "koneksi.php";

global $conn;
global $query;

// Mengambil data menu sekalian di-join dengan kategori_menu agar tampil nama kategorinya
// PERBAIKAN: Menyesuaikan nama kolom deskripsi jika ada perbedaan (disesuaikan dengan syntax query Anda)
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
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="../../asset/style_sidebar.css">
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
        background: linear-gradient(135deg,#5c0f16,#8b1e2d,#b33646);
        margin: 0;
        color: var(--text);
    }

    .main-content {
        margin-left: 260px;
        padding: 20px;
    }
    .container {
        max-width: 1400px;
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
        color: white;
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        overflow-x: auto;
    }

    .btn {
        padding: 8px 14px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: 0.2s;
        display: inline-block;
    }

    .btn-primary { background: var(--accent); color: white; }
    .btn-success { background: var(--success); color: white; }
    .btn-danger { background: var(--danger); color: white; }

    .top-buttons { display: flex; gap: 10px; }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: var(--primary);
        color: white;
        padding: 12px;
        font-size: 14px;
        text-align: left;
    }

    td {
        padding: 12px;
        font-size: 14px;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: top;
    }

    /* Styling khusus untuk teks deskripsi */
    .deskripsi-col {
        max-width: 300px;
        color: #475569;
        font-size: 13px;
        line-height: 1.5;
    }

    .menu-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .aksi { white-space: nowrap; }
    </style>
</head>
<body>
<?php $halaman = "menu"; ?>
<?php include "../../components/sidebar.php"; ?>
<div class="main-content">
    <div class="container">
    <div class="header">
        <h2>Menu SagalaLada</h2>
        <div class="top-buttons">
        </div>
    </div>

    <div style="margin-bottom: 20px;">
        <a href="tambah.php" class="btn btn-success">+ Tambah Menu</a>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th> 
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
                            <img src="upload/<?= $row['gambar']; ?>" class="menu-img">
                        <?php } else { ?>
                            <span>-</span>
                        <?php } ?>
                    </td>
                    <td><b><?= htmlspecialchars($row['nama_menu']); ?></b></td>
                    <td><?= htmlspecialchars($row['nama_kategori_menu'] ?? 'Tanpa Kategori'); ?></td>
                    
                    <td>
                        <div class="deskripsi-col">
                            <?= nl2br(htmlspecialchars($row['deskripsi_menu'] ?? '-')); ?>
                        </div>
                    </td>

                    <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td class="aksi">
                        <a href="edit.php?id=<?= $row['id_menu']; ?>" class="btn btn-primary">Edit</a>
                        <a href="hapus.php?id=<?= $row['id_menu']; ?>" 
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
</div>

</div>
<script>
feather.replace();
</script>
</body>
</html>