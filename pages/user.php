<?php
session_start();
include '../env/config.php';

// Redirect to login page if not logged in or not a user
if (!isset($_SESSION['username']) || $_SESSION['privilege'] !== 'Pelanggan') {
    header('Location: login.php');
    exit;
}

// Get user data
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Update user data
if (isset($_POST['update'])) {
    $user_id = $user['user_id'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $email = $_POST['email'];

    // Update user data in the database
    $query = "UPDATE users SET alamat='$alamat', no_telp='$no_telp', email='$email' WHERE user_id='$user_id'";
    mysqli_query($conn, $query);

    // Refresh the page to reflect the updated data
    header('Location: user.php');
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>User Page</title>
    <link rel="stylesheet" href="../assets/css/user.css">
</head>
<body>
    <h1>Welcome, <?php echo $user['username']; ?></h1>
    <div class="profile-container">
        <div class="profile-image">
            <img src="path_to_profile_image" alt="Profile Image">
        </div>
        <div class="profile-info">
            <h2>Profil</h2>
            <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
            <p><strong>Alamat:</strong> <?php echo $user['alamat']; ?></p>
            <p><strong>No. Telp:</strong> <?php echo $user['no_telp']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        </div>

    </div>

    <div id="edit-form" style="display: none;">
        <h3>Edit Profile</h3>
        <form method="POST" action="user.php">
            <label for="alamat">Alamat:</label>
            <input type="text" id="alamat" name="alamat" value="<?php echo $user['alamat']; ?>" required><br>

            <label for="no_telp">No. Telp:</label>
            <input type="text" id="no_telp" name="no_telp" value="<?php echo $user['no_telp']; ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br>

            <button type="submit" name="update">Update</button>
            <button type="button" onclick="cancelEditForm()">Cancel</button>
        </form>
    </div>

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
            <?php foreach ($penggunaan_listrik as $index => $penggunaan): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo $penggunaan['bulan']; ?></td>
                <td><?php echo $penggunaan['tahun']; ?></td>
                <td><?php echo $penggunaan['meter_awal']; ?></td>
                <td><?php echo $penggunaan['meter_akhir']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

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
            <?php foreach ($tagihan_listrik as $index => $tagihan): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo $tagihan['bulan']; ?></td>
                <td><?php echo $tagihan['tahun']; ?></td>
                <td><?php echo $tagihan['jumlah_meter']; ?></td>
                <td><?php echo $tagihan['tarif_per_kwh']; ?></td>
                <td><?php echo $tagihan['total_tagihan']; ?></td>
                <td><?php echo $tagihan['status']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button onclick="logout()">Logout</button>

    <script>
        function showEditForm() {
            document.getElementById('edit-form').style.display = 'block';
        }

        function cancelEditForm() {
            document.getElementById('edit-form').style.display = 'none';
        }

        function logout() {
            window.location.href = 'logout.php';
        }
    </script>
</body>
</html>
