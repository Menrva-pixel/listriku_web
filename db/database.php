<?php
$host = 'localhost'; // Nama host database
$dbname = 'nama_database'; // Nama database
$username = 'nama_pengguna'; // Username database
$password = 'kata_sandi'; // Kata sandi database

try {
    // Membuat objek koneksi PDO
    $koneksi = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set mode error PDO ke Exception
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Koneksi ke database berhasil!";
} catch (PDOException $e) {
    // Menampilkan pesan kesalahan jika gagal terhubung
    echo "Koneksi database gagal: " . $e->getMessage();
}
?>
