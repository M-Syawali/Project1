<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - Pesanan Aktif</title>
    <script src="https://unpkg.com/feather-icons"></script>
    
    <link rel="stylesheet" href="../../asset/style_sidebar.css">
    <style>

        body {
            font-family: 'Poppins', Tahoma, Geneva, Verdana, sans-serif;
            background:#f5f6fa;
            min-height: 100vh;
            margin: 0;
        }

        .main-content{
            margin-left: 260px;
            padding: 40px;
        }

        .page-header{
            background: linear-gradient(135deg,#7d0a0a,#8b1e2d);
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

        .header-desc{
            margin-top:8px;
            color:rgba(255,255,255,.85);
            font-size:15px;
        }

        .summary-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:20px;
            margin-bottom:25px;
        }

        .summary-card{
            background:white;
            padding:24px;
            border-radius:18px;
            box-shadow:0 5px 15px rgba(0,0,0,.06);
            border-left:5px solid #8b1e2d;
        }

        .summary-card span{
            color:#64748b;
            font-size:14px;
        }

        .summary-card h3{
            margin-top:8px;
            margin-bottom:0;
            font-size:32px;
            color:#7d0a0a;
        }

        @media(max-width:1200px){

        .summary-grid{
            grid-template-columns:repeat(2,1fr);
        }
        }

        @media(max-width:768px){

        .main-content{
            margin-left:0px;
            padding:20px;
        }

        .summary-grid{
            grid-template-columns:1fr;
        }

        .page-header h1{
            font-size:28px;
        }
        }

        .filter-bar{
            display:flex;
            justify-content: space-between;
            align-items: center;
            gap:15px;
            margin-bottom:20px;
        }

        .filter-right{
            display:flex;
            justify-content:flex-end;
        }
        .filter-bar input{
            padding:12px 15px;
            border:1px solid #e5e7eb;
            border-radius:12px;
            font-size:14px;
            outline:none;
            min-width:220px;
        }

        .filter-bar select{
            padding:12px 15px;
            border:1px solid #e5e7eb;
            border-radius:12px;
            font-size:14px;
            outline:none;
            min-width:200px;
        }

        .filter-bar input:focus,
        .filter-bar select:focus{
            border-color:#8b1e2d;
            box-shadow:0 0 0 3px rgba(139,30,45,.1);
        }

        .btn-search,
        .btn-reset{
            padding:12px 18px;
            font-size:14px;
            font-weight:600;
            border-radius:10px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            height:42px; /* ini kunci biar sama */
            box-sizing:border-box;
        }

        .btn-search{
            background:#8b1e2d;
            color:white;
            border:none;
            cursor:pointer;
        }

        .btn-reset{
            background:#6b7280;
            color:white;
            text-decoration:none;
        }

        .btn-search:hover{
            background:#6f0f1a;
        }

        .btn-reset:hover{
            background:#4b5563;
        }


        .table-footer{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:15px 20px;
            background:#fff;
            border-top:1px solid #eee;
            font-size:14px;
            color:#6b7280;
        }

        .table-wrapper{
            background:white;
            padding:0;
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 8px 25px rgba(0,0,0,.08);
            border-top:5px solid #8b1e2d;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-right: 1px solid #ddd;
        }
        td {
            padding:14px 16px;
            border-bottom:1px solid #e5e7eb;
        }

        tbody tr{
            transition:.2s;
        }

        tbody tr:hover{
            background:#fff7f7;
        }
        th {
            background: rgba(139,30,45,.92);
            backdrop-filter: blur(10px);
            color: #fff;
            padding: 22px;
            font-size: 16px;
            font-weight: 600;
            border-right: 1px solid rgba(255,255,255,.15);
        }

        .pelanggan-box {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .pelanggan-icon{
            width:55px;
            height:55px;
            border-radius:50%;
            background:#fdf2f2;
            color:#8b1e2d;
            display:flex;
            justify-content:center;
            align-items:center;
            flex-shrink:0;
        }
        .pelanggan-icon svg{
            width:24px;
            height:24px;
            stroke:#8b1e2d;
        }
        .nomor-pesanan {
            font-size: 20px;
            font-weight: 600;
            color: #8b1e2d;
            margin-bottom: 1.2px;
            display: block;
        }
        .nama-pelanggan{
        font-size: 19px;  
        color: #111;
        
        }
        
        .total-bayar {
            font-size: 20px;
            font-weight: 400;
            color: #7a1a26;
        }
        
        .status-badge {
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }
            
        
        /* Warna Status */
        .diproses {
            background: #b8daff;
            color: #004085;
        }

        .selesai {
            background: #d4edda;
            color: #155724;
        }
        .dibayar {
            background: #c3e6cb;
            color: #155724;
            border: 1px solid green;
        }

        .pending {
            background: #fff3cd;
            color: #856404;
        } 

        .btn-batal:hover{
            background:#b91c1c;
        }

        .btn-selesai:hover{
            background:#15803d;
        }

        .btn-bayar:hover{
            background:#2563eb;
        }
        .item-menu {
            padding: 6px 0;
            border-bottom: 1px dashed rgba(0,0,0,0.25);
            
        }
        .item-menu:last-child {
            border-bottom: none;
        }
        .nama-menu{
            display: flex;
            align-items:center;
            gap: 8px;
            font-size:25px;
            font-weight:450;
            color:#7a1a26;
            margin-bottom:2px;
        }

        .qty{
            background:#fdf2f2;
            color:#8b1e2d;
            padding:2px 8px;
            border-radius:20px;
            font-size:15px;
            font-weight:600;
            line-height:1;
        }
        
        .menu-pedas{padding:4px 10px;
            background:#ffe5e5;
            color:#c62828;
            border-radius:20px;
            font-size:12px;
            font-weight:600;}

        .detail-menu,
        .catatan-menu {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 3px;
            
        }
        .detail-menu svg {
            width: 14px;
            height: 14px;
            color: #ea580c;
        }
        .catatan-menu svg {
            width: 14px;
            height: 14px;
            color: #6b7280;
        }
        .text-muted{
            color: #4b5563;
            font-size: 12px;
        }
        .btn-status {
            padding:10px 15px;
            text-decoration:none;
            border-radius:10px;
            font-size:13px;
            display:inline-flex;
            align-items:center;
            gap:8px;
            margin:2px;
            color:white;
            font-weight:600;
            transition:.2s;
        }
        .btn-status svg{
            width: 16px;
            height: 16px;
        }
        .btn-status:hover {  opacity: 0.8; }
        .btn-batal { background: #dc3545; }
        .btn-proses { background: #ffc107; color: black !important; }
        .btn-selesai { background: #28a745; }
        .btn-bayar { background: #007bff; }


        ul{
        list-style:none;
        padding:0;
        margin:0;
        }

        .badge-meja{
    background:#ffe5e5;
    color:#8b1e2d;
    padding:6px 12px;
    border-radius:1px;
    font-weight:600;
    font-size:18px;
}
    </style>
</head>
<body>
<body>
<?php 
// 1. PASTIKAN KODE INI BERADA DI ATAS SEBELUM HTML
$halaman = "pesanan"; 
include "../../components/sidebar.php"; 

$today = date('Y-m-d');

// Fungsi diperbarui: Menambahkan tipe 'lunas' untuk total pesanan
function getCount($conn, $status, $type = 'status') {
    global $today;
    $sql = "SELECT COUNT(*) as total FROM pesanan WHERE DATE(tanggal) = '$today'";
    
    if ($type == 'status') {
        $sql .= " AND LOWER(TRIM(status_pesanan)) = '$status'";
    } elseif ($type == 'lunas') {
        // Hanya hitung yang sudah 'dibayar'
        $sql .= " AND LOWER(TRIM(status_pesanan)) = 'dibayar'";
    }
    
    $res = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($res);
    return $data['total'] ?? 0;
}

$count_batal   = getCount($conn, 'dibatalkan', 'status');
$count_proses  = getCount($conn, 'diproses', 'status');
$count_selesai = getCount($conn, 'selesai', 'status');
$count_total   = getCount($conn, '', 'lunas'); // Hanya menghitung 'dibayar'
?>

<div class="main-content">
    <div class="page-header">
        <h1>Manajemen Pesanan</h1>
    </div>

    <div class="summary-grid">
        <div class="summary-card">
            <span>Dibatalkan</span>
            <h3><?php echo $count_batal; ?></h3>
        </div>
        <div class="summary-card">
            <span>Diproses</span>
            <h3><?php echo $count_proses; ?></h3>
        </div>
        <div class="summary-card">
            <span>Selesai</span>
            <h3><?php echo $count_selesai; ?></h3>
        </div>
        <div class="summary-card">
            <span>Total Terbayar</span>
            <h3><?php echo $count_total; ?></h3>
        </div>
    </div>
    

    <form method="GET" class="filter-bar">

    <!-- LEFT SIDE -->
    <div class="filter-left">
        <input 
            type="text" 
            name="search" 
            placeholder="Cari nomor pesanan / nama pelanggan..."
            value="<?php echo $_GET['search'] ?? ''; ?>"
        >

        <button type="submit" class="btn-search">Cari</button>

        <a href="admin_pesanan.php" class="btn-reset">Reset</a>
    </div>

    <!-- RIGHT SIDE -->
    <div class="filter-right">
        <select name="status">
            <option value="">Semua Status</option>
            <option value="diproses" <?php if(($_GET['status'] ?? '')=='diproses') echo 'selected'; ?>>
                Diproses
            </option>
            <option value="selesai" <?php if(($_GET['status'] ?? '')=='selesai') echo 'selected'; ?>>
                Selesai
            </option>
        </select>
    </div>
    </form>

    <div class="table-wrapper">
        <table>       
            <thead>
            <tr>
                <th>Meja</th>
                <th>Pelanggan</th>
                <th>Detail Item</th>
                <th>Total Bayar</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

            <?php
            // Query menggunakan TRIM dan LOWER agar pencocokan kata 'dibatalkan' lebih akurat
            // Query yang mengecualikan status 'dibatalkan' DAN 'dibayar'
            $sql = "SELECT p.*, pl.nama_pelanggan 
                FROM pesanan p
                JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan 
                WHERE LOWER(TRIM(p.status_pesanan)) != 'dibatalkan' 
                AND LOWER(TRIM(p.status_pesanan)) != 'dibayar'";

                $search = $_GET['search'] ?? '';
                $status = $_GET['status'] ?? '';

                if (!empty($status)) {
                    $sql .= " AND LOWER(TRIM(p.status_pesanan)) = '" . mysqli_real_escape_string($conn, $status) . "'";
                }

                if (!empty($search)) {
                    $search = mysqli_real_escape_string($conn, $search);
                    $sql .= " AND (
                        p.nomor_pesanan LIKE '%$search%' 
                        OR pl.nama_pelanggan LIKE '%$search%'
                    )";
                }

                $sql .= " ORDER BY p.id_pesanan DESC";

                $query = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    $id_p = $row['id_pesanan'];
                    $status = strtolower(trim($row['status_pesanan'])); // Normalisasi status
            ?>

            <tr>
                <td>
                    <?php 
                        if (!empty($row['id_meja'])) {
                            echo "<span class='badge-meja'>Meja:".$row['id_meja']."</span>";
                        } else {
                            echo "-";
                        }
                    ?>
                </td>
                <td>
                    <div class="pelanggan-box">
                        <div class="pelanggan-icon">
                            <i data-feather="user"></i>
                        </div>
                        <div>
                            <span class="nomor-pesanan"><?php echo $row['nomor_pesanan']; ?></span>
                            <div class="nama-pelanggan"><?php echo htmlspecialchars($row['nama_pelanggan']); ?><br></div>
                            <small><?php echo $row['tanggal']; ?></small>
                        </div>
                    </div>
                </td>
                <td>
            <?php
            $q_detail = mysqli_query($conn, "SELECT dp.*, m.nama_menu
                                            FROM detail_pesanan dp
                                            JOIN menu m ON dp.id_menu = m.id_menu
                                            WHERE dp.id_pesanan = '$id_p'");

            while ($det = mysqli_fetch_assoc($q_detail)) {
            ?>
                <div class="item-menu">

                    <div class="nama-menu">
                        <?php echo $det['nama_menu']; ?>
                        <span class="qty">x<?php echo $det['jumlah']; ?></span>
                    </div>     

                    <?php if (!empty($det['pedas'])) { ?>
                        <div class="detail-menu">
                            <span class="menu-pedas">🌶<?php echo $det['pedas']; ?></span>
                        </div>
                    <?php } ?>

                    <?php if (!empty($det['catatan'])) { ?>
                        <div class="catatan-menu">
                            <i data-feather="clipboard"></i>
                            <span class="text-muted"><?php echo htmlspecialchars($det['catatan']); ?></span>
                        </div>
                    <?php } ?>

                </div>
            <?php } ?>
            </td>
                <td><span class="total-bayar"> Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></span>
                </td>
                <td><span class="status-badge <?php echo $status; ?>"><?php echo $status; ?></span></td>
                <td>
                    <?php if ($status == 'diproses'): ?>
                        <a class="btn-status btn-selesai" href="konfirmasi_proses.php?id=<?php echo $id_p; ?>&status=selesai"><i data-feather="check"></i>Set Selesai</a>
                    <?php elseif ($status == 'selesai'): ?>
                        <a class="btn-status btn-bayar" href="konfirmasi_proses.php?id=<?php echo $id_p; ?>&status=dibayar"><i data-feather="check-circle"></i>Konfirmasi Bayar</a>
                    <?php elseif ($status == 'dibayar'): ?>
                        <span style="color: green; font-weight: bold;">✅ Transaksi Lunas</span>
                    <?php else: ?>
                        <a class="btn-status btn-proses" href="konfirmasi_proses.php?id=<?php echo $id_p; ?>&status=diproses">Mulai Proses</a>
                    <?php endif; ?>

                    <?php if ($status != 'dibayar'): ?>
                        <a class="btn-status btn-batal" href="konfirmasi_proses.php?id=<?php echo $id_p; ?>&status=dibatalkan" 
                        onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan #<?php echo $id_p; ?>? Pesanan akan dihapus dari daftar aktif.')"> <i data-feather="x"></i>
                        Batalkan
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php 
                } 
            } else {
                echo "<tr><td colspan='5' style='text-align:center;'>Tidak ada pesanan aktif saat ini.</td></tr>";
            }
            ?>
        </tbody>
    
    </table>
    </div>
    <div class="table-footer">
    <div>Menampilkan 1 - 4 dari 4 pesanan</div>
    <div>Halaman 1</div>
    </div>
    </div>
</div>

<script>
feather.replace();
</script>
</body>
</html>