
<?php
include "koneksi.php";

$perPage = 2;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

/* 1. hitung total data */
$totalData = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) as total FROM menu
"))['total'];

$totalPage = max(1, ceil($totalData / $perPage));

/* 2. validasi page */
if ($page > $totalPage) $page = $totalPage;
if ($page < 1) $page = 1;

/* 3. baru hitung offset */
$offset = ($page - 1) * $perPage;

$startData = ($totalData == 0) ? 0 : $offset + 1;
$endData = min($offset + $perPage, $totalData);

/* 4. baru query data */
$query = "SELECT menu.*, kategori_menu.nama_kategori_menu
          FROM menu
          LEFT JOIN kategori_menu 
          ON menu.id_kategori_menu = kategori_menu.id_kategori_menu
          LIMIT $perPage OFFSET $offset";

$result = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Menu - SagalaLada</title>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="../../asset/style_sidebar.css">
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

    *{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

    body {
        font-family: "Poppins", sans-serif;
        background: #f8f5f2;
        margin: 0;
        color: var(--text);
    }

    .main-content {
        margin-left: 260px;
        padding: 25px;
    }

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
    .toolbar{
        padding:10px 0;
        margin-bottom: 10px;
    }




    .toolbar-body{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:20px;
    }

    .toolbar-left{
        display:flex;
        gap:12px;
        flex-wrap:wrap;
    }

    .toolbar-right{
        display:flex;
    }

    .toolbar input,
    .toolbar select{
        height:48px;
        padding:0 15px;
        border:1px solid #d1d5db;
        border-radius:12px;
        font-size:14px;
    }

    .toolbar input{
        width:280px;
    }

    .toolbar input:focus,
    .toolbar select:focus{
        outline:none;
        border-color:#8b1e2d;
        box-shadow:0 0 0 4px rgba(139,30,45,.12);
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
        margin-bottom: 0;
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

    .table-footer{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:15px 20px;
            font-size:14px;
            color:#6b7280;
        }

        .page-btn.disabled{
    pointer-events:none;
    opacity:.4;
    cursor:not-allowed;
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

        .page-btn svg{
            width:18px;
            height:18px;
        }
    </style>
</head>
<body>
<?php $halaman = "menu"; ?>
<?php include "../../components/sidebar.php"; ?>
<div class="main-content">
    <div class="page-header">
        <h1>Manajemen Menu</h1>
        <p>Kelola daftar menu restoran, kategori, harga, dan informasi produk yang tersedia.</p>
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
        <div class="summary-icon">
            <i data-feather="grid"></i>
        </div>

        <div>
            <span>Total Menu</span>
            <h3><?= $totalMenu ?></h3>
            <small>Seluruh menu yang tersedia</small>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon">
            <i data-feather="archive"></i>
        </div>

        <div>
            <span>Menu Makanan</span>
            <h3><?= $totalMakanan ?></h3>
            <small>Kategori makanan</small>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon">
            <i data-feather="coffee"></i>
        </div>

        <div>
            <span>Menu Minuman</span>
            <h3><?= $totalMinuman ?></h3>
            <small>Kategori minuman</small>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon">
            <i data-feather="shopping-bag"></i>
        </div>

        <div>
            <span>Menu Paket</span>
            <h3><?= $totalPaket ?></h3>
            <small>Menu dalam bentuk paket</small>
        </div>
    </div>

</div>

   <div class="toolbar">

    <div class="toolbar-body">

        <div class="toolbar-left">

            <input
                type="text"
                id="searchInput"
                placeholder="Cari menu...">

            <select id="kategoriSelect" name="kategori">
                <option value="">Semua Kategori</option>

                <?php while($k = mysqli_fetch_assoc($result_kategori)) { ?>
                    <option value="<?= $k['id_kategori_menu']; ?>">
                        <?= $k['nama_kategori_menu']; ?>
                    </option>
                <?php } ?>

            </select>

        </div>

        <div class="toolbar-right">

            <a href="tambah.php" class="btn-tambah">
                <i data-feather="plus"></i>
                Tambah Menu
            </a>

        </div>

    </div>

</div>

    <div class="table-wrapper" id="menu-table">
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

            // 2. Baru lakukan perulangan
            $no = $offset + 1;
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
<div class="table-footer">

    <div class="showing-info">
        Menampilkan <?= $startData ?> - <?= $endData ?>
        dari <?= $totalData ?> menu
    </div>

    <div class="pagination">

        <a href="?page=<?= $page - 1 ?>#menu-table"
             class="page-btn <?= ($page <= 1) ? 'disabled' : '' ?>">
            <i data-feather="chevron-left"></i>
        </a>

        <span class="page-number active">
            <?= $page ?>
        </span>

        <a href="?page=<?= $page + 1 ?>#menu-table"
   class="page-btn <?= ($page >= $totalPage) ? 'disabled' : '' ?>">
            <i data-feather="chevron-right"></i>
        </a>

    </div>

</div>

</div>

    </div>
</div>
</div>
<script>
feather.replace();
</script>

<script>
document.getElementById("searchInput").addEventListener("input", cariMenu);
document.getElementById("kategoriSelect").addEventListener("change", cariMenu);

function cariMenu() {
    let keyword = document.getElementById("searchInput").value.toLowerCase();
    let kategori = document.getElementById("kategoriSelect").value;

    let rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
        let namaMenu = row.cells[2].innerText.toLowerCase(); // kolom Nama Menu
        let namaKategori = row.cells[3].innerText; // kolom Kategori

        let cocokNama = namaMenu.includes(keyword);

        let cocokKategori = true;
        if (kategori !== "") {
            let selectText = document.querySelector(
                '#kategoriSelect option[value="' + kategori + '"]'
            ).textContent.trim();

            cocokKategori = namaKategori.trim() === selectText;
        }

        if (cocokNama && cocokKategori) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}
</script>
</body>
</html>