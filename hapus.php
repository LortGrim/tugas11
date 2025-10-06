<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak! Hanya admin yang dapat mengubah atau menghapus data.'); 
    window.location='index.php';</script>";
    exit;
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM buku WHERE id_buku=$id");
header("Location: index.php");
exit;
