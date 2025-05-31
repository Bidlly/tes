<?php
session_start();

// Koneksi ke database
$koneksi = new mysqli('localhost', 'root', '', 'marketplace'); // ganti nama database kalau perlu

// Cek kalau form disubmit
if (isset($_POST['register'])) {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);

    // Cek password sama tidak
    if ($password !== $confirm_password) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Cek apakah username atau email sudah ada
        $cek = $koneksi->query("SELECT * FROM users WHERE username = '$username' OR email = '$email'");
        if ($cek->num_rows > 0) {
            $error = "Username atau Email sudah terdaftar!";
        } else {
            // Hash password
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insert user baru
            $koneksi->query("INSERT INTO users (username, email, password, created_at) VALUES ('$username', '$email', '$passwordHash', NOW())");

            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Marketplace Abid</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6 text-blue-400">Buat Akun Baru</h2>

    <?php if (isset($error)): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-4">
            <label class="block mb-2 font-semibold">Username</label>
            <input type="text" name="username" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Email</label>
            <input type="email" name="email" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Password</label>
            <input type="password" name="password" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-6">
            <label class="block mb-2 font-semibold">Konfirmasi Password</label>
            <input type="password" name="confirm_password" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <button type="submit" name="register" class="w-full bg-blue-400 hover:bg-blue-500 text-white p-3 rounded-full font-semibold transition">
            Daftar
        </button>

        <div class="text-center mt-6 text-gray-600">
            Sudah punya akun? <a href="login.php" class="text-blue-400 hover:underline">Login</a>
        </div>
    </form>
</div>

</body>
</html>
