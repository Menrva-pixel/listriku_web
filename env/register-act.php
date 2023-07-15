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
        // Ambil user_id baru yang telah terdaftar
        $user_id = $conn->insert_id;

        // Set session dengan user_id
        session_start();
        $_SESSION["user_id"] = $user_id;

        // Redirect ke halaman form registrasi rumah
        header('Location: ../auth/register-house.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
