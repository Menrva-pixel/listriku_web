<?php
session_start();
include '../env/config.php';

function getUserFromDatabase($username) {
    global $conn;

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        return $user;
    }

    return null;
}

function isUserPage() {
    return isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'Pelanggan';
}

function getPenggunaanListrik($user_id) {
    global $conn;
    $query = "SELECT * FROM penggunaan_listrik WHERE user_id='$user_id' ORDER BY tahun DESC, bulan DESC";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getTagihanListrik($user_id) {
    global $conn;
    $query = "SELECT * FROM tagihan_listrik WHERE user_id='$user_id' ORDER BY tahun DESC, bulan DESC";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Redirect to login page if not logged in or not a user
if (!isset($_SESSION['username']) || !isUserPage()) {
    header('Location: login.php');
    exit;
}

// Get user data
$username = $_SESSION['username'];
$user = getUserFromDatabase($username);

// Get penggunaan listrik data
$penggunaan_listrik = getPenggunaanListrik($user['user_id']);

// Get tagihan listrik data
$tagihan_listrik = getTagihanListrik($user['user_id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Page</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Welcome, <?php echo $user['username']; ?></h1>
    <h3>Tagihan Listrik</h3>
    <!-- Display tagihan listrik data -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Jumlah Meter</th>
                <th>Tarif per kWh</th>
                <th>Total Tagihan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through tagihan listrik data and display rows -->
            <?php foreach ($tagihan_listrik as $index => $row): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo $row['bulan']; ?></td>
                <td><?php echo $row['tahun']; ?></td>
                <td><?php echo $row['jumlah_meter']; ?></td>
                <td><?php echo number_format($row['tarif_per_kwh'], 2); ?></td>
                <td><?php echo number_format($row['total_tagihan'], 2); ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Penggunaan Listrik</h3>
    <!-- Display penggunaan listrik data -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Meter Awal</th>
                <th>Meter Akhir</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through penggunaan listrik data and display rows -->
            <?php foreach ($penggunaan_listrik as $index => $row): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo $row['bulan']; ?></td>
                <td><?php echo $row['tahun']; ?></td>
                <td><?php echo $row['meter_awal']; ?></td>
                <td><?php echo $row['meter_akhir']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

