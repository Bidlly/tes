<?php
$host = "localhost";
$user = "root"; // default XAMPP user
$pass = ""; // password kosong di XAMPP
$db   = "marketplace"; // nanti kita buat database ini di phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
