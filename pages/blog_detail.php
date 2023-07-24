<?php
include '../env/config.php';
include '../env/func.php';

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

// Dapatkan daftar postingan berdasarkan bulan dari database
$blogPostsByMonth = getBlogPostsByMonth();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post['title']; ?></title>
    <link href="../assets/icons/favicon.ico" rel="icon">
    <link href="../assets/icons/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/blog.css">
</head>
<header>
    <?php
include('../include/navbar.php');
?>
</header>

<body class="bg-gray-100">
    <div class="header">
        <img src="../assets/images/blog/<?php echo basename($post['image_blob']); ?>" alt="Header Image">
    </div>
    <div class="blog-content flex flex-row">
        <aside class="bg-gray-200 px-4 py-6 rounded-lg sidebar">
            <h3 class="text-xl font-bold mb-4">Postingan Berdasarkan Bulan</h3>
            <ul>
                <?php foreach ($blogPostsByMonth as $monthYear => $posts): ?>
                <li>
                    <strong class="text-lg"><?php echo $monthYear; ?></strong>
                    <ul class="list-disc list-inside">
                        <?php foreach ($posts as $postItem): ?>
                        <li>
                            <a href="blog_detail.php?id=<?php echo $postItem['id']; ?>"
                                class="text-blue-500 hover:underline">
                                <?php echo $postItem['title']; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php endforeach; ?>
            </ul>
        </aside>
        <div class="flex flex-row px-24">
            <div class="mx-auto my-8 px-4 content">
                <h2 class="text-5xl  font-bold mb-8"><?php echo $post['title']; ?></h2>
                <div class="text-gray-600 leading-relaxed text-2xl"><?php echo $post['content']; ?></div>
                <p class="text-gray-600">Penulis: <?php echo $post['author']; ?></p>
                <p class="text-gray-600">Tanggal: <?php echo $post['created_at']; ?></p>
            </div>
        </div>
    </div>
    <footer><?php include('../include/footer.php');?></footer>
</body>

</html>