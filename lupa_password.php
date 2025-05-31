<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Cari user berdasarkan email
    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Buat token random
        $token = bin2hex(random_bytes(16)); // 32 karakter hex

        // Simpan token ke database
        $conn->query("UPDATE users SET reset_token='$token' WHERE email='$email'");

        // Kirim email reset password
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;
            $mail->Username = 'abifuhuy549@gmail.com'; 
            $mail->Password = 'blmi duux vhun fcku'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('emailkamu@gmail.com', 'Marketplace Abid');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Reset Password Marketplace';
            $mail->Body = "
                Halo,<br><br>
                Klik link berikut untuk reset password kamu: <br><br>
                <a href='http://localhost/marketplace/reset_password.php?token=$token'>Reset Password</a>
                <br><br>Terima kasih.";

            $mail->send();
            echo "<script>alert('Link reset password telah dikirim ke email Anda!'); window.location='login.php';</script>";
        } catch (Exception $e) {
            echo "Email gagal dikirim. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>alert('Email tidak ditemukan!'); window.location='lupa_password.php';</script>";
    }
}
?>

<!-- Tampilan Form Lupa Password -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password - Marketplace</title>
    <style>
        body {
            background: #f0f2f5;
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .form-container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        input[type="email"] {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        button {
            width: 100%;
            background: #70b9dc;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #45a049;
        }
        .link {
            margin-top: 15px;
            text-align: center;
        }
        .link a {
            color: #70b9dc;
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Lupa Password</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Masukkan Email Anda" required>
        <button type="submit">Kirim Link Reset</button>
    </form>
    <div class="link">
        <a href="login.php">Kembali ke Login</a>
    </div>
</div>

</body>
</html>
