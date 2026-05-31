<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - Pesanan Aktif</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; padding: 20px; }
        h2 { color: #333; }
        table { border-collapse: collapse; width: 100%; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #333; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        
        .status-badge { 
            padding: 5px 10px; border-radius: 4px; font-size: 11px; 
            font-weight: bold; text-transform: uppercase; display: inline-block;
        }
        /* Warna Status */
        .diproses { background: #b8daff; color: #004085; }
        .selesai { background: #d4edda; color: #155724; }
        .dibayar { background: #c3e6cb; color: #155724; border: 1px solid green; }
        .pending { background: #fff3cd; color: #856404; }
        
        .catatan-text { color: #d9534f; font-style: italic; font-size: 0.9em; }
        .btn-status { 
            padding: 6px 12px; text-decoration: none; border-radius: 4px; 
            font-size: 12px; display: inline-block; margin: 2px; color: white;
            transition: 0.2s;
        }
        .btn-status:hover { opacity: 0.8; }
        .btn-batal { background: #dc3545; }
        .btn-proses { background: #ffc107; color: black !important; }
        .btn-selesai { background: #28a745; }
        .btn-bayar { background: #007bff; }

        .btn-dashboard{
        display:inline-block;
        padding:10px 18px;
        background:#dc3545;
        color:white;
        text-decoration:none;
        border-radius:5px;
        font-weight:bold;
        margin-bottom:15px;
        transition:0.3s;
        }

        .btn-dashboard:hover{
        background:#b02a37;
        }
    </style>
</head>
<body>

<h2>Manajemen Pesanan (Aktif)</h2>
<p style="color: #666;"><small><i>*Pesanan dengan status "dibatalkan" tidak akan muncul di tabel ini.</i></small></p>
<a href="../../main_page/dashboard.html" class="btn-dashboard">← Kembali ke Dashboard</a>
<table>
    <thead>
        <tr>
            <th>ID & Pelanggan</th>
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
                <strong>#<?php echo $id_p; ?></strong><br>
                <?php echo htmlspecialchars($row['nama_pelanggan']); ?><br>
                <small><?php echo $row['tanggal']; ?></small>
            </td>
            <td>
                <ul style="margin:0; padding-left:15px;">
                <?php
                $q_detail = mysqli_query($conn, "SELECT dp.*, m.nama_menu 
                                                 FROM detail_pesanan dp 
                                                 JOIN menu m ON dp.id_menu = m.id_menu 
                                                 WHERE dp.id_pesanan = '$id_p'");
                while ($det = mysqli_fetch_assoc($q_detail)) {
                ?>
                    <li>
                        <strong><?php echo $det['nama_menu']; ?></strong> (x<?php echo $det['jumlah']; ?>)
                        <?php if (!empty($det['pedas'])) { echo "<br><small>🌶 Level: ".$det['pedas']."</small>"; } ?>
                        <?php if (!empty($det['catatan'])) { echo "<br><span class='catatan-text'>📝 ".htmlspecialchars($det['catatan'])."</span>"; } ?>
                    </li>
                <?php } ?>
                </ul>
            </td>
            <td><strong>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></strong></td>
            <td><span class="status-badge <?php echo $status; ?>"><?php echo $status; ?></span></td>
            <td>
                <?php if ($status == 'diproses'): ?>
                    <a class="btn-status btn-selesai" href="konfirmasi_proses.php?id=<?php echo $id_p; ?>&status=selesai">Set Selesai</a>
                <?php elseif ($status == 'selesai'): ?>
                    <a class="btn-status btn-bayar" href="konfirmasi_proses.php?id=<?php echo $id_p; ?>&status=dibayar">Konfirmasi Bayar</a>
                <?php elseif ($status == 'dibayar'): ?>
                    <span style="color: green; font-weight: bold;">✅ Transaksi Lunas</span>
                <?php else: ?>
                    <a class="btn-status btn-proses" href="konfirmasi_proses.php?id=<?php echo $id_p; ?>&status=diproses">Mulai Proses</a>
                <?php endif; ?>

                <?php if ($status != 'dibayar'): ?>
                    <a class="btn-status btn-batal" href="konfirmasi_proses.php?id=<?php echo $id_p; ?>&status=dibatalkan" 
                       onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan #<?php echo $id_p; ?>? Pesanan akan dihapus dari daftar aktif.')">
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

</body>
</html>