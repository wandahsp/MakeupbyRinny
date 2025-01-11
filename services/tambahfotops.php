<?php
session_start(); // Mulai sesi

// Cek apakah pengguna sudah login sebagai admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Upload Foto Galeri | Makeup by Rinny</title>
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

    <!-- Upload Section -->
    <section class="upload">
      <h2>Upload Foto Galeri</h2>
      <form
        action="prosesuploadfotops.php"
        method="POST"
        enctype="multipart/form-data"
      >
        <label for="image">Pilih Gambar:</label>
        <input type="file" name="image" id="image" required />
        <br /><br />
        <button type="submit" name="submit">Unggah Foto</button>
      </form>

      <!-- Tombol Batal -->
      <a href="photo-session-makeup.php" class="cancel-button">Batal</a>
    </section>

    <!-- Footer Section -->
    <footer>
      <p>
        &copy; 2024 Makeup by Rinny | Website created by Wanda & Fannesallia
      </p>
    </footer>
  </body>
</html>
