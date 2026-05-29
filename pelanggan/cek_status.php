<?php

include "koneksi.php";

$id_pesanan = $_GET['id'];

$query = mysqli_query($conn,
"SELECT status_pesanan FROM pesanan 
WHERE id_pesanan='$id_pesanan'");

$data = mysqli_fetch_assoc($query);

echo $data['status_pesanan'];

?>