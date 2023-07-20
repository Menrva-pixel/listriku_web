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
    <nav>
      <div class="flex flex-row justify-between items-center bg-transparent">
        <div class="ml-24">
          <a href="../index">
            <img class="h-12 w-24" src="../assets/images/logo.png" alt="Logo">
          </a>
        </div>
        <div class="mr-24">
          <ul class="flex space-x-4">
            <li>                   
               <form method="GET" action="../auth/logout">
                  <button type="submit" name="logout" class="bg-transparent border hover:bg-red-700 text-gray-200 font-bold py-2 px-4 rounded">Logout</button>
               </form>
            </li>
          </ul>
        </div>
      </div>
    </nav>


    <!-- Content -->
    <div class="container mx-auto p-4 mt-4 flex flex-row items-start">
        <!-- Charts -->
        <div class="flex flex-col justify-center md:grid-cols-2 gap-4 h-full w-full">
            <!-- Chart 1: Data Penggunaan Listrik -->
            <div class=" p-4 border rounded-md shadow-lg">
                <h2 class="text-xl font-bold mb-4 text-gray-300">Data Penggunaan Listrik</h2>
                <canvas id="chart1"></canvas>
            </div>
            <!-- Chart 2: Data Jumlah Pengguna -->
            <div class="border rounded-md p-4 shadow-lg">
                <h2 class="text-xl font-bold mb-4 text-gray-300">Data Pemakaian listrik</h2>
                <canvas id="chart2"></canvas>
            </div>
        </div>

        <!-- Table -->
            <section class="bg-transparent p-3 sm:p-5 mt-1">
            <h1 class="text-center text-gray-200 m-4 text-4xl">TABLE PENGGUNA</h1>
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <div class="bg-gray-800 dark:bg-gray-800 relative shadow-md sm:rounded-lg">
                    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                        <div class="w-full md:w-1/2">
                            <form class="flex items-center">
                                <label for="simple-search" class="sr-only">Search</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search" required="">
                                </div>
                            </form>
                        </div>
                        <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                            <div class="flex items-center space-x-3 w-full md:w-auto">
                                <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-200 focus:outline-none  rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                    Actions
                                </button>
                                <div id="actionsDropdown" class="hidden z-10 w-44  rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                                        <li>
                                            <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mass Edit</a>
                                        </li>
                                    </ul>
                                    <div class="py-1">
                                        <a href="#" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete all</a>
                                    </div>
                                </div>
                                <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-200 focus:outline-none  rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button" data-filter="">
                                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                    </svg>
                                    Filter
                                    <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="">
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
                                <?php foreach ($users as $index => $user): ?>
                                    <tr class="dark:border-gray-700 overflow-y-scroll">
                                        <td class="px-4 py-3"><?php echo $index + 1; ?></td>
                                        <td class="px-4 py-3"><?php echo $user['username']; ?></td>
                                        <td class="px-4 py-3"><?php echo getTagihanTotal($user['user_id']); ?></td>
                                        <td class="px-4 py-3 <?php echo getStatusPembayaran($user['user_id']) === 'Belum Bayar' ? 'status-belum-bayar' : 'status-sudah-bayar'; ?>">
                                            <?php echo getStatusPembayaran($user['user_id']); ?>
                                        </td>
                                        <td class="px-4 py-2">
                                            <form method="post" action="">
                                                <input type="hidden" name="tagih_user" value="<?php echo $user['user_id']; ?>">
                                                <button type="submit" class="tagih-link hover:text-green-400">Tagih</button>
                                            </form>
                                        </td>
                                        <td class="px-4 py-2">
                                            <a class="delete-link hover:text-red-400" href="#" data-userid="<?php echo $user['user_id']; ?>">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                </div>
            </div>
            </section>
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


