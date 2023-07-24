<?php
session_start();
include '../env/config.php';
include '../env/func.php';

if (!isset($_SESSION['username']) || !isAdminPage()) {
    header('Location: ../auth/login');
    exit;
}

$admin_username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Postingan</title>
    <link href="../assets/icons/favicon.ico" rel="icon">
    <link href="../assets/icons/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="container mx-auto mt-8">
        <div class="bg-white shadow-md rounded-lg px-8 py-6">
            <h1 class="text-2xl font-semibold mb-6">Create New Blog Post</h1>

            <form method="post" action="../env/save_post.php" enctype="multipart/form-data">
                <!-- Tambahkan elemen input untuk judul, konten, penulis, kategori, dan gambar -->
                <label for="title">Judul Postingan:</label>
                <input type="text" name="title" id="title" required>

                <label for="content">Isi Postingan:</label>
                <textarea name="content" id="content" rows="6" required></textarea>

                <label for="author">Penulis:</label>
                <input type="text" name="author" id="author" value="<?php echo $_SESSION['username']; ?>" required readonly>

                <label for="category">Kategori:</label>
                <select name="category" id="category" required>
                    <option value="Berita">Berita</option>
                    <option value="Sosial">Sosial</option>
                    <option value="Update">Update</option>
                </select>

                <label for="image">Gambar Header (JPG format, max 2MB):</label>
                <input type="file" id="image" name="image" accept=".jpg" required>

                <!-- Tambahkan tombol untuk menyimpan postingan -->
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan Postingan</button>
            </form>


        </div>
    </div>

</body>
</html>
