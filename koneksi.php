<?php
$conn = new mysqli('localhost', 'root', '', 'marketplace');

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>