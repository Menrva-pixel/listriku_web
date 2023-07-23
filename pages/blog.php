<?php
include '../env/config.php';
include '../env/func.php';

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
        <div id="blogPosts" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"></div>
    </div>

    <script>
        fetch('../env/get_post.php')
            .then(response => response.json())
            .then(posts => {
                const blogPostsContainer = document.getElementById('blogPosts');
                posts.forEach(post => {
                    const postCard = document.createElement('div');
                    postCard.classList.add('bg-white', 'shadow-md', 'rounded-lg', 'px-4', 'py-6');
                    postCard.innerHTML = `
                        <h2 class="text-xl font-semibold mb-2">${post.title}</h2>
                        <p>${post.content}</p>
                        <p class="text-gray-500">Tanggal dibuat: ${post.created_at}</p>
                        <p class="text-gray-500">Penulis: ${post.author}</p>
                    `;
                    blogPostsContainer.appendChild(postCard);
                });
            })
            .catch(error => console.error('Error fetching blog posts:', error));
    </script>

</body>
</html>
