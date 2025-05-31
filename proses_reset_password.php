<?php
require 'koneksi.php';

if (isset($_POST['email']) && isset($_POST['password_baru'])) {
    $email = $_POST['email'];
    $passwordBaru = password_hash($_POST['password_baru'], PASSWORD_DEFAULT);

    mysqli_query($koneksi, "UPDATE users SET password='$passwordBaru', reset_token=NULL WHERE email='$email'");

    echo "Password berhasil direset! <a href='login.php'>Login Sekarang</a>";
}
?>
