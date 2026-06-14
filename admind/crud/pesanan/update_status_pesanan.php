<?php
include "koneksi.php";

header('Content-Type: application/json');

$id = $_POST['id'];
$status = $_POST['status'];
$allowedStatus = [
    'pending',
    'dibayar',
    'diproses',
    'selesai',
    'dibatalkan'
];

if (!in_array($status, $allowedStatus)) {
    echo json_encode([
        "status" => "error",
        "message" => "Status tidak valid"
    ]);
    exit;
}

if (!$id || !$status) {
    echo json_encode([
        "status" => "error",
        "message" => "Data tidak lengkap"
    ]);
    exit;
}

$stmt = mysqli_prepare(
    $conn,
    "UPDATE pesanan
     SET status_pesanan = ?
     WHERE id_pesanan = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "si",
    $status,
    $id
);
if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        "status" => "success",
        "message" => "Status berhasil diupdate"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Gagal update status"
    ]);
}
?>