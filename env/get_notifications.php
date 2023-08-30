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


// Function to get the latest tagihan data and generate notification message
function getLatestTagihanData() {
    global $conn;
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
            'type' => 'info' 
        ];
        echo "data: " . json_encode($notificationData) . "\n\n";
        flush();
    }

    sleep(2);
}
