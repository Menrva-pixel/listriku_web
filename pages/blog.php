<?php 
include('../env/config.php');
include('../env/func.php');

$posts = getPostsFromDatabase();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-semibold mb-6">Welcome to Our Blog</h1>
        <?php if (!empty($posts)): ?>
        <div id="blogPosts" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($posts as $post): ?>
                <div class="bg-white shadow-md rounded-lg px-4 py-6">
                    <!-- Tautan untuk mengarahkan ke halaman detail -->
                    <a href="blog_detail.php?id=<?php echo $post['id']; ?>" class="block">
                        <h2 class="text-xl font-semibold mb-2"><?php echo $post['title']; ?></h2>
                    </a>
                    <p><?php echo $post['content']; ?></p>
                    <p class="text-gray-500">Tanggal dibuat: <?php echo $post['created_at']; ?></p>
                    <p class="text-gray-500">Penulis: <?php echo $post['author']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <p>No blog posts available.</p>
        <?php endif; ?>
    </div>

</body>
</html>
