<?php
// profile_update.php

session_start();
include 'config.php';

// Pastikan hanya pengguna yang sudah login yang dapat mengakses halaman ini
if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login');
    exit;
}

// Ambil user data dari database berdasarkan username
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo 'GAGAL MENGAMBIL DATA PENGUNA: ' . mysqli_error($conn);
    exit;
}

$user = mysqli_fetch_assoc($result);
$user_id = $user['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];

    // Lakukan proses update profile dengan user_id yang diperoleh dari database
    $query = "UPDATE users SET alamat='$alamat', no_telp='$no_telp' WHERE user_id='$user_id'";
    if (mysqli_query($conn, $query)) {
        // Jika update berhasil, redirect ke halaman profil pengguna
        header('Location: ../pages/user');
        exit;
    } else {
        echo 'GAGAL MEMPERBARUI DATA PENGUNA: ' . mysqli_error($conn);
    }
}
?>
