<?php
include("config.php");

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Query untuk mendapatkan data gambar berdasarkan user_id
    $query = "SELECT picture FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($gambarBinary);
    $stmt->fetch();

    // Set header tipe konten gambar
    header("Content-Type: image/jpeg");

    // Mengirimkan gambar sebagai respons
    echo base64_decode($gambarBinary);

    $stmt->close();
}

?>
