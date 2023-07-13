<?php
session_start();
include '../env/config.php';

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
    header('Location: ../auth/login.php');
    exit;
}

// Get all users
$users = getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Messages</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/admin.css" rel="stylesheet">
</head>

<body>
  <header id="header" class="header fixed-top flex items-center justify-between">

    <div class="flex items-center">
      <a class="logo flex items-center">
        <img src="../assets/images/logo.png" alt="logo">
        <span class="hidden lg:block"></span>
      </a>
    </div><!-- End Logo -->

    <div class="search-bar">
      <h1>Administrator Panel Listriku</h1>
    </div>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="index.html">
          <i class="bi bi-envelope"></i>
          <span>Messages</span>
        </a>
        <!-- End Tables Nav -->


        <li class="nav-heading">Pages</li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="users-profile.html">
            <i class="bi bi-person"></i>
            <span>Profile</span>
          </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" href="../env/logout.php">
            <i class="bi bi-box-arrow-in-left"></i>
            <span>Logout</span>
          </a>
        </li><!-- End Login Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left side columns -->
        <div class="lg:col-span-2">

          <!-- Message -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Messages</h5>
              <div class="overflow-auto max-h-96">
                <div class="message-box">
                  <div class="message-widget message-scroll">
                    <!-- Message -->
                    <table class="table-auto">
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
                          <td class="border px-4 py-2"><a class="edit-link" href="../env/edit_user.php?php echo $user['user_id']; ?>">Edit</a></td>
                          <td class="border px-4 py-2"><a class="delete-link" href="../edelete_user.php?id=<?php echo $user['user_id']; ?>">Delete</a></td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Top Selling -->

      </div><!-- End Left side columns -->

      <!-- Right side columns -->
      <div class="lg:col-span-1"></div><!-- End News & Updates -->

      </div><!-- End Right side columns -->
      </div>
    </section>

  </main><!-- End #main -->
</body>

</html>

