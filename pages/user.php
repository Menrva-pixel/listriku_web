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

// Handle form submission for updating user data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $email = $_POST['email'];

    // Update user data in the database
    $query = "UPDATE users SET alamat='$alamat', no_telp='$no_telp', email='$email' WHERE id='{$user['id']}'";
    mysqli_query($conn, $query);

    // Redirect back to the user profile page
    header('Location: user.php');
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css">
    <link rel="stylesheet" href="../assets/css/user.css">
    <style>
        /* Additional custom styles can be added here */
    </style>
</head>

<body>
    <div class="container mx-auto py-8">
        <div class="bg-gray-200 p-6 rounded-lg">
            <h1 class="profile-heading">Welcome, <?php echo $user['username']; ?></h1>
            <div class="flex items-center">
                <div class="w-1/4">
                    <?php if ($user['picture']): ?>
                        <img src="../uploads/<?php echo $user['picture']; ?>" alt="Profile Image"
                            class="profile-image rounded-full">
                    <?php else: ?>
                        <img src="../assets/images/default-profile.jpg" alt="Profile Image"
                            class="profile-image rounded-full">
                    <?php endif; ?>
                </div>
                <div class="w-3/4 ml-8">
                    <h2 class="text-2xl font-semibold">Profile</h2>
                    <div class="profile-details">
                        <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
                        <p><strong>Alamat:</strong> <?php echo $user['alamat']; ?></p>
                        <p><strong>No. Telp:</strong> <?php echo $user['no_telp']; ?></p>
                        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                    </div>
                    <button class="edit-profile-button" onclick="showEditForm()">Edit Profile</button>
                </div>
            </div>
            <div id="edit-form" class="edit-form mt-8">
                <h3 class="text-xl font-semibold">Edit Profile</h3>
                <form method="POST" action="../env/profile_update.php" class="mt-4">
                    <label for="alamat">Alamat:</label>
                    <input type="text" id="alamat" name="alamat" value="<?php echo $user['alamat']; ?>" required
                        class="w-full border border-gray-300 rounded py-2 px-4 mb-2">
                    <label for="no_telp">No. Telp:</label>
                    <input type="text" id="no_telp" name="no_telp" value="<?php echo $user['no_telp']; ?>" required
                        class="w-full border border-gray-300 rounded py-2 px-4 mb-2">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required
                        class="w-full border border-gray-300 rounded py-2 px-4 mb-2">
                    <div class="flex space-x-4">
                        <button type="submit" name="update" class="update-profile-button">Update</button>
                        <button type="button" onclick="cancelEditForm()" class="cancel-button">Cancel</button>
                    </div>
                </form>
                <form method="POST" action="../env/profile_update.php" enctype="multipart/form-data" class="mt-4">
                    <div class="form-group">
                        <label for="photo">Upload Photo (JPG format, max 2MB)</label>
                        <input type="file" id="photo" name="photo" accept=".jpg" required>
                    </div>
                    <button type="submit" class="update-profile-button">Update Profile</button>
                </form>
            </div>
            <h3 class="text-2xl mt-8">Electricity Bill</h3>
            <table class="mt-4 w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Month</th>
                        <th class="px-4 py-2">Year</th>
                        <th class="px-4 py-2">Meter Reading</th>
                        <th class="px-4 py-2">Tariff per kWh</th>
                        <th class="px-4 py-2">Total Bill</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tagihan_listrik as $index => $tagihan): ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo $index + 1; ?></td>
                            <td class="border px-4 py-2"><?php echo $tagihan['bulan']; ?></td>
                            <td class="border px-4 py-2"><?php echo $tagihan['tahun']; ?></td>
                            <td class="border px-4 py-2"><?php echo $tagihan['jumlah_meter']; ?></td>
                            <td class="border px-4 py-2"><?php echo $tagihan['tarif_per_kwh']; ?></td>
                            <td class="border px-4 py-2"><?php echo $tagihan['total_tagihan']; ?></td>
                            <td class="border px-4 py-2"><?php echo $tagihan['status']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3 class="text-2xl mt-8">Electricity Usage</h3>
            <table class="mt-4 w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Month</th>
                        <th class="px-4 py-2">Year</th>
                        <th class="px-4 py-2">Initial Reading</th>
                        <th class="px-4 py-2">Final Reading</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($penggunaan_listrik as $index => $penggunaan): ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo $index + 1; ?></td>
                            <td class="border px-4 py-2"><?php echo $penggunaan['bulan']; ?></td>
                            <td class="border px-4 py-2"><?php echo $penggunaan['tahun']; ?></td>
                            <td class="border px-4 py-2"><?php echo $penggunaan['meter_awal']; ?></td>
                            <td class="border px-4 py-2"><?php echo $penggunaan['meter_akhir']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button class="logout-button mt-8" onclick="logout()">Logout</button>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script>
                function showEditForm() {
                    $('#edit-form').show();
                }

                function cancelEditForm() {
                    $('#edit-form').hide();
                }

                function logout() {
                    window.location.href = 'logout.php';
                }
            </script>
        </div>
    </div>
</body>

</html>


