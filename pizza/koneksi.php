<?php
$host = "localhost";
$user = "root"; // ganti jika pakai user lain
$pass = "";     // sesuaikan dengan password MySQL Anda
$db   = "db_pizza";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
