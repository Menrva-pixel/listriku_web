<?php
session_start();
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

if (!isset($_SESSION['username']) || $_SESSION['privilege'] !== 'Admin') {
    // Return empty response if the user is not an admin
    echo ": \n\n";
    flush();
    exit();
}

// You can include your database connection code here if needed.

// Function to get the latest tagihan data and generate notification message
function getLatestTagihanData() {
    global $conn;
    // Your query to get the latest tagihan data for notifications
    // For example:
    $query = "SELECT * FROM tagihan_listrik ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $tagihanData = mysqli_fetch_assoc($result);
    return $tagihanData;
}

while (true) {
    $tagihanData = getLatestTagihanData();
    if ($tagihanData) {
        // Convert tagihanData to JSON format
        $notificationData = [
            'message' => "Tagihan baru untuk bulan " . $tagihanData['bulan'] . " " . $tagihanData['tahun'] . " telah ditambahkan.",
            'type' => 'info' // You can customize the type based on your design.
        ];
        echo "data: " . json_encode($notificationData) . "\n\n";
        flush();
    }

    // Adjust the sleep duration based on your requirement
    // For example, you can set it to 5 seconds or more.
    sleep(2);
}
