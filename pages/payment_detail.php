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

$paymentDate = isset($payment['tanggal_pembayaran']) ? $payment['tanggal_pembayaran'] : null;
$formattedPaymentDate = $paymentDate ? date('d F Y', strtotime($paymentDate)) : '';

// Calculate total bill amount
$totalBill = $payment['jumlah_meter'] * $payment['tarif_per_kwh'];

// Update payment status if payment is completed
if (isset($_POST['complete_payment'])) {
    completePayment($payment_id);
    header('Location: payment.php');
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
    <link rel="stylesheet" href="../assets/css/user.css">
</head>

<body class="bg-gray-100">
<div class="container mx-auto py-44">
    <div class="mx-auto w-96 bg-white bg-opacity-50 backdrop-blur-md rounded-lg shadow-md p-8">
        <div class="flex items-center justify-around mb-8">
            <img src="../assets/images/slider-dec.png" alt="Logo" class="w-24 h-24">
            <h2 class="text-1xl font-semibold">Payment Details</h2>
        </div>

        <div class="mb-6 text-center">
             <a class="font-semibold text-3xl text-gray-600">Total Bill:</a>
             <p class="font-bold text-4xl"> Rp <?php echo number_format($totalBill + 2500, 0, ',', '.'); ?></p> 
        </div>
        <hr>
        <div class="flex flex-col mb-6 text-xs">
            <div class="m-2 flex flex-column justify-between">
                <strong>Username</strong> <a><?php echo $user['username']; ?></a>
            </div>
            <div class="m-2 flex flex-column justify-between">
                <strong>Alamat Rumah</strong> <?php echo $user['alamat']; ?>
            </div>
            <div class="m-2 flex flex-column justify-between">
                <strong>Pemakaian Listrik</strong>
                <?php echo $payment['jumlah_meter']; ?> kWh
            </div>
            <div class="m-2 flex flex-column justify-between">
                <strong>Tanggal Pembayaran</strong> <?php echo $formattedPaymentDate; ?>
            </div>
            <hr>
            <div class="m-2 flex flex-column justify-between">
                <strong>Amount</strong>
                <p class="font-bold text-xs"> Rp <?php echo number_format($totalBill, 0, ',', '.'); ?></p> 
            </div>
            <div class="m-2 flex flex-column justify-between">
                <strong>Admin Fee</strong>
                <p class="font-bold text-xs"> Rp 2500</p> 
            </div>
            <hr>
            <div class="m-2 flex flex-column justify-between">
                <strong>Total Payment</strong>
                <p class="font-bold text-xs"> Rp <?php echo number_format($totalBill + 2500, 0, ',', '.'); ?></p> 
            </div>
        </div>


        <div class="flex justify-between mb-6">
            <button type="submit" name="complete_payment"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Bayar</button>

            <button type="button" onclick="printPaymentDetails()"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Cetak</button>
        </div>

        <a href="<URL>"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Kembali</a>

    </div>
</div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../assets/js/script.js"></script>
    <script>
        function logout() {
            window.location.href = '../auth/logout.php';
        }
    </script>
</body>

</html>
