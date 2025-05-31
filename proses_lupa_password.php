<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'koneksi.php'; // koneksi ke database

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // cek email ada di database atau tidak
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($query);

    if ($user) {
        $token = md5(rand()); // buat token random

        // simpan token ke database
        mysqli_query($koneksi, "UPDATE users SET reset_token='$token' WHERE email='$email'");

        // kirim email reset
        $mail = new PHPMailer(true);
        try {
            // Konfigurasi SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // sesuaikan SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'emailmu@gmail.com'; // EMAIL KAMU
            $mail->Password = 'passwordaplikasimu'; // PASSWORD APLIKASI, bukan password gmail biasa
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Set pengirim & penerima
            $mail->setFrom('emailmu@gmail.com', 'Marketplace Abid');
            $mail->addAddress($email);

            // Konten email
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password Anda';
            $mail->Body = "Klik link ini untuk reset password: <a href='http://localhost/marketplace/reset_password.php?email=$email&token=$token'>Reset Password</a>";

            $mail->send();
            echo "Link reset password sudah dikirim ke email Anda!";
        } catch (Exception $e) {
            echo "Gagal mengirim email. Error: {$mail->ErrorInfo}";
        }

    } else {
        echo "Email tidak ditemukan!";
    }
}
?>
