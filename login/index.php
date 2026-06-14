<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login</title>

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="../bahan/css/style.css?v=999">

</head>
<body>
<div class="blur1"></div>
<div class="blur2"></div>
<div class="container">
     <a href="../index.php" class="btn-home">
        ←  Beranda
    </a>

    <!-- LOGIN -->
    <div class="form-box login">
        <form method="POST" action="login.php">

            <h1>Login</h1>

            <?php if(isset($_GET['login']) && $_GET['login']=='gagal'){ ?>
                <p style="color:red;">Username atau Password salah!</p>
            <?php } ?>

            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bxs-user left-icon'></i>
                <i class='bx bxs-user' style="color:black;font-size:30px;"></i>
            </div>

            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Password" required>

                <i class='bx bxs-lock-alt left-icon'></i>

                <span class="toggle-password" onclick="togglePassword()">
                    <i class='bx bx-show' id="eyeIcon"></i>
                    <i class='bx bxs-show' style="color:black;font-size:30px;"></i>
                </span>
            </div>

            <div class="forgot-link">
                <a href="forgot_password.php">Lupa Password?</a>
            </div>

            <button type="submit" name="login" class="btn">
                Login
            </button>

        </form>
    </div>

    <!-- REGISTER -->
    <div class="form-box register">

        <form method="POST" action="login.php">

            <h1>Register</h1>

            <?php if(isset($_GET['register']) && $_GET['register']=='sukses'){ ?>
                <p style="color:green;">Registrasi berhasil, silakan login.</p>
            <?php } ?>

            <?php if(isset($_GET['register']) && $_GET['register']=='gagal'){ ?>
                <p style="color:red;">Username sudah digunakan!</p>
            <?php } ?>

            <?php if(isset($_GET['register']) && $_GET['register']=='password_salah'){ ?>
                <p style="color:red;">Konfirmasi password tidak sesuai!</p>
            <?php } ?>

            <div class="input-box">
                <input type="text" name="reg_username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>

            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class='bx bxs-envelope'></i>
            </div>

            <div class="input-box">
                <input type="password" name="reg_password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="input-box">
                <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <button type="submit" name="register" class="btn">
                Register
            </button>

        </form>

    </div>

    <div class="toggle-box">

        <div class="toggle-panel toggle-left">
            <h1>Hello!</h1>
            <p>Kamu belum punya akun?</p>
            <button class="btn register-btn">
                Register
            </button>
        </div>
        <div class="toggle-panel toggle-right">
            <h1>Welcome Back!</h1>
            <p>Kamu sudah punya akun?</p>
            <button class="btn login-btn">
                Login
            </button>
        </div>

    </div>

</div>

<script src="script.js"></script>
<script>
function togglePassword() {
    const password = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");

    if(password.type === "password"){
        password.type = "text";
        eyeIcon.classList.replace("bx-show","bx-hide");
    } else {
        password.type = "password";
        eyeIcon.classList.replace("bx-hide","bx-show");
    }
}
</script>
</body>
</html>