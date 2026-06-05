
<link rel="stylesheet" href="../../asset/style_sidebar.css">
<link rel="stylesheet" href="../../main_page/style.css">

<script src="https://unpkg.com/feather-icons"></script>

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

/* Reset */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI',sans-serif;
    background:#f5f6fa;
    color:var(--text);
    margin:0;
}

/* Header */
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

/* Toolbar */
.toolbar{
    background:white;
    padding:18px 20px;
    border-radius:18px;
    box-shadow:0 5px 15px rgba(0,0,0,.06);
    display:flex;
    justify-content:flex-end;
    align-items:center;
    gap:10px;
    margin-bottom:25px;
}

/* Tombol */
a{
    text-decoration:none;
}
.btn-tambah{
    height:48px;
    padding:0 20px;
    display:flex;
    align-items:center;
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

.btn-kembali{
    height:48px;
    padding:0 20px;
    display:flex;
    align-items:center;
    background:#64748b;
    color:white;
    border-radius:12px;
    font-weight:600;
}

/* Table Wrapper */
.table-wrapper{
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 8px 25px rgba(0,0,0,.08);
    border-top:5px solid #8b1e2d;
}

/* Table */
table{
    width:100%;
    border-collapse:collapse;
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

td{
    padding:18px 16px;
    font-size:14px;
    border-bottom:1px solid #e5e7eb;
    vertical-align:middle;
    text-align:center;
}

tbody tr{
    transition:.2s;
}

tbody tr:hover{
    background:#fff7f7;
}

/* Tombol aksi */
.btn-edit{
    background:#fff7ed;
    color:#ea580c;
    padding:8px 14px;
    border-radius:10px;
    font-weight:600;
    display:inline-block;
}

.btn-hapus{
    background:#fef2f2;
    color:#dc2626;
    padding:8px 14px;
    border-radius:10px;
    font-weight:600;
    display:inline-block;
}

.aksi{
    white-space:nowrap;
}
</style>

<?php
include '../menu/koneksi.php';
$halaman = "kategori";
$data = mysqli_query($conn, "SELECT * FROM kategori_menu");

if (!$data) {
    die("Query error: " . mysqli_error($conn));
}
?>
<?php include "../../components/sidebar.php"; ?>
<div class="main-content">
<div class="page-header">
    <h1>Manajemen Kategori</h1>
    <p>Kelola seluruh kategori menu restoran SagalaLada</p>
</div>

<div class="toolbar">
    <a href="tambah_kategori.php" class="btn-tambah">
        + Tambah Kategori
    </a>
</div>

<div class="table-wrapper">
<table>
    <tr>
        <th>No</th>
        <th>Nama Kategori</th>
        <th>Aksi</th>
    </tr>

    <?php $no = 1; ?>

    <?php while ($row = mysqli_fetch_assoc($data)) : ?>
    <tr>
        <td><?= $no++; ?></td>

        <td>
            <?= htmlspecialchars($row['nama_kategori_menu']); ?>
        </td>

        <td class="aksi">
    <a href="edit_kategori.php?id=<?= $row['id_kategori_menu']; ?>" class="btn-edit">
        Edit
    </a>

    <a href="hapus_kategori.php?id=<?= $row['id_kategori_menu']; ?>"
       class="btn-hapus"
       onclick="return confirm('Yakin hapus?')">
        Hapus
    </a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</div>
<script>
feather.replace();
</script>