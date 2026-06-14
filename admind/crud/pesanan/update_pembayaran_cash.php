<?php
include "koneksi.php";

header('Content-Type: application/json');

$id = $_POST['id'];
$uang = $_POST['uang'];
$status = $_POST['status'];

if (!$id || !$uang || !$status) {

    echo json_encode([
        "status" => "error",
        "message" => "Data tidak lengkap"
    ]);

    exit;
}

$sql = "UPDATE pesanan 
        SET status_pesanan='$status',
            uang_diterima='$uang'
        WHERE id_pesanan='$id'";

if (mysqli_query($conn, $sql)) {
    echo json_encode([
        "status" => "success"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Gagal update pembayaran"
    ]);
}