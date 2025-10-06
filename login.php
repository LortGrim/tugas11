<?php
session_start();
include 'koneksi.php';
$error = ''; // Variabel untuk menampung pesan error
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Enkripsi password input supaya cocok dengan yang di database
    $hashed = md5($password);

    // Cek user berdasarkan username dan password MD5
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$hashed'");
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Simpan data ke session
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // arahkan setelah login
            header("Location: index.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card shadow-lg p-4" style="width: 400px;">
  <h4 class="text-center text-primary fw-bold mb-2">Selamat Datang di Data Buku Sekolah📖</h4>
  <p class="text-center text-muted mb-3">Silakan login untuk melanjutkan</p>

  <h3 class="text-center mb-3">Login</h3>

  <!-- Pesan error muncul di sini -->
  <?php if ($error): ?>
    <div class="alert alert-danger text-center py-2">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <div class="input-group">
        <input id="password" type="password" name="password" class="form-control" required aria-describedby="togglePassword" />
        <button class="btn btn-outline-secondary" type="button" id="togglePassword" aria-label="Tampilkan password">
          <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8z"/>
            <path d="M8 5.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5z" fill="#fff"/>
          </svg>
          <svg id="icon-eye-slash" class="d-none" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
            <path d="M13.359 11.238C12.126 12.397 10.191 13.5 8 13.5 3 13.5 0 8 0 8s1.604-2.69 3.5-4.135L1.354 1.719 2.06 1.012l12 12-.707.707-1.999-1.888z"/>
            <path d="M11.646 9.354A3.5 3.5 0 0 1 6.646 4.354l5 5z"/>
          </svg>
        </button>
      </div>
    </div>

    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
  </form>
</div>

<script>
const toggleBtn = document.getElementById('togglePassword');
const pwdInput = document.getElementById('password');
const eye = document.getElementById('icon-eye');
const eyeSlash = document.getElementById('icon-eye-slash');

toggleBtn.addEventListener('click', () => {
  const isPassword = pwdInput.getAttribute('type') === 'password';
  if (isPassword) {
    pwdInput.setAttribute('type', 'text');
    eye.classList.add('d-none');
    eyeSlash.classList.remove('d-none');
  } else {
    pwdInput.setAttribute('type', 'password');
    eye.classList.remove('d-none');
    eyeSlash.classList.add('d-none');
  }
});
</script>
</body>
</html>
