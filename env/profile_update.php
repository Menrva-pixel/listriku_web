<?php
session_start();
include 'config.php';

// Redirect to login page if not logged in or not a user
if (!isset($_SESSION['username']) || !isUserPage()) {
    header('Location: ../pages/login.php');
    exit;
}

function isUserPage() {
    return isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'Pelanggan';
}

function getUserFromDatabase($username) {
    global $conn;

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        return $user;
    }

    return null;
}
// Check if a file is uploaded
if (isset($_FILES['photo'])) {
    $file = $_FILES['photo'];

    // Check if the uploaded file is a valid JPG image
    $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($imageFileType !== 'jpg') {
        $_SESSION['error'] = 'Only JPG files are allowed.';
        header('Location: ../pages/user.php');
        exit;
    }

    // Check if the uploaded file is within the size limit
    $maxFileSize = 2 * 1024 * 1024; // 2MB
    if ($file['size'] > $maxFileSize) {
        $_SESSION['error'] = 'Maximum file size exceeded. Please upload a smaller file.';
        header('Location: ../pages/user.php');
        exit;
    }

    // Generate a unique filename for the uploaded file
    $filename = uniqid() . '.jpg';

    // Move the uploaded file to the destination folder
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
        $_SESSION['error'] = 'Upload directory is not writable.';
        header('Location: ../pages/user.php');
        exit;
    }

    $destination = $uploadDir . $filename;
    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        $_SESSION['error'] = 'Failed to upload file. Please try again.';
        header('Location: ../pages/user.php');
        exit;
    }

    // Update the user's profile picture in the database
    $stmt = mysqli_prepare($conn, "UPDATE users SET picture=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "si", $filename, $user['id']);
    mysqli_stmt_execute($stmt);

    // Redirect back to the user profile page
    header('Location: ../pages/user.php');
    exit;
}

// If no file is uploaded or other unexpected situation occurs, redirect back to the user profile page
header('Location: ../pages/user.php');
exit;