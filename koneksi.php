<?php
$host = "localhost"; // server database
$user = "xirpl2-17";      // username MySQL
$pass = "0087088926";          // password MySQL
$db   = "db_xirpl2-17_2"; // nama database

$conn = mysqli_connect($host, $user, $pass, $db);

// cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
