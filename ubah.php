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
$data = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku = $id");
$buku = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $judul    = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis  = mysqli_real_escape_string($conn, $_POST['penulis']);
    $stok     = (int)$_POST['stok'];
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);

    $query = "UPDATE buku SET 
                judul='$judul', 
                penulis='$penulis', 
                stok='$stok', 
                kategori='$kategori', 
                penerbit='$penerbit'
              WHERE id_buku=$id";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Ubah Buku</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.css" rel="stylesheet" type="text/css" />
</head>
<body class="bg-blue-50">

<div class="flex items-center justify-center min-h-screen">
  <div class="card w-full max-w-md bg-white shadow-xl border border-blue-200 p-6">
    <h2 class="text-3xl font-bold text-blue-700 mb-6 text-center">✏️ Ubah Buku</h2>

    <form method="post" class="space-y-4">
      <input type="text" 
             name="judul" 
             value="<?= htmlspecialchars($buku['judul']); ?>" 
             placeholder="Judul Buku"
             class="input input-bordered w-full bg-white text-black border-black" required>

      <input type="text" 
             name="penulis" 
             value="<?= htmlspecialchars($buku['penulis']); ?>" 
             placeholder="Penulis Buku"
             class="input input-bordered w-full bg-white text-black border-black">

      <input type="number" 
             name="stok" 
             value="<?= $buku['stok']; ?>" 
             placeholder="Stok Buku"
             min="0"
             class="input input-bordered w-full bg-white text-black border-black" required>

      <input type="text" 
             name="kategori" 
             value="<?= htmlspecialchars($buku['kategori']); ?>" 
             placeholder="Kategori Buku"
             class="input input-bordered w-full bg-white text-black border-black" required>

      <input type="text" 
             name="penerbit" 
             value="<?= htmlspecialchars($buku['penerbit']); ?>" 
             placeholder="Penerbit Buku"
             class="input input-bordered w-full bg-white text-black border-black">

      <button type="submit" name="update" class="btn bg-blue-600 hover:bg-blue-700 text-white w-full">Simpan Perubahan</button>
    </form>

    <a href="index.php" class="btn bg-gray-200 hover:bg-gray-300 text-black w-full mt-3">← Kembali</a>
  </div>
</div>

</body>
</html>
