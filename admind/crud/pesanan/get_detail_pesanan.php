<?php
include "koneksi.php";

error_reporting(E_ALL);
ini_set('display_errors', 0);
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "ID pesanan tidak ditemukan"
    ]);
    exit;
}

$id = intval($_GET['id']);

/* =========================
   1. AMBIL DATA PESANAN
========================= */
$sql_pesanan = "
    SELECT 
        p.*,
        pl.nama_pelanggan,
        pl.no_hp
    FROM pesanan p
    JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
    WHERE p.id_pesanan = $id
    LIMIT 1
";

$query_pesanan = mysqli_query($conn, $sql_pesanan);

if (!$query_pesanan || mysqli_num_rows($query_pesanan) == 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Pesanan tidak ditemukan"
    ]);
    exit;
}

$pesanan = mysqli_fetch_assoc($query_pesanan);

/* =========================
   2. AMBIL DETAIL ITEM PESANAN
========================= */
$sql_item = "
    SELECT 
        dp.id_detail_pesanan,
        dp.jumlah,
        dp.subtotal,
        dp.catatan,
        dp.pedas,
        m.nama_menu
    FROM detail_pesanan dp
    JOIN menu m ON dp.id_menu = m.id_menu
    WHERE dp.id_pesanan = $id
";

$query_item = mysqli_query($conn, $sql_item);

$items = [];

while ($row = mysqli_fetch_assoc($query_item)) {
    $items[] = [
        "nama_menu" => $row['nama_menu'],
        "jumlah"    => $row['jumlah'],
        "subtotal"  => $row['subtotal'],
        "catatan"   => $row['catatan'],
        "pedas"     => $row['pedas']
    ];
}

/* =========================
   3. FORMAT RESPONSE JSON
========================= */
echo json_encode([
    "status" => "success",
    "data" => [
        "pesanan" => [
            "id"              => $pesanan['id_pesanan'],
            "nomor_pesanan"   => $pesanan['nomor_pesanan'],
            "nama_pelanggan"  => $pesanan['nama_pelanggan'],
            "no_hp"           => $pesanan['no_hp'], // tambah ini
            "tanggal"         => $pesanan['tanggal'],
            "tipe_pesanan"    => $pesanan['jenis_pesanan'],
            "metode"          => $pesanan['metode_pembayaran'],
            "total"           => $pesanan['total_harga'],
            "meja"            => $pesanan['id_meja'],
            "alamat"          => $pesanan['alamat'],
            "ongkir"          => $pesanan['ongkir'],
            "status"          => $pesanan['status_pesanan'],
            "bukti"           => $pesanan['bukti_pembayaran'],
            "uang_diterima"   => $pesanan['uang_diterima'],

            "latitude"        => $pesanan['latitude'] ?? null,
            "longitude"       => $pesanan['longitude'] ?? null
        ],

        "items" => $items
    ]
]);