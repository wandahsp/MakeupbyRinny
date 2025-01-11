<?php
session_start(); // Mulai sesi

// Cek apakah pengguna sudah login sebagai admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Sertakan file koneksi ke database
include '../koneksi.php';

// Menangani permintaan penghapusan gambar
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // Ambil nama file berdasarkan ID
    $stmt = $conn->prepare("SELECT image_name FROM gallery_bridal WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($image_name);
    $stmt->fetch();
    $stmt->close();

    // Hapus file dari folder jika ada
    if ($image_name && file_exists("bridalmakeup/$image_name")) {
        unlink("bridalmakeup/$image_name");
    }

    // Hapus data dari database
    $stmt = $conn->prepare("DELETE FROM gallery_bridal WHERE id = ?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        // Setelah berhasil menghapus, arahkan kembali ke bridal-makeup.php
        header("Location: bridal-makeup.php?hapus=berhasil");
        exit();
    } else {
        echo "Failed to delete image: " . $conn->error;
    }
}

// Ambil data gambar dari database, urutkan berdasarkan waktu upload terbaru
$sql = "SELECT * FROM gallery_bridal ORDER BY uploaded_at DESC"; // Urutkan berdasarkan waktu upload terbaru
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bridal Makeup Gallery | Makeup by Rinny</title>
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
                        <li><a href="photo-session-makeup.php">Photo Session Makeup</a></li>
                    </ul>
                </li>
                <li><a href="../testimonials.html">Testimonials</a></li>
                <li><a href="../contact.html">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Bridal Makeup Gallery Section -->
    <section class="gallery">
        <div class="gallery-header">
            <h2>Bridal Makeup Gallery</h2>
            <!-- Menampilkan Logout jika sudah login sebagai admin -->
            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
                <a href="logout.php" class="login-logout">Logout</a>
            <?php else: ?>
                <a href="login.php" class="login-logout">Login</a>
            <?php endif; ?>
        </div>

        <a href="tambahfotobridal.php" class="upload-link">Unggah Gambar</a>
        <a href="hapusfotobridal.php" class="upload-link">Hapus Gambar</a>
        <a href="bridal-makeup.php" class="upload-link">Batal</a>

        <div class="gallery-images">
            <?php
            if ($result->num_rows > 0) {
                // Menampilkan gambar dengan urutan waktu terbaru
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='gallery-item'>
                            <img src='bridalmakeup/" . $row['image_name'] . "' alt='Gallery Image' width='200' />
                            <div class='gallery-actions'>
                                <a href='hapusfotobridal.php?delete={$row['id']}'>Hapus</a>
                            </div>
                          </div>";
                }
            } else {
                echo "<p>Tidak ada gambar di galeri.</p>";
            }
            ?>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Makeup by Rinny | Website created by Wanda & Fannesallia</p>
    </footer>
</body>
</html>
