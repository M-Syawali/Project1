
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manajemen Kategori</title>

<link rel="stylesheet" href="../../asset/style_sidebar.css">

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
    font-family: 'Poppins', Tahoma, Geneva, Verdana, sans-serif;
    background: #f8f5f2;
    color:var(--text);
    margin:0;
}

.main-content{
    margin-left:260px;
    padding:25px;
}

/* Header */
    .page-header{
        background:linear-gradient(135deg,#7d0a0a,#a31621);
        padding:20px 25px;
        border-radius:18px;
        margin-bottom:25px;
        color:white;
        box-shadow:0 10px 25px rgba(0,0,0,.12);
        }

    .page-header h1{
        margin:0;
        font-size:24px;
        font-weight:600;
    }

    .page-header p{
        margin-top:6px;
        opacity:.9;
        font-size: 14px;
        color:rgba(255,255,255,.85);
    }

/* Summary Card */
.summary-grid{
      margin-top: 30px;
  display: grid;

  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));

  gap: 20px;
  margin-bottom: 25px;
}

.summary-card{
    min-height: 110px;

    padding:24px;

    display:flex;
    align-items:center;
    gap:16px;

    background:#fff;
    border-radius:20px;

    box-shadow:0 8px 20px rgba(0,0,0,.06);
}

.summary-icon{
            width:64px;
            height:64px;

            border-radius:18px;

            display:flex;
            align-items:center;
            justify-content:center;

            flex-shrink:0;

            background:#fdf1f1;
        }

        .summary-icon svg{
            width:28px;
            height:28px;
}

        .summary-card span{
            font-size:13px;
            font-weight:600;
            color:#64748b;
        }

        .summary-card h3{
            margin-top:4px;

            font-size:28px;
            line-height:1.1;

            font-weight:700;
            color:#7d0a0a;
        }


.summary-card small{
    font-size:13px;
    color:#94a3b8;
}

/* Toolbar */
.toolbar{
    display:flex;
    align-items:center;
    margin-bottom:12px;
    padding: 10px 0;
}

.btn-tambah{
    display: inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    widht:auto;
    height:48px;
    padding:0 20px;

    background:#8b1e2d;
    color:white;

    border-radius:12px;
    font-size:14px;
    font-weight:600;

    transition:.25s;
    box-shadow:0 8px 18px rgba(139,30,45,.25);
}

.btn-tambah:hover{
    transform:translateY(-2px);
}
/* Tombol */
a{
    text-decoration:none;
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
    border-right: 1px solid #ddd;
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
    display:flex;
    justify-content:center;
    gap:8px;
}

.table-footer{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 20px;
    font-size:14px;
    color:#6b7280;
}

.pagination{
    display:flex;
    align-items:center;
    gap:8px;
}

.page-btn,
.page-number{
    width:38px;
    height:38px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:10px;
    text-decoration:none;

    border:1px solid #e5e7eb;
    background:white;
    color:#64748b;

    transition:.2s;
}

.page-btn:hover,
.page-number:hover{
    background:#f8fafc;
}

.page-number.active{
    background:#8b1e2d;
    color:white;
    border-color:#8b1e2d;
}

.page-btn.disabled{
    pointer-events:none;
    opacity:.4;
    cursor:not-allowed;
}

.page-btn svg{
    width:18px;
    height:18px;
}
</style>

</head>
<body>

<?php
include '../menu/koneksi.php';

$halaman = "kategori";

$perPage = 2;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$totalData = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM kategori_menu
"))['total'];

$totalPage = max(1, ceil($totalData / $perPage));

if ($page > $totalPage) $page = $totalPage;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $perPage;

$startData = ($totalData == 0) ? 0 : $offset + 1;
$endData = min($offset + $perPage, $totalData);

