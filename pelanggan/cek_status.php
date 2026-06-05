<?php
include "koneksi.php";

if (isset($_GET['id'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $query = mysqli_query(
        $conn,
        "SELECT status_pesanan
         FROM pesanan
         WHERE id_pesanan = '$id'"
    );

    $data = mysqli_fetch_assoc($query);

    if ($data) {
        echo strtolower(trim($data['status_pesanan']));
    }
}
?>