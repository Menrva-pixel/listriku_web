<?php
include("config.php");

function getStatusPembayaran() {
    global $conn;

    // Mendapatkan bulan terakhir
    $bulan_terakhir = date('n') - 1; // Mengurangi 1 bulan dari bulan saat ini
    $tahun_terakhir = date('Y');

    // Mengambil status pembayaran terbaru sesuai bulan terakhir
    $sql = "SELECT status FROM Pembayaran WHERE month = $bulan_terakhir AND year = $tahun_terakhir ORDER BY payment_id DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            $status_pembayaran = $row['status'];
            return $status_pembayaran;
        } else {
            return "Belum ada pembayaran";
        }
    } else {
        return "Terjadi kesalahan dalam mengambil status pembayaran";
    }
}
?>
