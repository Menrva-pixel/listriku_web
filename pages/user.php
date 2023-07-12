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

// Redirect to login page if not logged in or not a user
if (!isset($_SESSION['username']) || !isUserPage()) {
    header('Location: login.php');
    exit;
}

// Get user data
$username = $_SESSION['username'];
$user = getUserFromDatabase($username);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Page</title>
    <!-- Include CSS stylesheets and other necessary scripts -->
</head>
<body>
    <h1>Welcome, <?php echo $user['username']; ?></h1>
    <h3>Tagihan Listrik</h3>
    <!-- Display tagihan listrik data -->
    <table>
        <thead>
            <tr>
                <th>Month</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through tagihan listrik data and display rows -->
            <?php
            $query = "SELECT * FROM tagihan_listrik WHERE user_id = '{$user['id']}'";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['bulan'] . '</td>';
                echo '<td>' . $row['total_tagihan'] . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

    <h3>Penggunaan Listrik</h3>
    <!-- Display penggunaan listrik data -->
    <table>
        <thead>
            <tr>
                <th>Month</th>
                <th>Usage</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through penggunaan listrik data and display rows -->
            <?php
            $query = "SELECT * FROM penggunaan_listrik WHERE user_id = '{$user['id']}'";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['month'] . '</td>';
                echo '<td>' . $row['usage'] . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</body>
</html>
