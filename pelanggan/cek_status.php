<?php
include "koneksi.php";
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT status_pesanan FROM pesanan WHERE id_pesanan='$id'");
$data = mysqli_fetch_assoc($query);
echo $data['status_pesanan']; 
?>