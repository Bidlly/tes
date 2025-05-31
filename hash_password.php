<?php
$koneksi = new mysqli('localhost', 'root', '', 'marketplace'); // ganti nama database kamu

// Ambil semua user
$result = $koneksi->query("SELECT id, password FROM users");

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $plainPassword = $row['password'];

    // Hash password
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    // Update password di database
    $koneksi->query("UPDATE users SET password='$hashedPassword' WHERE id=$id");
}

echo "Semua password sudah di-hash!";
?>
