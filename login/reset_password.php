<?php

include "koneksi.php";

$token = $_GET['token'];

$cek = mysqli_query(
    $conn,
    "SELECT * FROM password_resets
    WHERE token='$token'
    AND expired_at > NOW()"
);

if(mysqli_num_rows($cek) == 0){
    die("Link tidak valid atau kadaluarsa.");
}
?>

<form action="update_password.php" method="POST">

    <input
        type="hidden"
        name="token"
        value="<?= $token ?>">

    <input
        type="password"
        name="password"
        placeholder="Password Baru"
        required>

    <button type="submit">
        Simpan Password
    </button>

</form>