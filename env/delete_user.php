<?php
include("../env/config.php");

    $id=$_GET['id'];
    $sql ="DELETE FROM users WHERE id='$id'";
    $query = mysqli_query($conn, $sql);
    // $data = mysqli_fetch_array($query);
    // $no = 1;
    
    
    echo '<script language="javascript" type="text/javascript">
    alert("pesan berhasil di hapus!");</script>';
    echo "<meta http-equiv='refresh' content='2; url=../admin/index'>";
?>