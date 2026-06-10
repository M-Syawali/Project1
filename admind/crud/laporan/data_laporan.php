<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pesanan</title>
    <link rel="stylesheet" href="css/style_laporan_data.css">
</head>

<body>

<?php
include '../menu/koneksi.php';

$tgl_awal = mysqli_real_escape_string($conn, $_GET['tgl_awal']);
$tgl_akhir = mysqli_real_escape_string($conn, $_GET['tgl_akhir']);

$query = "SELECT 
            p.id_pesanan, 
            p.nomor_pesanan,
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
          AND p.status_pesanan = 'selesai'
          GROUP BY p.id_pesanan
          ORDER BY p.id_pesanan ASC";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>



<h2>Laporan Pesanan (<?= $tgl_awal ?> s/d <?= $tgl_akhir ?>)</h2>

<div class="table-card">
<table class="report-table">

<thead>
    <tr>
        <th>No Pesanan</th>
        <th>Pelanggan</th>
        <th>Tanggal</th>
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
$total_keseluruhan = 0;

while($row = mysqli_fetch_assoc($result)) :

    $menus = explode('||', $row['daftar_menu']);
    $jumlahs = explode('||', $row['daftar_jumlah']);
    $pedass = explode('||', $row['daftar_pedas']);
    $catatans = explode('||', $row['daftar_catatan']);
    $subtotals = explode('||', $row['daftar_subtotal']);

    $total_keseluruhan += array_sum($subtotals);
?>

<tr>
   <tr>
    <td class="text-center"><?= $row['nomor_pesanan'] ?></td>

    <td><?= $row['nama_pelanggan'] ?></td>

    <td class="text-center">
        <?= date('d-m-Y H:i', strtotime($row['tanggal'])) ?>
    </td>

    <td>
        <ul class="cell-list">
            <?php foreach ($menus as $m): ?>
                <li><?= $m ?></li>
            <?php endforeach; ?>
        </ul>
    </td>

    <td class="text-center">
        <ul class="cell-list">
            <?php foreach ($jumlahs as $j): ?>
                <li><?= $j ?></li>
            <?php endforeach; ?>
        </ul>
    </td>

    <td class="text-center">
        <ul class="cell-list">
            <?php foreach ($pedass as $p): ?>
                <li><?= $p ?></li>
            <?php endforeach; ?>
        </ul>
    </td>

    <td>
        <ul class="cell-list">
            <?php foreach ($catatans as $c): ?>
                <li><?= $c ?></li>
            <?php endforeach; ?>
        </ul>
    </td>

    <td class="text-center">
        Rp <?= number_format(array_sum($subtotals), 0, ',', '.') ?>
    </td>

    <td class="text-center">
        <?= ucfirst($row['status_pesanan']) ?>
    </td>
</tr>

<?php endwhile; ?>
</tbody>
<tfoot>
<tr>
    <td colspan="7" class="text-right">Total Keseluruhan</td>
    <td class="text-right">
        Rp <?= number_format($total_keseluruhan, 0, ',', '.'); ?>
    </td>
    <td></td>
</tr>
</tfoot>


</table>
</div>

<div class="action-buttons">
    <a class="btn-kembali" href="index.php">← Kembali</a>

    <a class="btn-cetak"
       href="cetak_laporan.php?tgl_awal=<?= $tgl_awal ?>&tgl_akhir=<?= $tgl_akhir ?>"
       target="_blank">
        Cetak Laporan
    </a>
</div>
</body>

</html>