$data = mysqli_query($conn, "
    SELECT *
    FROM kategori_menu
    LIMIT $perPage OFFSET $offset
");

if (!$data) {
    die("Query error: " . mysqli_error($conn));
}

$qKategori = mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM kategori_menu
");

$totalKategori = mysqli_fetch_assoc($qKategori)['total'] ?? 0;

$qMenu = mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM menu
");

$totalMenu = mysqli_fetch_assoc($qMenu)['total'] ?? 0;

$qTopKategori = mysqli_query($conn, "
    SELECT 
        k.nama_kategori_menu,
        COUNT(m.id_menu) as total_menu
    FROM kategori_menu k
    LEFT JOIN menu m ON k.id_kategori_menu = m.id_kategori_menu
    GROUP BY k.id_kategori_menu
    ORDER BY total_menu DESC
    LIMIT 1
");

$top = mysqli_fetch_assoc($qTopKategori);

$namaTopKategori = $top['nama_kategori_menu'] ?? '-';
$totalTopMenu = $top['total_menu'] ?? 0;

?>


<?php include "../../components/sidebar.php"; ?>

<div class="main-content">

    <!-- HEADER -->
    <div class="page-header">
        <h1>Manajemen Kategori</h1>
        <p>Kelola seluruh kategori menu restoran SagalaLada</p>
    </div>

    <!-- SUMMARY -->
   <div class="summary-grid">

    <div class="summary-card">
        <div class="summary-icon">
            <i data-feather="tag"></i>
        </div>
        <div>
            <span>Total Kategori</span>
            <h3><?= $totalKategori; ?></h3>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon">
            <i data-feather="grid"></i>
        </div>
        <div>
            <span>Total Menu</span>
            <h3><?= $totalMenu; ?></h3>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon">
            <i data-feather="trending-up"></i>
        </div>
        <div>
            <span>Kategori Terbanyak</span>
            <h3><?= $namaTopKategori; ?></h3>
            <small><?= $totalTopMenu; ?> menu</small>
        </div>
    </div>

</div>
        
    

    <!-- TOOLBAR -->
     <div class="toolbar">

    <a href="tambah_kategori.php" class="btn-tambah">
        <i data-feather="plus"></i>
        Tambah Kategori
    </a>

</div>
    <!-- TABEL -->
    <div class="table-wrapper" id="kategori-table">

        <table>

            <thead>
                <tr>
                    <th width="80">No</th>
                    <th>Nama Kategori</th>
                    <th width="220">Aksi</th>
                </tr>
            </thead>

            <tbody>

           <?php $no = $offset + 1; ?>

            <?php while ($row = mysqli_fetch_assoc($data)) : ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td>
                        <?= htmlspecialchars($row['nama_kategori_menu']); ?>
                    </td>

                    <td class="aksi">

                        <a
                            href="edit_kategori.php?id=<?= $row['id_kategori_menu']; ?>"
                            class="btn-edit">
                            Edit
                        </a>

                        <a
                            href="hapus_kategori.php?id=<?= $row['id_kategori_menu']; ?>"
                            class="btn-hapus"
                            onclick="konfirmasiHapusKategori(event, this.href)">
                            Hapus
                        </a>
                    </td>

                </tr>

            <?php endwhile; ?>

            </tbody>

        </table>
       
</div>
 <div class="table-footer">

    <div class="showing-info">
        Menampilkan <?= $startData ?> - <?= $endData ?>
        dari <?= $totalData ?> kategori
    </div>

    <div class="pagination">

        <!-- Kiri -->
        <a href="?page=<?= $page - 1 ?>#kategori-table"
           class="page-btn <?= ($page <= 1) ? 'disabled' : '' ?>">
            <i data-feather="chevron-left"></i>
        </a>

        <!-- Tengah -->
        <span class="page-number active">
            <?= $page ?>
        </span>

        <!-- Kanan -->
        <a href="?page=<?= $page + 1 ?>#kategori-table"
           class="page-btn <?= ($page >= $totalPage) ? 'disabled' : '' ?>">
            <i data-feather="chevron-right"></i>
        </a>

    </div>

</div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
feather.replace();
</script>
<script>
function konfirmasiHapusKategori(event, url) {
    event.preventDefault();

    Swal.fire({
        title: 'Hapus Kategori?',
        html: '<b>Kategori akan dihapus.</b>',
        icon: 'error',

        showCancelButton: true,

        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',

        confirmButtonColor: '#8b1e2d',
        cancelButtonColor: '#6b7280',

        background: '#ffffff',
        color: '#333'
    }).then((result) => {

        if (result.isConfirmed) {
            window.location.href = url;
        }

    });
}
</script>
</body>
</html>
