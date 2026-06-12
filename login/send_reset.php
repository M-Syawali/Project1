<?php

include "koneksi.php";

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = mysqli_real_escape_string(
    $conn,
    $_POST['email']
);

$cek = mysqli_query(
    $conn,
    "SELECT * FROM users WHERE email='$email'"
);

if(mysqli_num_rows($cek) == 0){
    die("Email tidak ditemukan.");
}

$token = bin2hex(random_bytes(32));

$expired = date(
    "Y-m-d H:i:s",
    strtotime("+1 hour")
);

mysqli_query(
    $conn,
    "INSERT INTO password_resets
    (email, token, expired_at)
    VALUES
    ('$email','$token','$expired')"
);

$link =
"http://localhost/project/login/reset_password.php?token=".$token;

$mail = new PHPMailer(true);

try{

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    $mail->Username = 'aephidayatn31@gmail.com';
    $mail->Password = 'jwdzyamnivjqwyvc';

    $mail->SMTPSecure =
    PHPMailer::ENCRYPTION_STARTTLS;

    $mail->Port = 587;

    $mail->setFrom(
        'aephidayatn31@gmail.com',
        'Sagala Lada'
    );

    $mail->addAddress($email);

    $mail->isHTML(true);

    $mail->Subject = 'Reset Password';

    $mail->Body = "
        Klik link berikut untuk reset password:<br><br>

        <a href='$link'>$link</a>

        <br><br>

        Link berlaku selama 1 jam.
    ";

    $mail->send();

    echo "Link reset berhasil dikirim.";

}catch(Exception $e){

    echo "Email gagal dikirim : "
         .$mail->ErrorInfo;
}