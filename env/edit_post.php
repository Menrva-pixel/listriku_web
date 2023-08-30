<?php
session_start();
include 'config.php';
include 'func.php';

if (!isset($_SESSION['username']) || !isAdminPage()) {
    header('Location: ../auth/login');
    exit;
}

function getBlogPostById($post_id) {
    global $conn;
    $query = "SELECT * FROM blog_posts WHERE id='$post_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        return mysqli_fetch_assoc($result);
    } else {
        echo "Failed to fetch blog post: " . mysqli_error($conn);
        return null;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $base64Image = convertImageToBase64($imageTmpPath);
    } else {
        // Set default image if no image is uploaded
        $base64Image = '';
    }

    // Update the blog post data in the database
    $query = "UPDATE blog_posts SET title='$title', content='$content', category='$category', image_blob='$base64Image' WHERE id='$post_id'";
    mysqli_query($conn, $query);

    header('Location: ../pages/blog_detail.php?id=' . $post_id); // Redirect back to the blog detail page
    exit;
}

// Cek apakah parameter post_id tersedia dalam URL
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    // Dapatkan data postingan dari database berdasarkan ID
    $post = getBlogPostById($post_id);
} else {
    // Jika post_id tidak tersedia, kembali ke halaman sebelumnya
    header('Location: ../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <!-- Tambahkan link stylesheet Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-semibold mb-6">Edit Post</h1>
        <form method="post" action="edit_post.php" enctype="multipart/form-data" onsubmit="showSuccessMessage()">
            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
            <label for="title">Judul Postingan:</label>
            <input type="text" name="title" id="title" value="<?php echo $post['title']; ?>" required>

            <label for="content">Isi Postingan:</label>
            <textarea name="content" id="content" rows="6" required><?php echo $post['content']; ?></textarea>

            <label for="category">Kategori:</label>
            <select name="category" id="category">
                <option value="Berita" <?php echo ($post['category'] === 'Berita') ? 'selected' : ''; ?>>Berita</option>
                <option value="Sosial" <?php echo ($post['category'] === 'Sosial') ? 'selected' : ''; ?>>Sosial</option>
                <option value="Update" <?php echo ($post['category'] === 'Update') ? 'selected' : ''; ?>>Update</option>
            </select>

            <label for="image">Gambar Header (opsional):</label>
            <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">

            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan Perubahan</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <script>
    const form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission
        Swal.fire({
            title: 'Success!',
            text: 'Postingan telah berhasil di edit.',
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form after "OK" is clicked on the Swal
                form.submit();
            }
        });
    });
</script>

</body>
</html>
