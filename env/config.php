<?php 
    $servername = "localhost";
    $database = "app_listrik"; 
    $username = "root";
    $password = ""; 
    // membuat koneksi
    $conn = mysqli_connect($servername, $username, $password, $database);
    // mengecek koneksi
    if (!$conn) {
        die("Maaf koneksi anda gagal : " . mysqli_connect_error());
    }
?>