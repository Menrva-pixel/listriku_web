<?php
include '../env/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $alamat = $_POST["alamat"];
    $no_telp = $_POST["no_telp"];
    $email = $_POST["email"];
    $privilege = "Pelanggan"; // Atur privilege sesuai kebutuhan
    
    // Query untuk memasukkan data registrasi ke tabel users
    $sql = "INSERT INTO users (username, password, alamat, no_telp, email, privilege)
            VALUES ('$username', '$password', '$alamat', '$no_telp', '$email', '$privilege')";

    if ($conn->query($sql) === TRUE) {
        // Redirect ke halaman login.php
        header('Location: ../auth/login.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>