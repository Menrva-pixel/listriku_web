<?php
include("config.php");

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $sql = "DELETE FROM users WHERE user_id='$user_id'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        // Perform a successful deletion action, and let the client-side handle the redirection
        echo json_encode(array("status" => "success"));
    } else {
        // If there's an error, let the client-side handle it and show the error message
        echo json_encode(array("status" => "error", "message" => "Terjadi kesalahan saat menghapus data."));
    }
} else {
    // If the user_id parameter is not provided in the URL, handle the error here
    echo json_encode(array("status" => "error", "message" => "User tidak dapat ditemukan."));
}
?>
