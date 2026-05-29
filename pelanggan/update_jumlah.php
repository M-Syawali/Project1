<?php

session_start();

if(isset($_POST['id_menu']) && isset($_POST['jumlah'])){

    $id_menu = $_POST['id_menu'];
    $jumlah = (int) $_POST['jumlah'];

    if($jumlah < 1){
        $jumlah = 1;
    }

    $_SESSION['keranjang'][$id_menu] = $jumlah;
}

header("Location: keranjang.php");
exit;
?>