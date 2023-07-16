<?php
include '../env/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $alamat = $_POST["alamat"];
    $no_telp = $_POST["no_telp"];
    $email = $_POST["email"];
    $privilege = "Pelanggan";
    
    // Generate angka unik acak sebagai user_id
    $user_id = uniqid();

    // Query untuk memasukkan data registrasi ke tabel users
    $sql = "INSERT INTO users (user_id, username, password, alamat, no_telp, email, privilege)
            VALUES ('$user_id', '$username', '$password', '$alamat', '$no_telp', '$email', '$privilege')";

    if ($conn->query($sql) === TRUE) {
        session_start();
        $_SESSION["user_id"] = $user_id;
        
        header('Location: ../auth/register-house.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
