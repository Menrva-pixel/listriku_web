<?php 
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
    $ekstensi_diperbolehkan = array('png', 'jpg');
    $nama = $_FILES['file']['name'];
    $x = explode('.', $nama);
    $ekstensi = strtolower(end($x));
    $ukuran = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];

    if (in_array($ekstensi, $ekstensi_diperbolehkan)) {
        if ($ukuran < 1044070) {
            move_uploaded_file($file_tmp, 'file/' . $nama);
            
            // Insert file data into database table
            $sql = "INSERT INTO users (nama_file) VALUES ('$nama')";
            if (mysqli_query($conn, $sql)) {
                echo 'FILE BERHASIL DI UPLOAD';
            } else {
                echo 'GAGAL MENGUPLOAD GAMBAR';
            }
        } else {
            echo 'UKURAN FILE TERLALU BESAR';
        }
    } else {
        echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
    }
}
?>
