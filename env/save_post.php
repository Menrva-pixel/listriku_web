<?php
session_start();
include 'config.php';
include 'func.php';

// Kembali ke halaman login jika sesion user tidak terdeteksi
if (!isset($_SESSION['username']) || !isAdminPage()) {
    header('Location: ../auth/login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author']; // Get the author's name from the hidden input field

    // Insert the blog post data into the database
    $query = "INSERT INTO blog_posts (title, content, author, created_at) VALUES ('$title', '$content', '$author', NOW())";
    mysqli_query($conn, $query);

    header('Location:../pages/admin'); // Redirect back to the admin page
    exit;
}
?>
