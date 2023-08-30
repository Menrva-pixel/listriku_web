<?php
include("config.php");

// Mendapatkan informasi file yang di-upload
$namaFile = $_FILES['photo']['name'];
$ukuranFile = $_FILES['photo']['size'];
$error = $_FILES['photo']['error'];
$tmpName = $_FILES['photo']['tmp_name'];

// Mendapatkan ekstensi file
$ekstensiValid = ['jpg', 'jpeg'];
$ekstensiFile = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

// Cek apakah file yang di-upload benar-benar gambar JPG
if (!in_array($ekstensiFile, $ekstensiValid)) {
    echo "Hanya file JPG yang diizinkan.";
    exit;
}

// Cek ukuran file tidak melebihi 2MB
$ukuranMax = 2 * 1024 * 1024; // 2MB
if ($ukuranFile > $ukuranMax) {
    echo "Ukuran file terlalu besar. Maksimal 2MB.";
    exit;
}

// Membaca file gambar menjadi string base64
$gambarBinary = base64_encode(file_get_contents($tmpName));

// Generate nama file baru untuk menghindari kemungkinan nama file yang sama
$namaFileBaru = uniqid() . '.' . $ekstensiFile;

// Lokasi penyimpanan file gambar
$folderTujuan = "../assets/images/user/" . $namaFileBaru;

// Upload file gambar ke folder tujuan
if (move_uploaded_file($tmpName, $folderTujuan)) {
    // Jika berhasil di-upload, simpan nama file ke database
    $query = "UPDATE users SET picture = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $gambarBinary, $user_id);

    $user_id = 1; 
    if ($stmt->execute()) {
        echo "Gambar berhasil di-upload dan disimpan di database.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error saat meng-upload gambar.";
}

$conn->close();
?>
