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

// Get selected payment ID from query string
$payment_id = isset($_GET['payment_id']) ? $_GET['payment_id'] : null;

// Get payment data by ID
$payment = getPaymentById($payment_id);

// Redirect to payment page if payment data not found
if (!$payment) {
    header('Location: pembayaran.php');
    exit;
}

// Calculate total bill amount
$totalBill = $payment['jumlah_meter'] * $payment['tarif_per_kwh'];

// Update payment status if payment is completed
if (isset($_POST['complete_payment'])) {
    completePayment($payment_id);
    header('Location: pembayaran.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Detail</title>
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
            <h1 class="text-3xl font-semibold mb-4">Payment Detail</h1>

            <div class="mb-4">
                <strong>Username:</strong> <?php echo $user['username']; ?>
            </div>
            <div class="mb-4">
                <strong>Alamat Rumah:</strong> <?php echo $user['alamat']; ?>
            </div>
            <div class="mb-4">
                <strong>Pemakaian Total Listrik Bulan Terakhir:</strong>
                <?php echo $payment['jumlah_meter']; ?> kWh
            </div>
            <div class="mb-4">
                <strong>Total Bill:</strong> Rp <?php echo number_format($totalBill, 0, ',', '.'); ?>
            </div>

            <form method="POST" action="">
                <input type="hidden" name="payment_id" value="<?php echo $payment_id; ?>">
                <button type="submit" name="complete_payment"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Bayar</button>
            </form>
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
