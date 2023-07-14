<?php
session_start();
include '../env/config.php';
include '../env/func.php';

// Redirect to login page if not logged in or not a user
if (!isset($_SESSION['username']) || !isUserPage()) {
    header('Location: ../auth/login.php');
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


    // Ambil data penggunaan listrik dari database untuk chart
    $query = "SELECT * FROM penggunaan_listrik ORDER BY tahun, FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')";
    $result = mysqli_query($conn, $query);
    $penggunaan_listrik = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // menyiapkan data untuk chart
    $labels = [];
    $data = [];

    foreach ($penggunaan_listrik as $dataPoint) {
        $labels[] = $dataPoint['bulan'] . ' ' . $dataPoint['tahun'];
        $data[] = $dataPoint['meter_akhir'] - $dataPoint['meter_awal']; 
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.7/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/user.css">
</head>

<body class="bg-gray-100">
    <nav class="bg-white shadow">
        <div class="container mx-auto px-4 py-2 flex items-center justify-between">
            <div class="flex items-center">
                <a href="#" class="text-2xl font-bold">Logo</a>
                <div class="ml-4">
                    <i class="fas fa-bell text-gray-500"></i>
                </div>
            </div>
            <div class="flex items-center">
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                    onclick="logout()">Logout</button>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8">
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="flex items-center">
                <div class="w-full h-96 flex items-center justify-center">
                    <div class="w-auto flex items-center justify-between border-2 rounded-full">
                        <?php if ($user['picture']): ?>
                        <img src="../uploads/<?php echo $user['picture']; ?>" alt="Profile Image"
                            class="rounded-full h-32 w-32">
                        <?php else: ?>
                        <img src="../assets/images/default-profile.jpg" alt="Profile Image"
                            class="rounded-full h-32 w-32">
                        <?php endif; ?>
                    </div>
                </div>
                <hr class="border border-black my-4">
                <div class="w-3/4 ml-8">
                    <h1 class="text-3xl font-semibold mb-4">Welcome, <?php echo $user['username']; ?></h1>
                    <div class="mt-4 text-justify">
                        <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
                        <p><strong>Alamat:</strong> <?php echo $user['alamat']; ?></p>
                        <p><strong>No. Telp:</strong> <?php echo $user['no_telp']; ?></p>
                        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-2xl">Payment Status - <?php echo date('F Y'); ?></h3>
                        <p class="text-lg">Status: <?php echo getStatusPembayaranBulanTerakhir(); ?></p>
                    </div>
                    <div class="mt-8">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            onclick="showEditForm()">Edit Profile</button>
                    </div>
                </div>
            </div>
            <div id="edit-form" class="mt-8 hidden">
                <h3 class="text-xl font-semibold mb-4">Edit Profile</h3>
                <form method="POST" action="../env/profile_update.php" class="mt-4">
                    <div class="mb-4">
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat:</label>
                        <input type="text" id="alamat" name="alamat" value="<?php echo $user['alamat']; ?>" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="no_telp" class="block text-sm font-medium text-gray-700">No. Telp:</label>
                        <input type="text" id="no_telp" name="no_telp" value="<?php echo $user['no_telp']; ?>" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div class="flex space-x-4">
                        <button type="submit" name="update"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Update</button>
                        <button type="button" onclick="cancelEditForm()"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Cancel</button>
                    </div>
                </form>
                <form method="POST" action="../env/profile_update.php" enctype="multipart/form-data" class="mt-8">
                    <div class="mb-4">
                        <label for="photo" class="block text-sm font-medium text-gray-700">Upload Photo (JPG format, max
                            2MB)</label>
                        <input type="file" id="photo" name="photo" accept=".jpg" required>
                    </div>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update
                        Profile</button>
                </form>
            </div>

            <!-- Additional Elements and Graphics -->
            <div class="container mx-auto mt-8">
                <div class="flex items-center justify-between gap-10">
                    <div class="w-1/2">
                        <h3 class="text-2xl">Statistics</h3>
                        <canvas id="chart" class="mt-4"></canvas>
                    </div>
                    <div class="w-1/2">
                        <h3 class="text-2xl">Electricity Usage</h3>
                        <table class="mt-4 w-full text-center">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">Month</th>
                                    <th class="px-4 py-2">Year</th>
                                    <th class="px-4 py-2">Initial Reading</th>
                                    <th class="px-4 py-2">Final Reading</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-scrollable">
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
                    </div>

                </div>

                <h3 class="text-2xl mt-8">Electricity Bill</h3>
                <table class="mt-4 w-full text-center max-h-40 overflow-y-auto">
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
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/scrollreveal/4.0.3/scrollreveal.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/darkmode-toggle/1.3.5/darkmode-toggle.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script>
    var ctx = document.getElementById('chart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Electricity Usage',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: function (context) {
                    var value = context.dataset.data[context.dataIndex];
                    if (value >= 200) {
                        return 'red';
                    } else if (value >= 150) {
                        return 'yellow';
                    } else {
                        return 'green';
                    }
                },
                borderColor: '#4F46E5',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    </script>
</body>

</html>
