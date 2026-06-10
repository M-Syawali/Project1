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
    <link rel="stylesheet" href="../../main_page/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }
        body {
            font-family: 'Poppins', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f5f2;
            min-height: 100vh;
            margin: 0;
        }

        .main-content{
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
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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
            height:42px;
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

        .table-wrapper{
            background:white;
            padding:0;
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 8px 25px rgba(0,0,0,.08);
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        tbody tr{
            transition: background 0.5s ease;
        }

        tbody tr:hover{
            background:#f9fafb ;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-right: 1px solid #ddd;
        }
        td {
            padding:14px 16px;
            border-bottom:1px solid #e5e7eb;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: rgba(139,30,45,.92);
            backdrop-filter: blur(10px);
            color: #fff;
            padding: 22px;
            text-align: center;
            font-size: 14px;
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
            font-size: 15px;  
            color: #111;
            font-weight:500;
        }
        
        .total-bayar {
            font-size: 16px;
            font-weight: 600;
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

        .diproses { background: #b8daff; color: #004085; }
        .selesai { background: #d4edda; color: #155724; }
        .dibayar { background: #c3e6cb; color: #155724; border: 1px solid green; }
        .pending { background: #fff3cd; color: #856404; } 

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
            font-size:16px;
            font-weight:600;
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
        
        .menu-pedas{
            padding:4px 10px;
            background:#ffe5e5;
            color:#c62828;
            border-radius:20px;
            font-size:12px;
            font-weight:600;
        }

        .detail-menu,
        .catatan-menu {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 3px;
        }
        .detail-menu svg, .catatan-menu svg {
            width: 14px;
            height: 14px;
        }
        .detail-menu svg { color: #ea580c; }
        .catatan-menu svg { color: #6b7280; }
        
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
        .btn-status:hover { opacity: 0.8; }
        .btn-batal { background: #dc3545; }
        .btn-proses { background: #ffc107; color: black !important; }
        .btn-selesai { background: #28a745; }
        .btn-bayar { background: #007bff; }
        .btn-bukti { background: #6b7280; color: white !important; cursor: pointer; border: none; }
        
        .btn-maps { 
            background: #ea4335; 
            color: white !important; 
            text-decoration: none;
            margin-top: 5px;
        }

        .badge-meja{
            background:#ffe5e5;
            color:#8b1e2d;
            padding:6px 12px;
            border-radius:12px;
            font-weight:600;
            font-size:13px;
            display: inline-block;
        }
        
        .badge-delivery {
            background: #e0f2fe;
            color: #0369a1;
            padding: 6px 12px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 13px;
            display: inline-block;
        }

        .badge-metode {
            display: inline-block;
            padding: 5px 10px;
            background: #f3f4f6;
            color: #1f2937;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .badge-qris {
            background: #e0f2fe;
            color: #0369a1;
        }

        .alamat-delivery-box {
            font-size: 12px;
            color: #4b5563;
            max-width: 200px;
            word-wrap: break-word;
            margin-top: 4px;
            line-height: 1.4;
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

        .page-number.active{
            background:#8b1e2d;
            color:white;
            border-color:#8b1e2d;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
        }
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 450px;
            border-radius: 12px;
            animation: zoom 0.3s ease-in-out;
        }
        @keyframes zoom {
            from {transform:scale(0)}
            to {transform:scale(1)}
        }
        .close-modal {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php 
$halaman = "pesanan"; 
include "../../components/sidebar.php"; 

$today = date('Y-m-d');

function getCount($conn, $status, $type = 'status') {
    global $today;
    $sql = "SELECT COUNT(*) as total FROM pesanan WHERE DATE(tanggal) = '$today'";
    
    if ($type == 'status') {
        $sql .= " AND LOWER(TRIM(status_pesanan)) = '$status'";
    }
    
    $res = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($res);
    return $data['total'] ?? 0;
}

$count_pending   = getCount($conn, 'pending');
$count_dibayar   = getCount($conn, 'dibayar');
$count_proses    = getCount($conn, 'diproses');
$count_selesai   = getCount($conn, 'selesai');
$count_batal     = getCount($conn, 'dibatalkan');
?>

<div class="main-content">
    <div class="page-header">
        <h1>Manajemen Pesanan</h1>
        <p>Kelola seluruh pesanan pelanggan mulai dari konfirmasi pembayaran hingga pesanan selesai.</p>
    </div>

    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-icon"><i data-feather="clock"></i></div>
            <div>
                <span>Menunggu Bayar</span>
                <h3><?= $count_pending; ?></h3>
                <small>Hari ini</small>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon"><i data-feather="credit-card"></i></div>
            <div>
                <span>Sudah Dibayar</span>
                <h3><?= $count_dibayar; ?></h3>
                <small>Hari ini</small>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon"><i data-feather="coffee"></i></div>
            <div>
                <span>Diproses</span>
                <h3><?= $count_proses; ?></h3>
                <small>Hari ini</small>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon"><i data-feather="check-circle"></i></div>
            <div>
                <span>Selesai</span>
                <h3><?= $count_selesai; ?></h3>
                <small>Hari ini</small>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon"><i data-feather="x-circle"></i></div>
            <div>
                <span>Dibatalkan</span>
                <h3><?= $count_batal; ?></h3>
                <small>Hari ini</small>
            </div>
        </div>
    </div>

    <form method="GET" class="filter-bar">
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
        <div class="filter-right">
            <select name="status">
                <option value="">Semua Status</option>
                <option value="diproses" <?php if(($_GET['status'] ?? '')=='diproses') echo 'selected'; ?>>Diproses</option>
                <option value="selesai" <?php if(($_GET['status'] ?? '')=='selesai') echo 'selected'; ?>>Selesai</option>
            </select>
        </div>
    </form>

    <div class="table-wrapper">
        <table>       
            <thead>
                <tr>
                    <th>Tipe / Meja</th>
                    <th>Pelanggan</th>
                    <th>Detail Item</th>
                    <th>Metode</th> 
                    <th>Total Bayar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.*, pl.nama_pelanggan
                        FROM pesanan p
                        JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
                        WHERE LOWER(TRIM(p.status_pesanan)) IN ('pending', 'dibayar', 'diproses')";
                
                $search = $_GET['search'] ?? '';
                $status = $_GET['status'] ?? '';

                if (!empty($status)) {
                    $sql .= " AND LOWER(TRIM(p.status_pesanan)) = '" . mysqli_real_escape_string($conn, $status) . "'";
                }

                if (!empty($search)) {
                    $search = mysqli_real_escape_string($conn, $search);
                    $sql .= " AND (p.nomor_pesanan LIKE '%$search%' OR pl.nama_pelanggan LIKE '%$search%')";
                }

                $sql .= " ORDER BY p.id_pesanan DESC";
                $query = mysqli_query($conn, $sql);
            
                if (mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_assoc($query)) {
                        $id_p = $row['id_pesanan'];
                        $status = strtolower(trim($row['status_pesanan']));
                        $metode = strtoupper($row['metode_pembayaran'] ?? 'KASIR');
                        $jenis_pesanan = strtolower($row['jenis_pesanan'] ?? 'dinein');
                ?>
                <tr>
                    <td style="text-align: center;">
                        <?php 
                            if ($jenis_pesanan === 'delivery') {
                                echo "<span class='badge-delivery'><i data-feather='truck' style='width:12px; height:12px; vertical-align:middle;'></i> Delivery</span>";
                            } else {
                                if (!empty($row['id_meja'])) {
                                    echo "<span class='badge-meja'>Meja: ".$row['id_meja']."</span>";
                                } else {
                                    echo "<span class='badge-meja'>Take Away</span>";
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <div class="pelanggan-box">
                            <div class="pelanggan-icon"><i data-feather="user"></i></div>
                            <div>
                                <span class="nomor-pesanan"><?php echo $row['nomor_pesanan']; ?></span>
                                <div class="nama-pelanggan"><?php echo htmlspecialchars($row['nama_pelanggan']); ?></div>
                                <small><?php echo $row['tanggal']; ?></small>
                                
                                <?php if ($jenis_pesanan === 'delivery' && !empty($row['alamat'])): ?>
                                    <div class="alamat-delivery-box">
                                        <strong>Alamat:</strong> <?php echo htmlspecialchars($row['alamat']); ?>
                                    </div>
                                <?php endif; ?>
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
                                        <span class="menu-pedas">🌶 <?php echo $det['pedas']; ?></span>
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
                    <td>
                        <span class="badge-metode <?= ($metode === 'QRIS') ? 'badge-qris' : ''; ?>">
                            <?= $metode ?: 'KASIR'; ?>
                        </span>
                    </td>
                    <td>
                        <span class="total-bayar">Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></span>
                        <?php if ($jenis_pesanan === 'delivery' && $row['ongkir'] > 0): ?>
                            <br><small style="color: #0369a1;">(Termasuk Ongkir: Rp <?= number_format($row['ongkir'], 0, ',', '.') ?>)</small>
                        <?php endif; ?>
                    </td>
                    <td><span class="status-badge <?php echo $status; ?>"><?php echo $status; ?></span></td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 5px;">
                            
                            <?php if ($jenis_pesanan === 'delivery' && !empty($row['latitude']) && !empty($row['longitude'])): ?>
                                <a href="https://www.google.com/maps/search/?api=1&query=<?= $row['latitude'] ?>,<?= $row['longitude'] ?>" 
                                   target="_blank" class="btn-status btn-maps">
                                    <i data-feather="map-pin"></i> Rute Lokasi
                                </a>
                            <?php endif; ?>

                            <?php if ($status == 'pending'): ?>
                                <?php if ($metode === 'QRIS' && !empty($row['bukti_pembayaran'])): ?>
                                    <button type="button" class="btn-status btn-bukti" onclick="bukaBukti('../../../pelanggan/upload/bukti/<?= $row['bukti_pembayaran']; ?>')">
                                        <i data-feather="image"></i> Lihat Bukti
                                    </button>
                                <?php endif; ?>

                                <input type="text" id="input_uang_<?= $id_p ?>"
                                    placeholder="Masukkan Uang..."
                                    onkeyup="formatRupiah(this)"
                                    style="padding: 8px; border-radius: 8px; border: 1px solid #ccc; width: 140px;">
                                
                                <button type="button" class="btn-status btn-bayar" onclick="prosesBayar(<?= $id_p ?>, <?= $row['total_harga'] ?>)" style="border:none; cursor:pointer;">
                                    <i data-feather="check"></i> Konfirmasi Bayar
                                </button>

                                <a class="btn-status btn-batal" href="konfirmasi_proses.php?id=<?= $id_p ?>&status=dibatalkan" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                    <i data-feather="x-circle"></i> Batalkan
                                </a>

                            <?php elseif ($status == 'dibayar'): ?>
                                <div style="font-weight: 600; color: #155724; margin-bottom: 2px; font-size: 13px;">
                                    Kembalian: Rp <?= number_format(($row['uang_diterima'] ?? 0) - $row['total_harga'], 0, ',', '.') ?>
                                </div>
                                
                                <a class="btn-status btn-proses" href="konfirmasi_proses.php?id=<?= $id_p ?>&status=diproses">
                                    <i data-feather="coffee"></i> Mulai Proses
                                </a>
                                <a class="btn-status btn-batal" href="konfirmasi_proses.php?id=<?= $id_p ?>&status=dibatalkan" onclick="return confirm('Yakin ingin membatalkan?')">
                                    <i data-feather="x-circle"></i> Batalkan
                                </a>

                            <?php elseif ($status == 'diproses'): ?>
                                <a class="btn-status btn-selesai" href="konfirmasi_proses.php?id=<?= $id_p ?>&status=selesai">
                                    <i data-feather="check-circle"></i> Selesai
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center;'>Tidak ada pesanan aktif saat ini.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <div>Menampilkan seluruh data pesanan aktif</div>
        <div class="pagination">
            <a href="#" class="page-btn"><i data-feather="chevron-left"></i></a>
            <a href="#" class="page-number active">1</a>
            <a href="#" class="page-btn"><i data-feather="chevron-right"></i></a>
        </div>
    </div>
</div>

<div id="modalBukti" class="modal">
    <span class="close-modal" onclick="tutupBukti()">&times;</span>
    <img class="modal-content" id="imgBukti">
</div>

<script>
feather.replace();

function formatRupiah(elemen) {
    let angka = elemen.value.replace(/[^,\d]/g, '').toString();
    let split = angka.split(',');
    let sisa  = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    elemen.value = rupiah;
}

function prosesBayar(id, total) {
    let inputField = document.getElementById('input_uang_' + id);
    let uangMentah = inputField.value.replace(/\./g, ''); 

    if (uangMentah === "" || parseInt(uangMentah) < parseInt(total)) {
        alert("Jumlah uang tidak valid atau kurang dari total harga!");
        return;
    }

    window.location.href = 'konfirmasi_proses.php?id=' + id + '&status=dibayar&uang=' + uangMentah;
}

function bukaBukti(src) {
    document.getElementById("modalBukti").style.display = "block";
    document.getElementById("imgBukti").src = src;
}

function tutupBukti() {
    document.getElementById("modalBukti").style.display = "none";
}

window.onclick = function(event) {
    let modal = document.getElementById("modalBukti");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</body>
</html>