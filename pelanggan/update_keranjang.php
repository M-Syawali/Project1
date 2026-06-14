<?php
session_start();

/* =========================
   UPDATE VIA POST
========================= */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_menu'])) {

    $id = $_POST['id_menu'];

    if (isset($_SESSION['keranjang'][$id])) {

        // Update jumlah
        if (isset($_POST['jumlah'])) {
            $_SESSION['keranjang'][$id]['jumlah'] =
                max(1, (int)$_POST['jumlah']);
        }

        // Update level pedas
        if (isset($_POST['pedas'])) {
            $_SESSION['keranjang'][$id]['pedas'] = $_POST['pedas'];
        }

        // Update catatan
        if (isset($_POST['catatan'])) {
            $_SESSION['keranjang'][$id]['catatan'] = $_POST['catatan'];
        }
    }

    // Jika request AJAX
    if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
    ) {
        echo "success";
        exit;
    }

    // Jika submit biasa
    header("location:keranjang.php");
    exit;
}

/* =========================
   UPDATE VIA GET
========================= */
if (isset($_GET['id']) && isset($_GET['aksi'])) {

    $id = $_GET['id'];
    $aksi = $_GET['aksi'];

    if (isset($_SESSION['keranjang'][$id])) {

        if ($aksi == "tambah") {
            $_SESSION['keranjang'][$id]['jumlah'] += 1;
        }

        elseif ($aksi == "kurang") {

            if ($_SESSION['keranjang'][$id]['jumlah'] > 1) {
                $_SESSION['keranjang'][$id]['jumlah'] -= 1;
            }

        }

        elseif ($aksi == "hapus") {
            unset($_SESSION['keranjang'][$id]);
        }
    }

    header("location:keranjang.php");
    exit;
}

/* =========================
   AKSES LANGSUNG
========================= */
header("location:keranjang.php");
exit;
?>