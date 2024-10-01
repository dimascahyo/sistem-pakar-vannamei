<!-- koneksi.php -->
<?php

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cf-test";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

?>
