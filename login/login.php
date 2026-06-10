<?php
session_start();
include "koneksi.php";

/*
|--------------------------------------------------------------------------
| REGISTER
|--------------------------------------------------------------------------
*/
if(isset($_POST['register'])){

    $username = mysqli_real_escape_string(
        $conn,
        $_POST['reg_username']
    );

    $password = $_POST['reg_password'];

    $confirm_password = $_POST['confirm_password'];

    if($password != $confirm_password){

        header("Location: index.php?register=password_salah");
        exit;
    }

    $cek = mysqli_query(
        $conn,
        "SELECT * FROM users
        WHERE username='$username'"
    );

    if(mysqli_num_rows($cek) > 0){

        header("Location: index.php?register=gagal");
        exit;
    }

    $password_hash = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    mysqli_query(
        $conn,
        "INSERT INTO users
        (username,password,role)
        VALUES
        (
            '$username',
            '$password_hash',
            'pelanggan'
        )"
    );

    header("Location: index.php?register=sukses");
    exit;
}

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/
if(isset($_POST['login'])){

    $username = mysqli_real_escape_string(
        $conn,
        $_POST['username']
    );

    $password = $_POST['password'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM users
        WHERE username='$username'"
    );

    if(mysqli_num_rows($query) > 0){

        $data = mysqli_fetch_assoc($query);

        if(password_verify(
            $password,
            $data['password']
        )){

            $_SESSION['id_users'] = $data['id_users'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['role'] = $data['role'];

            if($data['role'] == 'admin'){

                header(
                    "Location: ../admind/main_page/dashboard.php"
                );
                exit;
            }

            if($data['role'] == 'pelanggan'){

                $_SESSION['id_users'] = $data['id_users'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['role'] = $data['role'];
            
                $_SESSION['jenis_pesanan'] = 'delivery';
            
                header("Location: ../pelanggan/menu.php");
                exit;
            }
        }
    }

    header("Location: index.php?login=gagal");
    exit;
}

header("Location: index.php");
exit;
?>