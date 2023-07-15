<?php
// Koneksi ke database
include("config.php");

$user_id = 1; // ganti dengan user_id yang ingin dihapus
// Buat query untuk menghapus data dari tabel users
$sql = "DELETE FROM users WHERE user_id='$user_id'";
$query = mysqli_query($conn, $sql);

if ($query) {
    echo '<script>alert("Data berhasil dihapus!"); window.location.href="../pages/admin.php";</script>';
} else {
    echo '<script>alert("Terjadi kesalahan saat menghapus data."); window.location.href="../pages/admin.php";</script>';
}
?>
