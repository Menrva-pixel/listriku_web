<?php
// Koneksi ke database
include("config.php");

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    
    // Menghapus user berdasarkan user_id
    $sql = "DELETE FROM users WHERE user_id = '$user_id'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo '<script>alert("Data berhasil dihapus!"); window.location.href="../pages/admin.php";</script>';
    } else {
        echo '<script>alert("Terjadi kesalahan saat menghapus data."); window.location.href="../pages/admin.php";</script>';
    }
} else {
    echo '<script>alert("User dengan ID tersebut tidak ditemukan."); window.location.href="../pages/admin.php";</script>';
}
?>
