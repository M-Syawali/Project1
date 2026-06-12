<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lupa Password</title>
</head>
<body>

<h2>Reset Password</h2>

<form action="send_reset.php" method="POST">

    <input
        type="email"
        name="email"
        placeholder="Masukkan Email"
        required>

    <button type="submit">
        Kirim Link Reset
    </button>

</form>

</body>
</html>