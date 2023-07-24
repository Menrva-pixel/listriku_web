<?php 
include('../env/config.php');
include('../env/func.php');


$blogPostsByMonth = getBlogPostsByMonth();

$posts = getPostsFromDatabase();

$postsPerPage = 5;

// Get the current page number from the query parameter.
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Calculate the offset to retrieve the correct blog posts for the current page.
$offset = ($current_page - 1) * $postsPerPage;

// Get a subset of blog posts based on the current page and posts per page.
$paginatedPosts = array_slice($posts, $offset, $postsPerPage);

// Total number of blog posts (you should have this value from your data source).
$totalPosts = count($posts);

// Calculate the total number of pages needed for pagination.
$totalPages = ceil($totalPosts / $postsPerPage);

$sql = "SELECT * FROM blog_posts";

// Execute the query
$result = $conn->query($sql);

// Initialize the $posts array to store the fetched blog posts
$posts = array();

// Fetch and store each row as a blog post in the $posts array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs | Listriku</title>
    <link href="../assets/icons/favicon.ico" rel="icon">
    <link href="../assets/icons/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/blog.css"
</head>

<header>
    <?php
include('../include/navbar.php');
?>
</header>
<body class="bg-gray-100 flex flex-col">
    <div class="main flex flex-row">
    <aside class="bg-gray-200 px-4 py-6 rounded-lg sidebar">
        <h3 class="text-xl font-bold mb-4">Postingan Berdasarkan Bulan</h3>
        <ul>
            <?php foreach ($blogPostsByMonth as $monthYear => $posts): ?>  
                <li>
                    <strong class="text-lg"><?php echo $monthYear; ?></strong>
                    <ul class="list-disc list-inside">
                        <?php foreach ($posts as $postItem): ?>  
                            <li>
                                <a href="blog_detail.php?id=<?php echo $postItem['id']; ?>" class="text-blue-500 hover:underline">
                                    <?php echo $postItem['title']; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>
    
    <div class="container mx-auto my-8 px-4">
        <div class="blog-page mb-6">
            <h1 class="text-6xl font-bold">Berita Terbaru</h1>
            <p class="text-xl mb-6">Berita dan Postingan terbaru dari kami</p>
        </div>
        <?php if (!empty($paginatedPosts)): ?>
        <div id="blogPosts" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
            <?php foreach ($paginatedPosts as $post): ?>  
                <div class="bg-white col-span-2 shadow-lg border rounded-lg overflow-hidden">
                    <a href="blog_detail.php?id=<?php echo $post['id']; ?>" class="block">
                        <img src="<?php echo $post['image_blob']; ?>" alt="<?php echo $post['title']; ?>" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-4">
                        <a href="blog_detail.php?id=<?php echo $post['id']; ?>" class="block">
                            <h2 class="text-2xl font-semibold mb-2 text-gray-800 hover:text-blue-600"><?php echo $post['title']; ?></h2>
                        </a>
                        <p class="text-gray-600"><?php echo substr($post['content'], 0, 150) . '...'; ?></p>
                        <p class="text-gray-500 mt-2">Tanggal dibuat: <?php echo $post['created_at']; ?></p>
                        <p class="text-gray-500">Penulis: <?php echo $post['author']; ?></p>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
        <div class="mt-6">
            <?php if ($current_page > 1): ?>
                <a href="blog.php?page=<?php echo $current_page - 1; ?>" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i === $current_page): ?>
                    <span class="bg-blue-500 text-white px-4 py-2 rounded mr-2"><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="blog.php?page=<?php echo $i; ?>" class="bg-blue-200 text-blue-700 hover:bg-blue-300 px-4 py-2 rounded mr-2"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($current_page < $totalPages): ?>
                <a href="blog.php?page=<?php echo $current_page + 1; ?>" class="bg-blue-500 text-white px-4 py-2 rounded">Next</a>
            <?php endif; ?>
        </div>
        </div>
        <!-- Pagination links -->

        <?php else: ?>
            <p>No blog posts available.</p>
        <?php endif; ?>
    </div>
    <footer>
    <?php include('../include/footer.php'); ?>
    </footer>

</body>
</html>
