<?php
session_start();
include "koneksi.php";

$id_users = $_POST['id_users'];

$username = mysqli_real_escape_string(
    $conn,
    $_POST['username']
);

$email = mysqli_real_escape_string(
    $conn,
    $_POST['email']
);

$update = mysqli_query(
    $conn,
    "UPDATE users
     SET
        username='$username',
        email='$email'
     WHERE id_users='$id_users'"
);

if($update){

    $_SESSION['username'] = $username;

    echo "
    <script>
        alert('Profil berhasil diperbarui');
        window.location='profile.php';
    </script>
    ";

}else{

    echo "
    <script>
        alert('Gagal memperbarui profil');
        history.back();
    </script>
    ";

}
?>