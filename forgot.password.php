<?php
session_start();

// Koneksi ke database
$koneksi = new mysqli('localhost', 'root', '', 'marketplace');

if (isset($_POST['submit'])) {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);

    // Cek apakah username dan email cocok
    $result = $koneksi->query("SELECT * FROM users WHERE username='$username' AND email='$email'");
    if ($result->num_rows > 0) {
        // Simpan username di session untuk reset nanti
        $_SESSION['reset_username'] = $username;
        header('Location: reset_password.php');
        exit;
    } else {
        $error = "Username dan Email tidak cocok!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password - Marketplace Abid</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6 text-blue-400">Lupa Password</h2>

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

        <div class="mb-6">
            <label class="block mb-2 font-semibold">Email</label>
            <input type="email" name="email" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <button type="submit" name="submit" class="w-full bg-blue-400 hover:bg-blue-500 text-white p-3 rounded-full font-semibold transition">
            Verifikasi
        </button>

        <div class="text-center mt-6 text-gray-600">
            <a href="login.php" class="text-blue-400 hover:underline">Kembali ke Login</a>
        </div>
    </form>
</div>

</body>
</html>
