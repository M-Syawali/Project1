<?php
include 'koneksi.php'; // Diubah karena berada dalam satu folder
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan Masuk</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>

<h2>Daftar Pesanan Masuk (SagalaLada)</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Waktu</th>
            <th>Detail Pesanan (Menu, Pedas, Catatan)</th>
            <th>Total Harga</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Baris 35: Menjalankan query ke tabel 'pesanan'
        $ambil = mysqli_query($conn, "SELECT * FROM pesanan");
        
        while($pecah = mysqli_fetch_assoc($ambil)) {
        ?>
        <tr>
            <td><?php echo $pecah['id_pesanan']; ?></td>
            <td><?php echo $pecah['tanggal']; ?></td>
            <td>
                Pesanan dari meja: <?php echo $pecah['id_meja']; ?>
            </td>
            <td>Rp <?php echo number_format($pecah['total_harga']); ?></td>
            <td><?php echo $pecah['status_pesanan']; ?></td>
            <td>
                <a href="konfirmasi_proses.php?id=<?php echo $pecah['id_pesanan']; ?>">Proses</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>