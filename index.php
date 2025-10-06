<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require 'koneksi.php';

// Ambil data role dari session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'user';

// Ambil data buku dari database
$result = mysqli_query($conn, "SELECT * FROM buku ORDER BY id_buku DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Buku Sekolah</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.css" rel="stylesheet" type="text/css" />
</head>
<body class="bg-blue-50 min-h-screen">

<!-- Navbar -->
<div class="navbar bg-blue-600 text-white shadow-md">
  <div class="flex-1">
    <a class="text-2xl font-bold text-white p-4">📚 Data Buku Sekolah</a>
  </div>
  <div class="flex-none">
    <span class="mr-4">
      Halo, <b><?= htmlspecialchars($_SESSION['username']); ?></b> 
      <a class="italic">(<?= htmlspecialchars($role); ?>)</a>
    </span>
    <a href="logout.php" class="btn bg-red-500 hover:bg-red-600 text-white btn-sm">Logout</a>
  </div>
</div>

<!-- Container -->
<div class="container mx-auto p-6">
  <div class="text-center mb-8">
    <h1 class="text-4xl font-bold text-blue-700">📖 Data Buku</h1>
    <p class="text-gray-600">Perpustakaan Sekolah Makin Maju</p>
  </div>

  <!-- Tombol Tambah Buku -->
  <div class="flex justify-end mb-4">
    <a href="tambah.php" class="btn bg-blue-500 hover:bg-blue-600 text-white">+ Tambah Buku</a>
  </div>

  <!-- Tabel Data Buku -->
<div class="overflow-x-auto shadow-lg rounded-lg bg-white p-4">
  <table class="w-full border border-black text-black border-collapse">
    <thead class="bg-blue-100 text-blue-800">
      <tr>
        <th class="border border-black px-4 py-2">ID</th>
        <th class="border border-black px-4 py-2">Judul</th>
        <th class="border border-black px-4 py-2">Penulis</th>
        <th class="border border-black px-4 py-2">Stok</th>
        <th class="border border-black px-4 py-2">Kategori</th>
        <th class="border border-black px-4 py-2">Penerbit</th>
        <th class="border border-black px-4 py-2 text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($result)) : ?>
      <tr class="hover:bg-blue-50">
        <td class="border border-black px-4 py-2 text-center"><?= $row['id_buku']; ?></td>
        <td class="border border-black px-4 py-2"><?= htmlspecialchars($row['judul'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
        <td class="border border-black px-4 py-2"><?= htmlspecialchars($row['penulis'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
        <td class="border border-black px-4 py-2 text-center"><?= htmlspecialchars($row['stok'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
        <td class="border border-black px-4 py-2"><?= htmlspecialchars($row['kategori'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
        <td class="border border-black px-4 py-2"><?= htmlspecialchars($row['penerbit'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>

        <td class="border border-black px-4 py-2 text-center">
          <?php if ($role === 'admin'): ?>
            <a href="ubah.php?id=<?= $row['id_buku']; ?>" class="btn bg-yellow-400 hover:bg-yellow-500 text-black btn-sm">Ubah</a>
            <a href="#" onclick="openModal(<?= $row['id_buku']; ?>)" class="btn bg-red-500 hover:bg-red-600 text-white btn-sm">Hapus</a>
          <?php else: ?>
            <span class="text-gray-500 italic">Hanya Admin</span>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- Modal Konfirmasi Hapus -->
<input type="checkbox" id="modal-hapus" class="modal-toggle" />
<div class="modal" role="dialog">
  <div class="modal-box text-center">
    <h3 class="text-lg font-bold text-red-600">Konfirmasi Hapus</h3>
    <p class="py-4 text-gray-700">
      Apakah kamu yakin ingin menghapus data buku ini?<br>
      <span class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan.</span>
    </p>
    <div class="modal-action justify-center">
      <a id="hapusLink" href="#" class="btn bg-red-600 hover:bg-red-700 text-white">Ya, Hapus</a>
      <label for="modal-hapus" class="btn bg-gray-200 hover:bg-gray-300 text-black">Batal</label>
    </div>
  </div>
</div>

<script>
function openModal(id) {
  document.getElementById("hapusLink").href = "hapus.php?id=" + id;
  document.getElementById("modal-hapus").checked = true;
}
</script>

</body>
</html>
