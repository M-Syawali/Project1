<head>
    <link rel="stylesheet" href="css/style_laporan_data.css">
</head>

<?php
include '../menu/koneksi.php';

$tgl_awal = $_GET['tgl_awal'];
$tgl_akhir = $_GET['tgl_akhir'];

// Query dengan JOIN agar data dari 4 tabel tergabung
$query = "SELECT 
            p.id_pesanan, 
            p.tanggal, 
            p.total_harga, 
            p.status_pesanan,
            pl.nama_pelanggan,
            GROUP_CONCAT(m.nama_menu SEPARATOR '||') as daftar_menu,
            GROUP_CONCAT(dp.jumlah SEPARATOR '||') as daftar_jumlah,
            GROUP_CONCAT(dp.pedas SEPARATOR '||') as daftar_pedas,
            GROUP_CONCAT(dp.catatan SEPARATOR '||') as daftar_catatan,
            GROUP_CONCAT(dp.subtotal SEPARATOR '||') as daftar_subtotal
          FROM pesanan p
          LEFT JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
          LEFT JOIN detail_pesanan dp ON p.id_pesanan = dp.id_pesanan
          LEFT JOIN menu m ON dp.id_menu = m.id_menu
          WHERE DATE(p.tanggal) BETWEEN '$tgl_awal' AND '$tgl_akhir'
          GROUP BY p.id_pesanan
          ORDER BY p.id_pesanan ASC";

$result = mysqli_query($conn, $query);
?>

<a class="btn-kembali" href="index.php">← Kembali</a>

<h2>Laporan Pesanan (<?php echo "$tgl_awal s/d $tgl_akhir"; ?>)</h2>

<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>ID</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Menu</th>
            <th>Jumlah</th>
            <th>Pedas</th>
            <th>Catatan</th>
            <th>Subtotal</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    $total_keseluruhan = 0; // Inisialisasi variabel total
    while($row = mysqli_fetch_assoc($result)) : 
        $menus = explode('||', $row['daftar_menu']);
        $jumlahs = explode('||', $row['daftar_jumlah']);
        $pedass = explode('||', $row['daftar_pedas']);
        $catatans = explode('||', $row['daftar_catatan']);
        $subtotals = explode('||', $row['daftar_subtotal']);
        $count = count($menus);

        // Tambahkan setiap subtotal ke variabel total_keseluruhan
        foreach ($subtotals as $sub) {
            $total_keseluruhan += (float)$sub;
        }
    ?>
        <tr>
            <td rowspan="<?= $count ?>" style="text-align: center; vertical-align: middle;"><?= $row['id_pesanan']; ?></td>
            <td rowspan="<?= $count ?>" style="text-align: center; vertical-align: middle;"><?= $row['tanggal']; ?></td>
            <td rowspan="<?= $count ?>" style="text-align: center; vertical-align: middle;"><?= $row['nama_pelanggan']; ?></td>
            
            <td style="text-align: center;"><?= $menus[0]; ?></td>
            <td style="text-align: center;"><?= $jumlahs[0]; ?></td>
            <td style="text-align: center;"><?= $pedass[0]; ?></td>
            <td style="text-align: center;"><?= $catatans[0]; ?></td>
            <td style="text-align: right;">Rp <?= number_format((float)$subtotals[0], 0, ',', '.'); ?></td>
            
            <td rowspan="<?= $count ?>" style="text-align: center; vertical-align: middle;"><?= $row['status_pesanan']; ?></td>
        </tr>
        
        <?php for($i = 1; $i < $count; $i++) : ?>
        <tr>
            <td style="text-align: center;"><?= $menus[$i]; ?></td>
            <td style="text-align: center;"><?= $jumlahs[$i]; ?></td>
            <td style="text-align: center;"><?= $pedass[$i]; ?></td>
            <td style="text-align: center;"><?= $catatans[$i]; ?></td>
            <td style="text-align: right;">Rp <?= number_format((float)$subtotals[$i], 0, ',', '.'); ?></td>
        </tr>
        <?php endfor; ?>
    <?php endwhile; ?>
    </tbody>
    
    <tfoot>
        <tr style="background-color: #f2f2f2; font-weight: bold;">
            <td colspan="7" style="text-align: right;">Total Keseluruhan</td>
            <td style="text-align: right;">Rp <?= number_format($total_keseluruhan, 0, ',', '.'); ?></td>
            <td></td>
        </tr>
    </tfoot>
</table>

<br>
<a href="cetak_laporan.php?tgl_awal=<?= $tgl_awal ?>&tgl_akhir=<?= $tgl_akhir ?>" target="_blank">Cetak Laporan</a>