<?php
session_start();
require 'koneksi.php';

// Kalau sudah login, langsung ke index
if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Pakai password_verify buat cek password hash
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Marketplace Abid</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-blue-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold text-center mb-6 text-blue-400">Login</h2>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <input type="text" name="username" placeholder="Username" required
                class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />

            <input type="password" name="password" placeholder="Password" required
                class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />

            <button type="submit"
                class="w-full bg-blue-500 text-white py-3 rounded hover:bg-blue-400 transition">Login</button>
        </form>

        <!-- Tambahan: Link daftar dan kembali ke home -->
        <div class="text-center text-sm text-gray-500 mt-6">
        Belum punya akun? <a href="register.php" class="text-blue-400 hover:underline">Daftar</a> |
        <a href="lupa_password.php" class="text-blue-400 hover:underline">Lupa Password?</a>
            <p class="mt-2"><a href="index.php" class="text-red-400 hover:underline">Kembali ke Beranda</a></p>
        </div>
    </div>
</body>
</html>
