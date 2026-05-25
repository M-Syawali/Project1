<?php
session_start();
include "koneksi.php";

/*
|--------------------------------------------------------------------------
| PROSES LOGIN
|--------------------------------------------------------------------------
*/

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM admin 
        WHERE username='$username' 
        AND password='$password'"
    );

    $cek = mysqli_num_rows($query);

    if ($cek > 0) {

        $_SESSION['username'] = $username;

        header("Location: ../admind/main_page/dashboard.html");
        exit;

    } else {

        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="../bahan/css/style.css?v=2">

</head>
<body>

    <div class="container">

        <div class="form-box login">

            <!-- FORM LOGIN -->
            <form method="POST">

                <h1>Login</h1>

                <?php
                if (isset($error)) {
                    echo "<p style='color:red; margin-bottom:15px;'>$error</p>";
                }
                ?>

                <!-- USERNAME -->
                <div class="input-box">

                    <input 
                        type="text" 
                        name="username"
                        placeholder="Username" 
                        required
                    >

                    <i class='bx bxs-user'></i>

                </div>

                <!-- PASSWORD -->
                <div class="input-box">

                    <input 
                        type="password" 
                        name="password"
                        placeholder="Password" 
                        required
                    >

                    <i class='bx bxs-lock-alt'></i>

                </div>

                <!-- BUTTON LOGIN -->
                <button type="submit" name="login" class="btn">
                    Login
                </button>

            </form>

        </div>

        <!-- PANEL SAMPING -->
        <div class="toggle-box">

            <div class="toggle-panel toggle-left">

                <h1>Hello!</h1>

                <p>
                    Selamat datang di halaman login
                </p>

            </div>

        </div>

    </div>

    <script src="script.js"></script>

</body>
</html>