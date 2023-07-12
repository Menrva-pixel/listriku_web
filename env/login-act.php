<?php
session_start();
include 'config.php';

function getUserFromDatabase($username, $password) {
    global $conn;

    // cek apakah user ada di tabel users
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $user['privilege'] = 'Pelanggan';
        return $user;
    }

    // cek apakah user ada di tabel admin_users
    $query = "SELECT * FROM admin_users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $user['privilege'] = 'Admin';
        return $user;
    }

    return null;
}

function login($username, $password) {
    // cek apakah username dan password benar
    $user = getUserFromDatabase($username, $password);
    if ($user) {
        // jika benar, simpan informasi user ke session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['privilege'] = $user['privilege'];
        return true;
    } else {
        // jika salah, kembalikan false
        return false;
    }
}

function isAdmin() {
    return isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'Admin';
}

function isPelanggan() {
    return isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'Pelanggan';
}

function redirect() {
    if (isAdmin()) {
        header('Location: ../pages/admin.php');
        exit;
    } else if (isPelanggan()) {
        header('Location: ../pages/user.php');
        exit;
    }
}

// ambil data username dan password dari form login
$username = $_POST['username'];
$password = $_POST['password'];

if (login($username, $password)) {
    redirect();
} else {
    // tampilkan pesan error
}
