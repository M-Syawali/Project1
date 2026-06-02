<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - Pesanan Aktif</title>
    <script src="https://unpkg.com/feather-icons"></script>
      
      
    <style>
       
        body {
            font-family: 'Poppins', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg,#5c0f16,#8b1e2d,#b33646);
            min-height: 100vh;
            padding: 40px;
        }

        h2 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #fff;
            text-shadow: 0 4px 10px rgba(0,0,0,.25);
        }

        p {
            color: rgba(255,255,255,.9);
            margin-bottom: 25px;
            font-style: italic;
        }


        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        td {
            padding:14px 16px;
            border-bottom:1px solid #eee;
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
        tr:nth-child(even) {
            background-color: #f9f9f9;
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
        .item-menu {
            padding: 6px 0;
            border-bottom: 1px dashed rgba(0,0,0,0.25);
            margin-bottom: 6px;
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
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 2px;
            color: white;
            font-weight: 600;
            transition: 0.2s;
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

        .btn-dashboard {
            display: inline-block;
            padding: 14px 24px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.2);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            margin-bottom: 30px;
            transition: .3s;
            backdrop-filter: blur(10px);
        }
        .btn-dashboard:hover { background:rgba(255,255,255,.2);  }

        ul{
        list-style:none;
        padding:0;
        margin:0;
        }
    </style>
</head>
<body>

<h2>Manajemen Pesanan (Aktif)</h2>
<p class="info-text">
    *Pesanan dengan status "dibatalkan" tidak akan muncul di tabel ini.
</p>
<a href="../../main_page/dashboard.php" class="btn-dashboard">← Kembali ke Dashboard</a>
<table>
    <thead>
        <tr>
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
                AND LOWER(TRIM(p.status_pesanan)) != 'dibayar' 
                ORDER BY p.id_pesanan DESC";
        
        $query = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $id_p = $row['id_pesanan'];
                $status = strtolower(trim($row['status_pesanan'])); // Normalisasi status
        ?>
        <tr>
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
<script>
feather.replace();
</script>
</body>
</html>