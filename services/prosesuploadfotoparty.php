<?php
// Sertakan file db.php untuk koneksi database
include '../koneksi.php';

if (isset($_POST['submit'])) {
    // Ambil data file gambar
    $image = $_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];
    $target = __DIR__ . "/partymakeup/" . basename($image);

    // Daftar tipe file yang diizinkan
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    // Cek tipe MIME file
    $fileType = mime_content_type($tmpName);
    if (in_array($fileType, $allowedTypes)) {
        // Cek apakah file berhasil diunggah ke folder sementara
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Memindahkan file gambar ke folder uploads
            if (move_uploaded_file($tmpName, $target)) {
                // Masukkan informasi gambar ke database
                $sql = "INSERT INTO gallery_party (image_name) VALUES ('$image')";
                if ($conn->query($sql) === TRUE) {
                    // Redirect ke halaman galeri setelah sukses
                    header("Location: party-makeup.php?unggahgambar=berhasil");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Gagal memindahkan file ke folder uploads!";
            }
        } else {
            echo "Error saat mengunggah file: " . $_FILES['image']['error'];
        }
    } else {
        echo "Hanya file gambar yang diperbolehkan! Tipe file yang diunggah: $fileType";
    }
}

// Menutup koneksi
$conn->close();
?>
