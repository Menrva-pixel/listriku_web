<?php
include("config.php");
?>


<?php
function getStatusPembayaranBulanTerakhir() {
    global $conn;

    $bulan_terakhir = date('M');
    $tahun_terakhir = date('Y');

    $sql = "SELECT status FROM tagihan_listrik WHERE bulan='$bulan_terakhir' AND tahun='$tahun_terakhir'";
    $query = mysqli_query($conn, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $status_pembayaran = $row['status'];
        return $status_pembayaran;
    } else {
        return "Belum ada data pembayaran bulan terakhir";
    }
}

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

function chartPenggunaanListrik() {
    global $conn;

    $query = "SELECT * FROM penggunaan_listrik ORDER BY tahun, FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $data;
    }
    
    return [];
}

function getPenggunaanListrik($user_id) {
    global $conn;
    $query = "SELECT * FROM penggunaan_listrik WHERE user_id='$user_id' ORDER BY tahun DESC, FIELD(bulan, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec')";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getTagihanListrik($user_id) {
    global $conn;
    $query = "SELECT * FROM tagihan_listrik WHERE user_id='$user_id' ORDER BY tahun DESC, FIELD(bulan, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec')";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

    //fungsi pembayaran
    function getPaymentById($payment_id) {
        global $conn;

        $query = "SELECT * FROM tagihan_listrik WHERE id='$payment_id'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $payment = mysqli_fetch_assoc($result);
            return $payment;
        }

        return null;
    }

    // Fungsi untuk menyelesaikan proses pembayaran
    function completePayment($payment_id) {
        global $conn;

        // Update status pembayaran menjadi "Lunas"
        $query = "UPDATE tagihan_listrik SET status='Lunas' WHERE id='$payment_id'";
        mysqli_query($conn, $query);
    }

    function getLastMonthUsage($user_id) {
        global $conn;
        $query = "SELECT * FROM penggunaan_listrik WHERE user_id='$user_id' ORDER BY tahun DESC, FIELD(bulan, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec') LIMIT 1";
        $result = mysqli_query($conn, $query);
        return mysqli_fetch_assoc($result);
    }
    
    function updatePaymentStatus($payment_id, $status) {
        global $conn;
        $query = "UPDATE tagihan_listrik SET status='$status' WHERE id='$payment_id'";
        mysqli_query($conn, $query);
    }

?>


