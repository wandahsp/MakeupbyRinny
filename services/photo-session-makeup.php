<?php
session_start(); // Mulai session untuk melacak status login
require '../koneksi.php'; // Panggil koneksi untuk menghubungkan ke database

// Ambil data gambar dari database
$sql = "SELECT * FROM gallery_ps ORDER BY uploaded_at DESC"; // Urutkan berdasarkan waktu upload terbaru
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Photo Session Makeup Gallery | Makeup by Rinny</title>
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

    <!-- Photo Session Makeup Gallery Section -->
    <section class="gallery">
      <h2>Photo Session Makeup Gallery</h2>

      <!-- Menampilkan Logout jika sudah login sebagai admin -->
      <div class="login-logout">
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
          <a href="logout.php" class="login-logout">Logout</a>
        <?php else: ?>
          <a href="login.php" class="login-logout">Login</a>
        <?php endif; ?>
      </div>

      <a href="tambahfotops.php" class="upload-link">Unggah Gambar</a> <!-- Link ke halaman upload -->
      <a href="hapusfotops.php" class="upload-link">Hapus Gambar</a> <!-- Link ke halaman hapus -->
      
      <div class="gallery-images">
        <?php
        if ($result->num_rows > 0) {
            // Menampilkan gambar
            while ($row = $result->fetch_assoc()) {
                echo "<img src='psmakeup/" . $row['image_name'] . "' alt='Gallery Image' />";
            }
        } else {
            echo "<p>Tidak ada gambar di galeri.</p>";
        }
        ?>
      </div>
    </section>

    <!-- Footer Section -->
    <footer>
      <p>
        &copy; 2024 Makeup by Rinny | Website created by Wanda & Fannesallia
      </p>
    </footer>
  </body>
</html>
