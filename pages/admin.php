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

//untuk chart penggunaan listrik dan jumlah pengguna
$sqlPenggunaanListrik = "SELECT user_id, meter_awal, meter_akhir FROM penggunaan_listrik";
$resultPenggunaanListrik = $conn->query($sqlPenggunaanListrik);

// Inisialisasi array untuk menyimpan data meter_awal dan meter_akhir
$usersDataMeterAwal = array();
$usersDataMeterAkhir = array();

if ($resultPenggunaanListrik->num_rows > 0) {
    while ($row = $resultPenggunaanListrik->fetch_assoc()) {
        $user_id = $row['user_id'];
        $usersDataMeterAwal[$user_id][] = $row['meter_awal'];
        $usersDataMeterAkhir[$user_id][] = $row['meter_akhir'];
    }
}

// Calculate total electricity usage for each user
$usersDataJumlahPengguna = array();
foreach ($users as $user) {
    $user_id = $user['user_id'];
    $total_penggunaan = array_sum($usersDataMeterAkhir[$user_id]) - array_sum($usersDataMeterAwal[$user_id]);
    $usersDataJumlahPengguna[] = array(
        'user_id' => $user_id,
        'username' => $user['username'],
        'total_penggunaan' => $total_penggunaan,
    );
}

$posts = getBlogPostsFromDatabase();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Listriku</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-200">
    <!-- Navbar -->
    <nav class="bg-blue-500 py-4 px-8">
        <div class="container mx-auto flex items-center justify-between">
            <a href="../index">
                <img class="h-12 w-24" src="../assets/images/logo.png" alt="Logo">
            </a>
            <form method="GET" action="../auth/logout">
                <button type="submit" name="logout" class="bg-transparent border hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Logout</button>
            </form>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mx-auto p-4 mt-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Chart 1: Data Penggunaan Listrik -->
            <div class="p-4 border rounded-md shadow-lg bg-white">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Data Penggunaan Listrik</h2>
                <canvas id="chart1"></canvas>
            </div>

            <!-- Chart 2: Data Jumlah Pengguna -->
            <div class="p-4 border rounded-md shadow-lg bg-white">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Data Pemakaian Listrik</h2>
                <canvas id="chart2"></canvas>
            </div>
        </div>

        <div class="mt-4">
            <a href="create_post.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buat Postingan Blog</a>
        </div>

        <!-- Table: Pengguna -->
        <section class="bg-white p-4 mt-4 rounded-md shadow-lg">
    <h1 class="text-center text-gray-700 m-4 text-4xl">Table Pengguna</h1>
    <div class="table-container mx-auto max-w-screen-xl px-4 lg:px-12">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" data-sort="status" data-order="asc" id="user-table">
            <thead class="text-xs text-gray-400 font-semibold uppercase bg-gray-600 dark:bg-gray-700 dark:text-gray-400 text-center">
                <tr>
                    <th scope="col" class="px-4 py-3">No.</th>
                    <th scope="col" class="px-4 py-3">Username</th>
                    <th scope="col" class="px-4 py-3">Total Tagihan</th>
                    <th scope="col" class="px-4 py-3" data-sortable>Status Pembayaran</th>
                    <th scope="col" class="px-4 py-3">Edit</th>
                    <th scope="col" class="px-4 py-3">Delete</th>
                    <th scope="col" class="px-4 py-3">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody id="table-body" class="text-center max-h-2 overflow-y-scroll">
                <!-- Replace this with PHP code to generate the table rows dynamically -->
                <?php
                foreach ($users as $index => $user) {
                    echo '<tr class="dark:border-gray-700 overflow-y-scroll">';
                    echo '<td class="px-4 py-3">' . ($index + 1) . '</td>';
                    echo '<td class="px-4 py-3">' . $user['username'] . '</td>';
                    echo '<td class="px-4 py-3">' . getTagihanTotal($user['user_id']) . '</td>';
                    echo '<td class="px-4 py-3 ' . (getStatusPembayaran($user['user_id']) === 'Belum Bayar' ? 'status-belum-bayar' : 'status-sudah-bayar') . '">';
                    echo getStatusPembayaran($user['user_id']);
                    echo '</td>';
                    echo '<td class="px-4 py-2">';
                    echo '<form method="post" action="">';
                    echo '<input type="hidden" name="tagih_user" value="' . $user['user_id'] . '">';
                    echo '<button type="submit" class="tagih-link hover:text-green-400">Tagih</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '<td class="px-4 py-2">';
                    echo '<a class="delete-link hover:text-red-400" href="#" data-userid="' . $user['user_id'] . '">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</section>
        <!-- Blog Posts -->
        <div class="mt-4">
            <h1 class="text-center text-gray-700 m-4 text-4xl">Blog Posts</h1>
            <div class="blog-posts">
                <!-- Replace this with PHP code to generate the blog posts dynamically -->
                <?php
                foreach ($posts as $post) {
                    echo '<div class="blog-post border rounded p-4 mb-4">';
                    echo '<h2 class="text-2xl font-semibold">' . $post['title'] . '</h2>';
                    echo '<p class="text-gray-600 mb-2">Posted by ' . $post['author'] . ' on ' . $post['created_at'] . '</p>';
                    echo '<p>' . $post['content'] . '</p>';
                    echo '<div class="mt-2">';
                    echo '<a href="edit_post.php?id=' . $post['id'] . '" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>';
                    echo '<a href="delete_post.php?id=' . $post['id'] . '" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</a>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
                  <!-- Button to create a new blog post -->
            <div class="flex justify-center">
                <a href="create_post.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Buat Postingan Baru</a>
            </div>
        </div>

    </div>

    <footer class="p-4 bg-gray-800 md:p-8 lg:p-10 dark:bg-gray-800">
        <div class="mx-auto max-w-screen-xl text-center">
            <a href="#" class="flex justify-center items-center text-4xl font-bold text-yellow-300 dark:text-white">
                <img class="mr-2 h-12" src="../assets/images/slider-dec.png">
                Listriku   
            </a>
            <p class="my-6 text-gray-500 dark:text-gray-400">Administrator Page</p>
        </div>
        </footer>
        <div class="bg-gray-800 copyright-container py-6">
            <div class="flex justify-center ml-4">
            <p class="text-gray-400 font-semibold text-sm">&copy; 2023 Listriku. All rights reserved.</p>
            </div>
        </div>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="module" src="../assets/js/script.js"></script>

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

          // render the chart
          const ctx1 = document.getElementById('chart1').getContext('2d');
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: labelsPenggunaanListrik,
                    datasets: [{
                        label: 'Penggunaan Listrik (watt)',
                        data: dataPenggunaanListrik,
                        backgroundColor: 'rgba(20, 145, 255, 1)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
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
    const labelsUsersJumlahPengguna = <?php echo json_encode(array_column($usersDataJumlahPengguna, 'username')); ?>;
    const dataUsersJumlahPengguna = <?php echo json_encode(array_column($usersDataJumlahPengguna, 'total_penggunaan')); ?>;

    // chart render
    const ctx2 = document.getElementById('chart2').getContext('2d');
    new Chart(ctx2, {
        type: 'pie', // Change chart type to pie
        data: {
            labels: labelsUsersJumlahPengguna,
            datasets: [{
                data: dataUsersJumlahPengguna,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                ],
                borderWidth: 2,
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom', // Adjust legend position as needed
                },
            },
            animation: {
                tension: {
                    duration: 2000,
                    easing: 'linear',
                    from: 1,
                    to: 0,
                    loop: true,
                },
            },
        },
    });
    //sweetaler2 untuk konfirmasi delete user
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


    document.addEventListener("DOMContentLoaded", function () {
    // Elements
    const searchInput = document.getElementById("simple-search");
    const tableBody = document.querySelector("tbody");

    // Function to filter rows based on search input
    function filterRows() {
      const searchText = searchInput.value.trim().toLowerCase();
      const rows = tableBody.querySelectorAll("tr");

      rows.forEach((row) => {
        const usernameCell = row.querySelector("td:nth-child(2)");
        const statusCell = row.querySelector("td:nth-child(4)");
        const username = usernameCell.textContent.toLowerCase();
        const status = statusCell.textContent.toLowerCase();

        if (
          username.includes(searchText) ||
          status.includes(searchText)
        ) {
          row.style.display = "table-row";
        } else {
          row.style.display = "none";
        }
      });
    }

    // Event listener for search input
    searchInput.addEventListener("input", filterRows);

    // Function to sort rows based on status (Sudah Bayar / Belum Bayar)
    function sortRows() {
      const rows = Array.from(tableBody.querySelectorAll("tr"));

      rows.sort((rowA, rowB) => {
        const statusA = rowA.querySelector("td:nth-child(4)").textContent;
        const statusB = rowB.querySelector("td:nth-child(4)").textContent;

        if (statusA === "Sudah Bayar") {
          return -1;
        } else if (statusB === "Sudah Bayar") {
          return 1;
        } else {
          return 0;
        }
      });

      // Remove existing rows from the table
      rows.forEach((row) => {
        row.remove();
      });

      // Append sorted rows to the table
      rows.forEach((row) => {
        tableBody.appendChild(row);
      });
    }

    // Call the sortRows function initially to sort the rows
    sortRows();
  });

  // sorting

    document.addEventListener("DOMContentLoaded", function () {
        // Function to update the filter button text and filter the table rows
        function filterTableRows(filterStatus) {
            const filterButton = document.getElementById("filterDropdownButton");
            filterButton.dataset.filter = filterStatus;
            filterButton.textContent = filterStatus === "Sudah Bayar" ? "Sudah Bayar" : "Belum Bayar";

            updateTableRows(filterStatus);
        }

        // Event listener for the "Filter" button
        const filterButton = document.getElementById("filterDropdownButton");
        filterButton.addEventListener("click", function () {
            const currentFilter = filterButton.dataset.filter;
            const newFilter = currentFilter === "Sudah Bayar" ? "Belum Bayar" : "Sudah Bayar";
            filterTableRows(newFilter);
        });
    });
</script>
</body>

</html>


