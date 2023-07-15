<?php
session_start();
include '../env/config.php';
include '../env/func.php';

// Redirect to login page if not logged in or not a user
if (!isset($_SESSION['username']) || $_SESSION['privilege'] != 'Pelanggan') {
    header('Location: ../auth/login.php');
    exit;
}

// Get user data
$username = $_SESSION['username'];
$user = getUserFromDatabase($username);

// Get tagihan listrik data
$tagihan_listrik = getTagihanListrik($user['user_id']);

// Handle form submission for payment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_id = $_POST['payment_id'];

    // Redirect to payment detail page
    header("Location: payment_detail.php?payment_id=$payment_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page | Listriku</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.7/tailwind.min.css" rel="stylesheet">
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
                <a href="user.php" class="text-gray-600 hover:text-gray-800 mr-4">User Page</a>
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                    onclick="logout()">Logout</button>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-3xl font-semibold mb-4">List Tagihan</h1>

            <table class="w-full text-center">
                <thead>
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Month</th>
                        <th class="px-4 py-2">Year</th>
                        <th class="px-4 py-2">Total Bill</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tagihan_listrik as $index => $tagihan): ?>
                    <?php if ($tagihan['status'] == 'Belum Bayar'): ?>
                    <tr>
                        <td class="border px-4 py-2"><?php echo $index + 1; ?></td>
                        <td class="border px-4 py-2"><?php echo $tagihan['bulan']; ?></td>
                        <td class="border px-4 py-2"><?php echo $tagihan['tahun']; ?></td>
                        <td class="border px-4 py-2"><?php echo $tagihan['total_tagihan']; ?></td>
                        <td class="border px-4 py-2"><?php echo $tagihan['status']; ?></td>
                        <td class="border px-4 py-2">
                            <form method="POST" action="">
                                <input type="hidden" name="payment_id" value="<?php echo $tagihan['id']; ?>">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Bayar</button>
                            </form>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function logout() {
            window.location.href = '../auth/logout.php';
        }
    </script>
</body>

</html>
