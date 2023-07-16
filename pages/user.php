<?php
session_start();
include '../env/config.php';
include '../env/func.php';
include '../env/get-image.php';

// Kembali ke halaman login jika sesion user tidak terdeteksi
if (!isset($_SESSION['username']) || !isUserPage()) {
    header('Location: ../auth/login');
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM penggunaan_listrik WHERE user_id = '$user_id'";
$result = $conn->query($sql);

// GET user data
$username = $_SESSION['username'];
$user = getUserFromDatabase($username);

// GET data
$penggunaan_listrik = getPenggunaanListrik($user['user_id']);
$tagihan_listrik = getTagihanListrik($user['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $email = $_POST['email'];

    $query = "UPDATE users SET alamat='$alamat', no_telp='$no_telp', email='$email' WHERE id='{$user['id']}'";
    mysqli_query($conn, $query);

    header('Location: user');
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

    // notifikasi
    $query = "SELECT * FROM tagihan_listrik WHERE status = 'Belum Bayar'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $unpaidPayments = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $unpaidMonths = array_column($unpaidPayments, 'bulan');
        $notificationCount = count($unpaidPayments);
    } else {
        $unpaidMonths = [];
        $notificationCount = 0;
        echo "Failed to fetch unpaid payments: " . mysqli_error($conn);
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel | Listriku</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.7/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/user.css">
</head>

<body class="bg-gray-100">
    <nav class="bg-transparent shadow">
        <div class="container mx-auto px-4 py-2 flex items-center justify-between">
            <div class="flex items-center">
                <a href="../index">
                    <img src="../assets/images/logo.png" alt="Brand-Logo" class="h-10 w-auto">
                </a>
            </div>

            
            <div class="flex items-center">
            <div class="mr-4">
                <i class="fas fa-bell text-gray-500"></i>
                <div id="notification-container"></div>
                <?php if ($notificationCount > 0): ?>
                    <span class="notification-badge"><?php echo $notificationCount; ?></span>
                    <div id="notification-popup" class="notification-popup">
                        <h4 class="notification-title">Notification</h4>
                        <ul class="notification-list">
                            <?php foreach ($unpaidMonths as $month) : ?>
                                <li>Jangan lupa lunasi tagihan anda di bulan: <?php echo $month; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                </div>
                    <form method="GET" action="../auth/logout">
                        <button type="submit" name="logout" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Logout</button>
                    </form>
                </div>
            </div>
    </nav>

    <div class="container mx-auto mt-8">
        <div class="backdrop-blur-md bg-gray-900 bg-opacity-80 rounded-lg shadow-md p-8">
            <div class="flex items-center">
                <div class="w-full h-96 flex items-center justify-center">
                    <div class="w-auto flex items-center justify-between border-2 rounded-full">
                        <?php if ($user['picture']): ?>
                            <img src="<?php echo $user['user_id']; ?>" alt="Profile Image" class="rounded-full h-32 w-32">
                        <?php else: ?>
                        <img src="../assets/images/profile-placeholder.png" alt="Profile Image"
                            class="rounded-full h-32 w-32">
                        <?php endif; ?>
                    </div>
                </div>
                <hr class="border border-black my-4">
                <div class="w-3/4 mr-44 text-white">
                    <div class="flex flex-row justify-between"
                        <h1 class="text-3xl font-semibold mb-4">Welcome, <?php echo $user['username']; ?></h1>
                            <div class="ml-44">
                                <button onclick="redirectToPaymentPage()"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">Bayar</button>
                                <button type="button" onclick="showEditModal()"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">Edit Profile</button>
                            </div>
                        </div>
                    <div class="mt-4 text-justify">
                        <strong>Username:</strong> <p class="text-gray-400"><?php echo $user['username']; ?></p>
                        <strong>Alamat:</strong> <p class="text-gray-400"><?php echo $user['alamat']; ?></p>
                        <strong>No. Telp:</strong><p class="text-gray-400"><?php echo $user['no_telp']; ?></p>
                        <strong>Email:</strong><p class="text-gray-400"><?php echo $user['email']; ?></p>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-2xl">Payment Status - <?php echo date('F Y'); ?></h3>
                        <p class="text-lg">Status: <?php echo getStatusPembayaranBulanTerakhir(); ?></p>
                    </div>
                </div>
            </div>
            <div id="edit-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
                <div class="bg-white w-1/2 rounded-lg p-8">
                    <h3 class="text-xl font-semibold mb-4">Edit Profile</h3>
                    <form method="POST" action="../env/profile_update" class="mt-4">
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
                            <button type="button" onclick="hideEditModal()"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Cancel</button>
                        </div>
                    </form>
                    <form method="POST" action="../env/upload_gambar" enctype="multipart/form-data" class="mt-8">
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
            </div>

            <!-- Additional Elements and Graphics -->
            <div class="container mx-auto mt-8">
                <div class="flex items-center justify-between gap-10">
                    <div class="w-1/2">
                        <h3 class="text-2xl text-yellow-400">Statistics</h3>
                        <canvas id="chart" class="mt-4"></canvas>
                    </div>
                    <div class="w-1/2">
                        <h3 class="text-2xl text-yellow-400">Electricity Usage</h3>
                        <table class="mt-4 w-full text-center text-white">
                            <thead>
                                <tr class="bg-gray-700">
                                    <th class="border px-4 py-2">No</th>
                                    <th class="border px-4 py-2">Month</th>
                                    <th class="border px-4 py-2">Year</th>
                                    <th class="border px-4 py-2">Initial Reading</th>
                                    <th class="border px-4 py-2">Final Reading</th>
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

                <h3 class="text-2xl mt-8 text-yellow-400">Electricity Bill</h3>
                <table class="mt-4 w-full text-center max-h-40 overflow-y-auto text-white">
                    <thead>
                        <tr class="bg-gray-700">
                            <th class="border px-4 py-2">#</th>
                            <th class="border px-4 py-2">Month</th>
                            <th class="border px-4 py-2">Year</th>
                            <th class="border px-4 py-2">Meter Reading</th>
                            <th class="border px-4 py-2">Tariff per kWh</th>
                            <th class="border px-4 py-2">Total Bill</th>
                            <th class="border px-4 py-2">Status</th>
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

    <div class="footer">
        <div class="footer-info">

        </div>
        <div class="copyright flex justify-center items-center m-10">
            <p class="text-gray-200 text-sm text-lg">© 2023 Barkah Herdyanto S. All rights reserved.</p>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/scrollreveal/4.0.3/scrollreveal.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/darkmode-toggle/1.3.5/darkmode-toggle.min.js"></script>

    <script>
        var ctx = document.getElementById('chart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Electricity Usage',
                    type: 'line',
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
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                animations: {
                    tension: {
                        duration: 2000,
                        easing: 'linear',
                        from: 1,
                        to: 0,
                        loop: true
                    }
                }
            }
        });

    </script>

    <script>
            // Function to show notification
            function showNotification(message, type) {
                const notificationContainer = document.getElementById('notification-container');
                const notificationElement = document.createElement('div');
                notificationElement.classList.add('notification');
                notificationElement.classList.add(type);
                notificationElement.textContent = message;
                notificationContainer.appendChild(notificationElement);

                // Auto hide notification after 3 seconds
                setTimeout(() => {
                    notificationElement.style.opacity = '0';
                    setTimeout(() => {
                        notificationContainer.removeChild(notificationElement);
                    }, 300);
                }, 3000);
            }

            // Listen for notifications from the server
            const source = new EventSource('../env/get_notification.php');
            source.onmessage = function (event) {
                const notificationData = JSON.parse(event.data);
                showNotification(notificationData.message, notificationData.type);
            };

            const notificationIcon = document.querySelector('.fa-bell');
            const notificationPopup = document.getElementById('notification-popup');

            notificationIcon.addEventListener('click', () => {
            notificationPopup.classList.toggle('show');
            });

            document.addEventListener('click', (event) => {
            if (!notificationIcon.contains(event.target) && !notificationPopup.contains(event.target)) {
                notificationPopup.classList.remove('show');
            }
            });
        </script>
</body>

</html>