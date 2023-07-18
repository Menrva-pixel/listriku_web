<?php
session_start();
include '../env/config.php';
include '../env/func.php';

if (!isset($_SESSION['username']) || !isAdminPage()) {
  header('Location: ../auth/login');
  exit;
}

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

// Redirect to login page if not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['privilege'] !== 'Admin') {
    header('Location: ../auth/login');
    exit;
}
// Get all users
$users = getAllUsers();


// Ambil data dari tabel users
$sqlUsers = "SELECT * FROM users";
$resultUsers = $conn->query($sqlUsers);

// Inisialisasi array untuk menyimpan data users
$usersDataJumlahPengguna = array();

if ($resultUsers->num_rows > 0) {
    while ($row = $resultUsers->fetch_assoc()) {
        $usersDataJumlahPengguna[] = $row;
    }
}


$sqlPenggunaanListrik = "SELECT * FROM penggunaan_listrik";
$resultPenggunaanListrik = $conn->query($sqlPenggunaanListrik);

// Inisialisasi array untuk menyimpan data penggunaan_listrik
$penggunaanListrikData = array();

if ($resultPenggunaanListrik->num_rows > 0) {
    while ($row = $resultPenggunaanListrik->fetch_assoc()) {
        $penggunaanListrikData[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Listriku</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/user.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-200">
    <!-- Navbar -->
    <nav>
      <div class="flex flex-row justify-between items-center bg-gray-400">
        <div class="ml-24">
          <a href="../index">
            <img class="h-12 w-24" src="../assets/images/logo.png" alt="Logo">
          </a>
        </div>
        <div class="mr-24">
          <ul class="flex space-x-4">
            <li>                   
               <form method="GET" action="../auth/logout">
                  <button type="submit" name="logout" class="bg-transparent border hover:bg-red-700 text-black font-bold py-2 px-4 rounded">Logout</button>
               </form>
            </li>
          </ul>
        </div>
      </div>
    </nav>


    <!-- Content -->
    <div class="container mx-auto p-4 mt-4">
        <!-- Charts -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Chart 1: Data Penggunaan Listrik -->
            <div class="bg-white p-4 shadow-lg">
                <h2 class="text-xl font-bold mb-4">Data Penggunaan Listrik</h2>
                <canvas id="chart1"></canvas>
            </div>
            <!-- Chart 2: Data Jumlah Pengguna -->
            <div class="bg-white p-4 shadow-lg">
                <h2 class="text-xl font-bold mb-4">Data Jumlah Pengguna</h2>
                <canvas id="chart2"></canvas>
            </div>
        </div>

        <!-- Table -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Data Pengguna</h2>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Username</th>
                        <th class="px-4 py-2">Total Tagihan</th>
                        <th class="px-4 py-2">Status Pembayaran</th>
                        <th class="px-4 py-2">Edit</th>
                        <th class="px-4 py-2">Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $index => $user): ?>
                          <tr>
                            <td class="border px-4 py-2"><?php echo $index + 1; ?></td>
                            <td class="border px-4 py-2"><?php echo $user['username']; ?></td>
                            <td class="border px-4 py-2"><?php echo getTagihanTotal($user['user_id']); ?></td>
                            <td class="border px-4 py-2 <?php echo getStatusPembayaran($user['user_id']) === 'Belum Bayar' ? 'status-belum-bayar' : 'status-sudah-bayar'; ?>">
                                <?php echo getStatusPembayaran($user['user_id']); ?>
                            </td>
                            <td class="border px-4 py-2">
                            <form method="post" action="">
                                <input type="hidden" name="tagih_user" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" class="tagih-link">Tagih</button>
                            </form>
                            </td>
                            <td class="border px-4 py-2">
                                <a class="delete-link" href="#" data-userid="<?php echo $user['user_id']; ?>">Delete</a>
                            </td>

                        </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      // Mengambil data yang diperlukan dari $penggunaanListrikData
      const labelsPenggunaanListrik = <?php echo json_encode(array_column($penggunaanListrikData, 'bulan')); ?>;
          const dataPenggunaanListrik = <?php echo json_encode(array_column($penggunaanListrikData, 'watt')); ?>;

          // Chart configuration options (customize as needed)
          const chartOptions = {
              responsive: false,
              maintainAspectRatio: false,
              scales: {
                  y: {
                      beginAtZero: true,
                  }
              }
          };

          // Create and render the chart
          const ctx1 = document.getElementById('chart1').getContext('2d');
          new Chart(ctx1, {
              type: 'line',
              data: {
                  labels: labelsPenggunaanListrik,
                  datasets: [{
                      label: 'Penggunaan Listrik (watt)',
                      data: dataPenggunaanListrik,
                      backgroundColor: 'rgba(255, 99, 132, 0.5)',
                      borderColor: 'rgba(255, 99, 132, 1)',
                      borderWidth: 1,
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
    // Mengambil data yang diperlukan dari $usersDataJumlahPengguna
    const labelsUsersJumlahPengguna = <?php echo json_encode(array_column($usersDataJumlahPengguna, 'username')); ?>;
    const dataUsersJumlahPengguna = <?php echo json_encode(array_column($usersDataJumlahPengguna, 'no_telp')); ?>;

    // Create and render the chart
    const ctx2 = document.getElementById('chart2').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: labelsUsersJumlahPengguna,
            datasets: [{
                label: 'Jumlah Pengguna',
                data: dataUsersJumlahPengguna,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
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
    const deleteLinks = document.querySelectorAll('.delete-link');

    deleteLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const userId = this.dataset.userid;

            Swal.fire({
                icon: 'warning',
                title: 'Apakah Anda yakin?',
                text: 'Data user akan dihapus permanen!',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`../env/delete_user.php?id=${userId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Data berhasil dihapus!',
                                }).then(() => {
                                    window.location.href = '../pages/admin';
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.message,
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menghapus data.',
                            });
                        });
                }
            });
        });
    });
</script>
</body>

</html>


