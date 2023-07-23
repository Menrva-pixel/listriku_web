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
    <title>Create New Blog Post</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="container mx-auto mt-8">
        <div class="bg-white shadow-md rounded-lg px-8 py-6">
            <h1 class="text-2xl font-semibold mb-6">Create New Blog Post</h1>

            <form method="post" action="../env/save_post.php">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul Postingan:</label>
                    <input type="text" name="title" id="title" class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:border-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Isi Postingan:</label>
                    <textarea name="content" id="content" rows="6" class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:border-blue-500" required></textarea>
                </div>

                <!-- Tambahkan input tambahan atau elemen lain sesuai kebutuhan Anda -->

                <div class="mt-6">
                    <input type="hidden" name="author" value="<?php echo $admin_username; ?>">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan Postingan</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
