<?php
include '../menu/koneksi.php';
$tgl_awal = $_GET['tgl_awal'];
$tgl_akhir = $_GET['tgl_akhir'];

$query = "SELECT * FROM pesanan WHERE DATE(tanggal) BETWEEN '$tgl_awal' AND '$tgl_akhir'";
$result = mysqli_query($conn, $query);
?>

<html>
<head>
    <title>Cetak Laporan</title>
    <script>window.print();</script> </head>
<body>
    <h2>Laporan Penjualan</h2>
    <table border="1" width="100%">
        </table>
</body>
</html>