<?php

session_start();
include "koneksi.php";

if(!isset($_SESSION['id_users'])){
    header("Location: ../../login/index.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header("Location: ubah_password.php");
    exit;
}

$id_users = $_SESSION['id_users'];

$password_lama = trim($_POST['password_lama']);
$password_baru = trim($_POST['password_baru']);
$konfirmasi    = trim($_POST['konfirmasi_password']);

$query = mysqli_query(
    $conn,
    "SELECT * FROM users
     WHERE id_users='$id_users'"
);

$user = mysqli_fetch_assoc($query);

if(!$user){
    die("User tidak ditemukan");
}

/* Password lama salah */
if(!password_verify($password_lama, $user['password'])){

    echo "
    <script>
        alert('Password lama salah!');
        window.location='ubah_password.php';
    </script>
    ";
    exit;
}

/* Password baru minimal 8 karakter */
if(strlen($password_baru) < 8){

    echo "
    <script>
        alert('Password minimal 8 karakter!');
        window.location='ubah_password.php';
    </script>
    ";
    exit;
}

/* Konfirmasi tidak cocok */
if($password_baru != $konfirmasi){

    echo "
    <script>
        alert('Konfirmasi password tidak cocok!');
        window.location='ubah_password.php';
    </script>
    ";
    exit;
}

/* Password baru sama dengan lama */
if(password_verify($password_baru, $user['password'])){

    echo "
    <script>
        alert('Password baru tidak boleh sama dengan password lama!');
        window.location='ubah_password.php';
    </script>
    ";
    exit;
}

$password_hash = password_hash(
    $password_baru,
    PASSWORD_DEFAULT
);

$update = mysqli_query(
    $conn,
    "UPDATE users
     SET password='$password_hash'
     WHERE id_users='$id_users'"
);

if($update){

    echo "
    <script>
        alert('Password berhasil diubah!');
        window.location='profile.php';
    </script>
    ";

}else{

    echo "
    <script>
        alert('Gagal mengubah password!');
        window.location='ubah_password.php';
    </script>
    ";
}
?>