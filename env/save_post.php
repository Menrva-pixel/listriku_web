<?php
session_start();
include 'config.php';
include 'func.php';

// Kembali ke halaman login jika sesion user tidak terdeteksi
if (!isset($_SESSION['username']) || !isAdminPage()) {
    header('Location: ../auth/login');
    exit;
}

// Fungsi untuk mengonversi gambar ke base64
function convertImageToBase64($image)
{
    $imageData = file_get_contents($image);
    $base64Image = base64_encode($imageData);
    return $base64Image;
}

function saveImageToDirectory($imageTmpPath, $directoryPath, $fileName)
{
    $destinationPath = $directoryPath . '/' . $fileName;
    move_uploaded_file($imageTmpPath, $destinationPath);
    return $destinationPath;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author']; // Get the author's name from the hidden input field
    $category = $_POST['category']; // Get the selected category from the dropdown input field

    // Check if an image is uploaded
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $base64Image = convertImageToBase64($imageTmpPath);
    } else {
        // Set default image if no image is uploaded
        $base64Image = '';
    }

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $base64Image = convertImageToBase64($imageTmpPath);
    
        // Simpan gambar ke direktori
        $imageFileName = $_FILES['image']['name'];
        $uploadDirectory = '../assets/images/blog';
        $savedImagePath = saveImageToDirectory($imageTmpPath, $uploadDirectory, $imageFileName);
    } else {
        // Set default image if no image is uploaded
        $base64Image = '';
    }

    // Insert the blog post data into the database
    $query = "INSERT INTO blog_posts (title, content, author, category, image_blob, created_at) 
              VALUES ('$title', '$content', '$author', '$category', '$savedImagePath', NOW())";
    mysqli_query($conn, $query);

    header('Location:../pages/admin'); // Redirect back to the admin page
    exit;
}
?>
