<?php
include '../env/config.php';
include '../env/func.php';

// Fungsi untuk mendapatkan data postingan dari database berdasarkan ID
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

// Fungsi untuk mendapatkan daftar postingan berdasarkan bulan dari database
function getBlogPostsByMonth() {
    global $conn;
    $query = "SELECT id, title, created_at FROM blog_posts ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $blogPostsByMonth = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $date = date_create($row['created_at']);
            $monthYear = date_format($date, 'F Y');
            $blogPostsByMonth[$monthYear][] = $row;
        }
        return $blogPostsByMonth;
    } else {
        echo "Failed to fetch blog posts: " . mysqli_error($conn);
        return [];
    }
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

// Dapatkan daftar postingan berdasarkan bulan dari database
$blogPostsByMonth = getBlogPostsByMonth();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post['title']; ?></title>
    <!-- Tambahkan link stylesheet Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Header dengan gambar besar -->
    <div class="header">
        <!-- Ganti img src dengan path ke gambar yang disimpan di direktori ../assets/images/blog -->
        <img src="<?php echo '../assets/images/blog/' . basename($post['image_blob']); ?>" alt="Header Image">
        <h1><?php echo $post['title']; ?></h1>
        <p>Penulis: <?php echo $post['author']; ?></p>
        <p>Tanggal: <?php echo $post['created_at']; ?></p>
    </div>

    <!-- Sidebar dengan list postingan berdasarkan bulan -->
    <div class="sidebar">
        <h3>Postingan Berdasarkan Bulan</h3>
        <ul>
            <?php
            // Tampilkan daftar postingan berdasarkan bulan
            foreach ($blogPostsByMonth as $monthYear => $posts) {
                echo '<li><strong>' . $monthYear . '</strong>';
                echo '<ul>';
                foreach ($posts as $postItem) {
                    echo '<li><a href="blog_detail.php?id=' . $postItem['id'] . '">' . $postItem['title'] . '</a></li>';
                }
                echo '</ul>';
                echo '</li>';
            }
            ?>
        </ul>
    </div>

    <!-- Isi konten postingan -->
    <div class="content">
        <h2><?php echo $post['title']; ?></h2>
        <?php echo $post['content']; ?>
    </div>
</body>
</html>
