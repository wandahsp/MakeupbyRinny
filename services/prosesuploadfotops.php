<?php
// Sertakan file db.php untuk koneksi database
include '../koneksi.php'; 

if (isset($_POST['submit'])) {
    // Ambil data file gambar
    $image = $_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];
    $targetDir = __DIR__ . "/psmakeup/"; // Direktori tujuan
    $targetFile = $targetDir . basename($image);

    // Daftar tipe file yang diizinkan
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    // Cek tipe MIME file
    $fileType = mime_content_type($tmpName);
    $fileExtension = pathinfo($image, PATHINFO_EXTENSION);

    // Cek apakah file memiliki tipe yang diizinkan
    if (in_array($fileType, $allowedTypes)) {
        // Cek apakah file berhasil diunggah
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Cek apakah ekstensi file valid
            if (in_array(strtolower($fileExtension), ['jpeg', 'jpg', 'png', 'gif', 'webp'])) {
                // Menghasilkan nama unik untuk file
                $uniqueFileName = uniqid('image_', true) . '.' . $fileExtension;
                $finalTarget = $targetDir . $uniqueFileName;

                // Memindahkan file gambar ke folder yang telah ditentukan
                if (move_uploaded_file($tmpName, $finalTarget)) {
                    // Menyiapkan query untuk memasukkan nama file gambar ke dalam database
                    $stmt = $conn->prepare("INSERT INTO gallery_ps (image_name) VALUES (?)");
                    $stmt->bind_param("s", $uniqueFileName);

                    // Eksekusi query
                    if ($stmt->execute()) {
                        // Redirect ke halaman galeri setelah sukses
                        header("Location: photo-session-makeup.php?unggahgambar=berhasil");
                        exit();
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "Gagal memindahkan file ke folder uploads!";
                }
            } else {
                echo "Ekstensi file tidak valid! Hanya file dengan ekstensi .jpg, .jpeg, .png, .gif, atau .webp yang diperbolehkan.";
            }
        } else {
            echo "Error saat mengunggah file: " . $_FILES['image']['error'];
        }
    } else {
        echo "Hanya file gambar yang diperbolehkan! Tipe file yang diunggah: $fileType";
    }
}

$conn->close();
?>
