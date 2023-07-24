<?php
include("config.php");
?>


<?php
//fungsi untuk mendapatkan status pemabayarn bulan terakhir
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
//fungsi untuk mengambil user dari database
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
//fungsi untuk mengidentifikasi login berdasarkan privilege 'Admin' dan 'Pengguna'
function isUserPage() {
    return isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'Pelanggan';
}

function isAdminPage() {
    return isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'Admin';
}

//fungsi untuk membuat chart penggunaan listrik
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

 //fungsi untuk menampilkan penggunaan listrik
function displayElectricityUsage($penggunaan_listrik) {
    if (empty($penggunaan_listrik)) {
        echo '<tr><td colspan="5">No data available</td></tr>';
    } else {
        foreach ($penggunaan_listrik as $index => $penggunaan) {
            echo '<tr>';
            echo '<td class="border px-4 py-2">' . ($index + 1) . '</td>';
            echo '<td class="border px-4 py-2">' . $penggunaan['bulan'] . '</td>';
            echo '<td class="border px-4 py-2">' . $penggunaan['tahun'] . '</td>';
            echo '<td class="border px-4 py-2">' . $penggunaan['meter_awal'] . '</td>';
            echo '<td class="border px-4 py-2">' . $penggunaan['meter_akhir'] . '</td>';
            echo '</tr>';
        }
    }
}

//fungsi untuk mengambil data penggunaan listrik
function getPenggunaanListrik($user_id) {
    global $conn;
    $query = "SELECT * FROM penggunaan_listrik WHERE user_id='$user_id' ORDER BY tahun DESC, FIELD(bulan, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec')";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

//fungsi untuk mengambil data tagihan listrik berdasarkan user_id
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
        $query = "UPDATE tagihan_listrik SET status='Sudah Bayar' WHERE id='$payment_id'";
        mysqli_query($conn, $query);
    }

    function getLastMonthUsage($user_id) {
        global $conn;
        $query = "SELECT * FROM penggunaan_listrik WHERE user_id='$user_id' ORDER BY tahun DESC, FIELD(bulan, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec') LIMIT 1";
        $result = mysqli_query($conn, $query);
        return mysqli_fetch_assoc($result);
    }
    
    //fungsi untuk membuat tagihan tagihan

    function createTagihan($user_id) {
        global $conn;
    
        // Ambil data terakhir tagihan untuk pengguna ini
        $query = "SELECT * FROM tagihan_listrik WHERE user_id='$user_id' ORDER BY tahun DESC, bulan DESC LIMIT 1";
        $result = mysqli_query($conn, $query);
        $lastTagihan = mysqli_fetch_assoc($result);
    
        // Ambil data penggunaan listrik terakhir untuk pengguna ini
        $query = "SELECT * FROM penggunaan_listrik WHERE user_id='$user_id' ORDER BY tahun DESC, bulan DESC LIMIT 1";
        $result = mysqli_query($conn, $query);
        $lastPenggunaan = mysqli_fetch_assoc($result);
    
        // Cek apakah data penggunaan listrik terakhir sudah ada
        if (!$lastPenggunaan) {
            // Jika tidak ada data penggunaan listrik terakhir, berikan pesan kesalahan
            return "Data penggunaan listrik untuk pengguna ini belum tersedia. Tidak dapat melakukan tagihan otomatis.";
        }
    
        // Hitung total tagihan berdasarkan pemakaian listrik terakhir dan tarif per kwh
        $jumlah_meter = $lastPenggunaan['meter_akhir'] - $lastPenggunaan['meter_awal'];
        $tarif_per_kwh = 2000;
        $total_tagihan = $jumlah_meter * $tarif_per_kwh;
    
        // Cek apakah pengguna sudah membayar tagihan sebelumnya
        if ($lastTagihan && $lastTagihan['status'] === 'Belum Bayar') {
            // Jika pengguna belum membayar tagihan sebelumnya, berikan pesan kesalahan
            return "Pengguna ini masih memiliki tagihan yang belum dibayar. Tidak dapat melakukan tagihan otomatis.";
        }
    
        // Insert data tagihan listrik ke tabel
        $bulan = date('F');
        $tahun = date('Y');
        $sql_insert = "INSERT INTO tagihan_listrik (user_id, bulan, tahun, jumlah_meter, tarif_per_kwh, total_tagihan, status)
                       VALUES ('$user_id', '$bulan', '$tahun', '$jumlah_meter', '$tarif_per_kwh', '$total_tagihan', 'Belum Bayar')";
    
        if ($conn->query($sql_insert) === TRUE) {
            // Berhasil membuat tagihan otomatis
            return "Tagihan otomatis berhasil dibuat.";
        } else {
            // Gagal membuat tagihan otomatis
            return "Gagal membuat tagihan otomatis: " . $conn->error;
        }
    }

    // fungsi filtering berdasarkan status pembayaran
    function getFilteredUsers($status)
{
    global $users;

    if ($status === 'Sudah Bayar') {
        return array_filter($users, function ($user) {
            return getStatusPembayaran($user['user_id']) === 'Sudah Bayar';
        });
    } elseif ($status === 'Belum Bayar') {
        return array_filter($users, function ($user) {
            return getStatusPembayaran($user['user_id']) === 'Belum Bayar';
        });
    }

    return $users; // Return all users by default
}


//untuk fetch post
function getPostsFromDatabase() {
    global $conn; // Assuming you already have a database connection

    $query = "SELECT * FROM blog_posts ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error fetching blog posts: " . mysqli_error($conn));
    }

    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $posts;
}
    

function getBlogPostsFromDatabase() {
    global $conn;
    $query = "SELECT * FROM blog_posts ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);

    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        echo "Failed to fetch blog posts: " . mysqli_error($conn);
        return [];
    }
}

//BLOG SECTION
// Fungsi untuk mendapatkan data postingan dari database berdasarkan ID
function getBlogPostById($post_id) {
    global $conn;
    $query = "SELECT * FROM blog_posts WHERE id='$post_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        return mysqli_fetch_assoc($result);
    } else {
        echo "Failed to fetch blog post: " . mysqli_error($conn);
        return null;
    }
}

// Fungsi untuk mendapatkan daftar postingan berdasarkan bulan dari database
function getBlogPostsByMonth() {
    global $conn;
    $query = "SELECT id, title, created_at FROM blog_posts ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $blogPostsByMonth = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $date = date_create($row['created_at']);
            $monthYear = date_format($date, 'F Y');
            $blogPostsByMonth[$monthYear][] = $row;
        }
        return $blogPostsByMonth;
    } else {
        echo "Failed to fetch blog posts: " . mysqli_error($conn);
        return [];
    }
}

//HALAMAN ADMIN
function getAllUsers() {
    global $conn;
    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getTagihanTotal($user_id) {
    global $conn;
    $query = "SELECT SUM(total_tagihan) AS total FROM tagihan_listrik WHERE user_id='$user_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function getStatusPembayaran($user_id) {
    global $conn;
    $query = "SELECT status FROM tagihan_listrik WHERE user_id='$user_id' ORDER BY tahun DESC, bulan DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['status'];
}
    ?>



