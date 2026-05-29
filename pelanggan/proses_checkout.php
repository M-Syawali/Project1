```php
<?php
session_start();
if(empty($_SESSION['keranjang'])){
    header("Location: keranjang.php");
    exit;
}
include "koneksi.php";
if(!isset($_POST['nama']) || !isset($_POST['meja'])){
    die("Data checkout tidak lengkap");
}
date_default_timezone_set('Asia/Jakarta');

$nomor_pesanan = $_POST['nomor_pesanan'];
$id_meja = $_POST['meja'];
$nama = $_POST['nama'];

$total_harga = 0;

// HITUNG TOTAL
foreach($_SESSION['keranjang'] as $id_menu => $jumlah){

    $query = mysqli_query($conn,
    "SELECT * FROM menu WHERE id_menu='$id_menu'");

    $data = mysqli_fetch_assoc($query);

    $subtotal = $data['harga'] * $jumlah;

    $total_harga += $subtotal;
}

/* =========================
   CEK PELANGGAN
========================= */

$cek_pelanggan = mysqli_query($conn,
"SELECT * FROM pelanggan WHERE nama_pelanggan='$nama'");

if(mysqli_num_rows($cek_pelanggan) > 0){

    $data_pelanggan = mysqli_fetch_assoc($cek_pelanggan);

    $id_pelanggan = $data_pelanggan['id_pelanggan'];

}else{

    mysqli_query($conn,
    "INSERT INTO pelanggan(nama_pelanggan)
    VALUES('$nama')");

    $id_pelanggan = mysqli_insert_id($conn);
}

/* =========================
   SIMPAN PESANAN
========================= */

$query_insert = mysqli_query($conn, "
    INSERT INTO pesanan
    (
        tanggal,
        id_meja,
        total_harga,
        status_pesanan,
        id_pelanggan,
        nomor_pesanan
    )
    VALUES
    (
        NOW(),
        '$id_meja',
        '$total_harga',
        'Pending',
        '$id_pelanggan',
        '$nomor_pesanan'
    )
");

/* =========================
   CEK ERROR
========================= */

if(!$query_insert){
    die(mysqli_error($conn));
}

/* =========================
   AMBIL ID PESANAN
========================= */

$id_pesanan = mysqli_insert_id($conn);

/* =========================
   SIMPAN DETAIL PESANAN
========================= */

foreach($_SESSION['keranjang'] as $id_menu => $jumlah){

    $query = mysqli_query($conn,
    "SELECT * FROM menu WHERE id_menu='$id_menu'");

    $data = mysqli_fetch_assoc($query);

    $subtotal = $data['harga'] * $jumlah;

    mysqli_query($conn, "
        INSERT INTO detail_pesanan
        (
            id_pesanan,
            id_menu,
            jumlah,
            subtotal
        )
        VALUES
        (
            '$id_pesanan',
            '$id_menu',
            '$jumlah',
            '$subtotal'
        )
    ");
}

/* =========================
   HAPUS KERANJANG
========================= */

unset($_SESSION['keranjang']);

echo "
<script>
alert('Pesanan berhasil dibuat!');
window.location='status_pesanan.php?id=$id_pesanan';
</script>
";
?>
```
