<?php
session_start(); // Mulai sesi

// Tentukan username dan password admin
define('ADMIN_USER', 'admin'); 
define('ADMIN_PASS', 'password'); // Gantilah dengan password yang aman

// Cek apakah ada parameter redirect_to di URL
if (isset($_GET['redirect_to'])) {
    $_SESSION['redirect_to'] = $_GET['redirect_to']; // Simpan URL tujuan dalam session
}

// Cek apakah formulir login sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifikasi login
if ($username === ADMIN_USER && $password === ADMIN_PASS) {
  $_SESSION['admin'] = true; // Tandai sebagai admin

  // Arahkan langsung ke halaman index.html setelah login berhasil
  header("Location: ../index.html"); // Halaman yang dituju setelah login
  exit();
} else {
  $error = "Username atau password salah!";
}

}
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Makeup by Rinny</title>
    <link rel="stylesheet" href="../css/style.css" />
  </head>
  <body>
    <!-- Header Section -->
    <header>
      <div class="logo">
        <h1><a href="../index.html">Makeup by Rinny</a></h1>
      </div>
      <nav class="navbar">
      <ul>
                <li><a href="../index.html">Home</a></li>
                <li><a href="../about.html">About</a></li>
                <li class="dropdown">
            <a href="../services.html">Services</a>
            <ul class="dropdown-content">
              <li><a href="bridal-makeup.php">Bridal Makeup</a></li>
              <li><a href="party-makeup.php">Party Makeup</a></li>
              <li>
                
                <a href="photo-session-makeup.php"
                  >Photo Session Makeup</a
                >
              </li>
            </ul>
          </li>
                <li><a href="../testimonials.html">Testimonials</a></li>
                <li><a href="../contact.html">Contact</a></li>
            </ul>
      </nav>
    </header>

    <!-- Login Section -->
    <section class="login">
      <h2>Login Admin</h2>
      <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required /><br /><br />
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required /><br /><br />
        <button type="submit">Login</button>
      </form>
      <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    </section>

    <!-- Footer Section -->
    <footer>
      <p>
        &copy; 2024 Makeup by Rinny | Website created by Wanda & Fannesallia
      </p>
    </footer>
  </body>
</html>
