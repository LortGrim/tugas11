<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

// Proses simpan data
if (isset($_POST['simpan'])) {
    $judul    = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis  = mysqli_real_escape_string($conn, $_POST['penulis']);
    $stok     = (int)$_POST['stok'];
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);

    $query = "INSERT INTO buku (judul, penulis, stok, kategori, penerbit)
              VALUES ('$judul', '$penulis', '$stok', '$kategori', '$penerbit')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Buku</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.css" rel="stylesheet" type="text/css" />
</head>
<body class="bg-blue-50 text-black">

<div class="flex items-center justify-center min-h-screen">
  <div class="card w-full max-w-md bg-white shadow-xl p-6 border border-gray-200">
    <h2 class="text-3xl font-bold text-blue-700 mb-6 text-center">➕ Tambah Buku</h2>

    <p class="text-sm text-gray-600 mb-2">
    <?= ($_SESSION['role'] === 'admin') ? 'Anda login sebagai Admin' : 'Anda login sebagai User'; ?>
    </p>

    <form method="post" class="space-y-4">
      <input type="text" name="judul" placeholder="Judul Buku" class="input input-bordered w-full bg-white text-black" required>

      <input type="text" name="penulis" placeholder="Penulis Buku" class="input input-bordered w-full bg-white text-black">

      <input type="number" name="stok" placeholder="Stok Buku" class="input input-bordered w-full bg-white text-black" required min="0">

      <input type="text" name="kategori" placeholder="Kategori Buku" class="input input-bordered w-full bg-white text-black" required>

      <input type="text" name="penerbit" placeholder="Penerbit Buku" class="input input-bordered w-full bg-white text-black">

      <button type="submit" name="simpan" class="btn bg-blue-600 hover:bg-blue-700 text-white w-full mt-2">Simpan</button>
    </form>

    <a href="index.php" class="btn bg-gray-200 hover:bg-gray-300 text-black w-full mt-3">← Kembali</a>
  </div>
</div>

</body>
</html>
