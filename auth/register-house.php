<?php
include '../env/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $bulan = $_POST["bulan"];
    $tahun = $_POST["tahun"];
    $meter_awal = $_POST["meter_awal"];
    $meter_akhir = $_POST["meter_akhir"];
    $watt = $_POST["ukuran_watt"];

    $bulan = $_POST["bulan"];
    $bulan = strtoupper($bulan);

    // Insert data into penggunaan_listrik table
    $sql_penggunaan = "INSERT INTO penggunaan_listrik (user_id, bulan, tahun, meter_awal, meter_akhir, tanggal, watt)
        VALUES ('$user_id', '$bulan', '$tahun', '$meter_awal', '$meter_akhir', CURDATE(), '$watt')";

    if ($conn->query($sql_penggunaan) === TRUE) {
        // Insert data into tagihan_listrik table with status 'Belum Bayar'
        $jumlah_meter = $meter_akhir - $meter_awal;
        $tarif_per_kwh = 2000; 
        $total_tagihan = $jumlah_meter * $tarif_per_kwh;
        $status = 'Belum Bayar';

        $sql_tagihan = "INSERT INTO tagihan_listrik (user_id, bulan, tahun, jumlah_meter, tarif_per_kwh, total_tagihan, status)
            VALUES ('$user_id', '$bulan', '$tahun', '$jumlah_meter', '$tarif_per_kwh', '$total_tagihan', '$status')";

        if ($conn->query($sql_tagihan) === TRUE) {
            header('Location: ../pages/user');
            exit();
        } else {
            echo "Error: " . $sql_tagihan . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql_penggunaan . "<br>" . $conn->error;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Register House | Listriku</title>

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- user CSS -->
    <link rel="stylesheet" href="../assets/css/user.css">

    <!-- Vendor -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-200">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-sm bg-white rounded-lg shadow-md p-6">
            <div class="text-center">
                <h1 class="text-xl font-bold text-gray-800 mt-4">Register House</h1>
            </div>
            <form class="mt-6" id="register-house-form" method="post" action="register-house.php">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="bulan">
                        Bulan
                    </label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="bulan" name="bulan" required>
                        <option value="">Pilih Bulan</option>
                        <option value="januari">Januari</option>
                        <option value="februari">Februari</option>
                        <option value="maret">Maret</option>
                        <option value="april">April</option>
                        <option value="mei">Mei</option>
                        <option value="juni">Juni</option>
                        <option value="juli">Juli</option>
                        <option value="agustus">Agustus</option>
                        <option value="september">September</option>
                        <option value="oktober">Oktober</option>
                        <option value="november">November</option>
                        <option value="desember">Desember</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="tahun">
                        Tahun
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="tahun" type="number" placeholder="Tahun" name="tahun" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="meter_awal">
                        Meter Awal
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="meter_awal" type="number" placeholder="Meter Awal" name="meter_awal" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="meter_akhir">
                        Meter Akhir
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="meter_akhir" type="number" placeholder="Meter Akhir" name="meter_akhir" required>
                </div>

                <div class="mb-4"> <!-- Menambahkan input field untuk ukuran watt rumah -->
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="ukuran_watt">
                        Ukuran Watt
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="ukuran_watt" type="number" placeholder="Ukuran Watt" name="ukuran_watt" required>
                </div>

                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit" id="register-house-btn">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const registerBtn = document.getElementById('register-house-btn');

        registerBtn.addEventListener('click', function (e) {
            e.preventDefault(); 

            Swal.fire({
                icon: "success",
                title: "Selamat!",
                text: "Akun dan rumah Anda sudah terdaftar. Anda bisa login sekarang!",
                showCancelButton: false,
                confirmButtonText: "Ok",
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('register-house-form').submit();
                }
            });
        });

    </script>
</body>

</html>
