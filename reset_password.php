<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'koneksi.php';

if (!isset($_GET['token'])) {
    die("Token tidak valid!");
}

$token = $_GET['token'];

// Cek apakah token ada di database
$result = $conn->query("SELECT * FROM users WHERE reset_token = '$token'");

if ($result->num_rows == 0) {
    die("Token tidak valid atau sudah digunakan!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password_baru = $_POST['password'];

    // Enkripsi password baru (pakai password_hash)
    $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

    // Update password dan hapus token
    $conn->query("UPDATE users SET password = '$password_hash', reset_token = NULL WHERE reset_token = '$token'");

    echo "<script>alert('Password berhasil direset! Silakan login kembali.'); window.location='login.php';</script>";
}
?>

<!-- Tampilan Form Reset Password -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - Marketplace</title>
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
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        button {
            width: 100%;
            background:rgb(82, 119, 255);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background:rgb(26, 99, 255);
        }
        .link {
            margin-top: 15px;
            text-align: center;
        }
        .link a {
            color:rgb(0, 0, 0);
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Reset Password</h2>
    <form method="POST">
        <input type="password" name="password" placeholder="Masukkan Password Baru" required>
        <button type="submit">Reset Password</button>
    </form>
    <div class="link">
        <a href="login.php">Kembali ke Login</a>
    </div>
</div>

</body>
</html>
