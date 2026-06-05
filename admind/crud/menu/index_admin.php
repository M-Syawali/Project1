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
    <link rel="stylesheet" href="../../main_page/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        background:#f5f6fa;
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

    .page-header{
    background:linear-gradient(135deg,#7d0a0a,#a31621);
    padding:30px;
    border-radius:20px;
    margin-bottom:25px;
    color:white;
    box-shadow:0 10px 25px rgba(0,0,0,.12);
    }

    .page-header h1{
        margin:0;
        font-size:38px;
        font-weight:700;
    }

    .page-header p{
        margin-top:8px;
        opacity:.9;
    }

    .summary-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:25px;
    }

    .summary-card{
        position:relative;
        overflow:hidden;
        background:white;
        padding:24px;
        border-radius:18px;
        border-left:5px solid #8b1e2d;
        box-shadow:0 5px 15px rgba(0,0,0,.06);
    }


    .summary-card span{
        color:#64748b;
    }

    .summary-card h3{
        margin-top:10px;
        font-size:32px;
        color:#7d0a0a;
    }

    .toolbar{
        padding: 18px 20px;
        border-radius:18px;
        box-shadow:0 5px 15px rgba(0,0,0,.06);
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:20px;
        margin-bottom:25px;
    }

    .toolbar-left{
        display:flex;
        align-items:center;
        gap:12px;
        flex-wrap:wrap;
    }

    .toolbar-right{
        display:flex;
        justify-content:flex-end;
    }

    .toolbar input,
    .toolbar select{
        height:48px;
        padding:0 15px;
        border:1px solid #e5e7eb;
        border-radius:12px;
        font-size:14px;
        outline:none;
    }

    .toolbar input:focus,
    .toolbar select:focus{
        border-color:#8b1e2d;
        box-shadow:0 0 0 3px rgba(139,30,45,.1);
    }

    .toolbar input{
        width:280px;
    }

    .btn-cari{
        height:48px;
        padding:0 18px;
        border:none;
        border-radius:12px;
        background:#8b1e2d;
        color:white;
        font-weight:600;
        cursor:pointer;
    }

    .btn-tambah{
        height:48px;
        padding:0 20px;
        display:flex;
        align-items:center;
        text-decoration:none;
        background:#8b1e2d;
        color:white;
        border-radius:12px;
        font-weight:600;
        transition:.25s;
        box-shadow:0 8px 18px rgba(139,30,45,.25);
    }

    .btn-tambah:hover{
        transform:translateY(-2px);
    }

    .table-wrapper{
        background:white;
        border-radius:20px;
        overflow:hidden;
        box-shadow:0 8px 25px rgba(0,0,0,.08);
        border-top:5px solid #8b1e2d;
    }

    .col-no{
    width:60px;
    }

    .col-gambar{
        width:120px;
    }

    .col-menu{
        width:250px;
    }

    .col-kategori{
        width:150px;
    }

    .col-deskripsi{
        width:auto;
    }

    .col-harga{
        width:140px;
    }

    .col-aksi{
        width:150px;
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


    .btn-success { background: var(--success); color: white; }
    

    .btn-edit{
    background:#fff7ed;
    color:#ea580c;
    border:none;
    padding:8px 14px;
    border-radius:10px;
    }

    .btn-hapus{
        background:#fef2f2;
        color:#dc2626;
        border:none;
        padding:8px 14px;
        border-radius:10px;
    }
    

    table {
        width: 100%;
        border-collapse: collapse;
    }

    tbody tr{
        transition:.2s;
    }

    tbody tr:hover{
        background:#fff7f7;
    }

    th{
        text-align:center;
        font-size:15px;
        letter-spacing:.3px;
        background:#8b1e2d;
        color:white;
        padding:20px;
        font-weight:600;
    }

    td {
        padding: 18px 16px;
        font-size: 14px;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
    }

    td:nth-child(1),
    td:nth-child(2),
    td:nth-child(4),
    td:nth-child(6),
    td:nth-child(7){
    text-align:center;
    vertical-align:middle;
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
    <div class="page-header">
    <div>
        <h1>Manajemen Menu</h1>
        <p>
            Kelola seluruh menu restoran SagalaLada
        </p>
    </div>
</div>
    <?php
    // --- LETAKKAN KODE BARU DI SINI ---
        function hitungKategori($conn, $nama_kategori) {
            $query = "SELECT COUNT(*) as total 
                    FROM menu 
                    JOIN kategori_menu ON menu.id_kategori_menu = kategori_menu.id_kategori_menu 
                    WHERE kategori_menu.nama_kategori_menu = '$nama_kategori'";
            $hasil = mysqli_query($conn, $query);
            $data = mysqli_fetch_assoc($hasil);
            return $data['total'];
        }

        $totalMenu = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM menu"));
        $totalMakanan = hitungKategori($conn, 'Makanan'); 
        $totalMinuman = hitungKategori($conn, 'Minuman');
        $totalPaket   = hitungKategori($conn, 'Paket');
        // ----------------------------------

        // TAMBAHKAN INI:
        $query_kategori = "SELECT * FROM kategori_menu";
        $result_kategori = mysqli_query($conn, $query_kategori);

    ?>
    
    <div class="summary-grid">

        <div class="summary-card">
            <span>Total Menu</span>
            <h3><?= $totalMenu ?></h3>
        </div>

        <div class="summary-card">
            <span>Menu Makanan</span>
            <h3><?= $totalMakanan ?></h3>
        </div>

        <div class="summary-card">
            <span>Menu Minuman</span>
            <h3><?= $totalMinuman ?></h3>
        </div>

        <div class="summary-card">
            <span>Menu Paket</span>
            <h3><?= $totalPaket ?></h3>
        </div>

    </div>

    <div class="toolbar">
    <div class="toolbar-left">
        <input type="text" placeholder="Cari menu...">
        <select name="kategori">
            <option value="">Semua Kategori</option>
            <?php 
            // TAMBAHKAN LOOPING INI:
            while($k = mysqli_fetch_assoc($result_kategori)) { ?>
                <option value="<?= $k['id_kategori_menu']; ?>">
                    <?= $k['nama_kategori_menu']; ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit" class="btn-cari">
            Cari
        </button>
    </div>

    <div class="toolbar-right">
        <a href="tambah.php" class="btn-tambah">
            + Tambah Menu
        </a>
    </div>
</div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-gambar">Gambar</th>
                    <th class="col-menu">Nama Menu</th>
                    <th class="col-kategori">Kategori</th>
                    <th>Deskripsi</th>
                    <th class="col-harga">Harga</th>
                    <th class="col-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            // 1. Jalankan query-nya terlebih dahulu DI ATAS perulangan
            $query = "SELECT menu.*, kategori_menu.nama_kategori_menu 
                    FROM menu 
                    LEFT JOIN kategori_menu ON menu.id_kategori_menu = kategori_menu.id_kategori_menu";
            $result = mysqli_query($conn, $query); 

            // 2. Baru lakukan perulangan
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
                        <a href="edit.php?id=<?= $row['id_menu']; ?>" class="btn btn-edit">Edit</a>
                        <a href="hapus.php?id=<?= $row['id_menu']; ?>" class="btn btn-hapus" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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