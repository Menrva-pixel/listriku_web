<?php
session_start();

// Periksa apakah pengguna sudah login
if (isset($_SESSION['username'])) {
  // Pengguna sudah login, dapatkan nama pengguna dari session
  $username = $_SESSION['username'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listriku</title>
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar z-50 sticky top-0 flex items-center justify-around bg-transparent text-white p-2">
    <div class="flex items-center">
      <img src="assets/images/logo.png" alt="Brand-Logo" class="h-10 w-15 mr-2">
    </div>
    <div>
      <a href="#" class="text-white hover:text-gray-400 mx-2">Home</a>
      <a href="#" class="text-white hover:text-gray-400 mx-2">About</a>
      <?php if (isset($username)) : ?>
        <!-- Pengguna sudah login, tampilkan nama pengguna -->
        <a href="pages/user" class="text-yellow-400 font-bold mx-2"><i class="fa-regular fa-user yellow-400 mr-2"></i><?php echo $username; ?></a>
      <?php else : ?>
        <!-- Pengguna belum login, tampilkan opsi login -->
        <a href="auth/login" class="text-black bg-yellow-400 p-3 rounded-3xl mx-2 transform hover:scale-75">Log-in <i class="fa-solid fa-right-to-bracket"></i></a>
      <?php endif; ?>
    </div>
  </nav>

  <!-- Hero section -->
  <section class="z-0 bg-transparent h-96 m-20" data-aos="fade-up" data-aos-duration="2000">
    <div class="container mx-auto mt-56 text-center">
      <h1 class="z-10 text-white font-bold text-5xl md:text-6xl xl:text-7xl">Selamat Datang</h1>
      <p class="mt-8 text-gray-400 dark:text-gray-300">Kami membantu anda untuk melakukan pembayaran <a class="text-yellow-400">listrik </a>bulanan tanpa harus keluar rumah</p>
    </div>
  </section>


  <!-- Company Information section -->
  <section class="bg-transparent p-16 overflow-hidden">
    <div class="container mx-auto">
      <div class="flex items-center justify-center">
        <div class="w-1/2">
          <img src="assets/images/slider-dec.png" alt="Company Image" class="mb-5 h-25 w-25" data-aos="fade-right" data-aos-duration="1000">
        </div>
        <div class="w-1/2" data-aos="fade-left" data-aos-duration="1000">
          <h2 class="text-white text-4xl font-bold mb-4">LISTRIKU</h2>
          <p class="text-gray-400 text-lg mb-2 text-justify">Kami dengan bangga menyajikan platform yang menyediakan berbagai fitur untuk mempermudah Anda dalam melakukan pembayaran dan pengecekan penggunaan listrik bulanan.</p>
          <p class="text-gray-400 text-lg text-justify">Kami berkomitmen untuk memberikan pengalaman yang nyaman dan mudah bagi Anda dalam menggunakan layanan listrik kami. Silakan kunjungi platform kami atau hubungi layanan pelanggan kami untuk menikmati berbagai fitur dan kemudahan yang kami tawarkan.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Additional Information section -->
  <hr class="w-1/2 h-1 mx-auto bg-gray-400 border-0 rounded md:my-10 dark:bg-gray-700">
  <section class="py-8 m-0 border-y border-gray-100 dark:border-gray-800 sm:flex justify-between">
    <div class="container mx-auto">
      <div class="grid grid-cols-3 gap-x-44 mx-auto w-1/2">
        <div class="p-4">
          <h2 class="text-2xl font-bold mb-4">Mudah</h2>
          <p>User Friendly</p>
        </div>
        <div class="p-4">
          <h2 class="text-2xl font-bold mb-4">Cepat</h2>
          <p>Penanganan Cepat</p>
        </div>
        <div class="p-4">
          <h2 class="text-2xl font-bold mb-4">Lengkap</h2>
          <p>Fitur Lengkap</p>
        </div>
      </div>
    </div>
  </section>
  <hr class="w-1/2 h-1 mx-auto bg-gray-400 border-0 rounded md:my-10 dark:bg-gray-700">

  <!-- Additional features section -->
  <section class="py-16">
    <div class="container mx-auto">
      <div class="grid grid-cols-2 gap-8">
        <div class="p-4 flex flex-row items-center gap-10">
        <img src="assets/images/assets-2.png" class="w-auto h-48">
          <div class="flex flex-col">
            <h2 class="text-2xl font-bold mb-4 text-white">Laporan</h2>
            <p class="text-gray-400 text-justify">Kami meyediakan layanan untuk melaporkan gangguan kelistrikan di wilayah anda, petugas akan dengan
              segera datang untuk memperbaiki gangguan yang anda alami.</p>
          </div>
        </div>
        <div class="p-4 flex flex-row items-center gap-10">
        <img src="assets/images/assets-1.png" class="w-auto h-48">
          <div class="flex flex-col">
            <h2 class="text-2xl font-bold mb-4 text-white">Pembayaran</h2>
            <p class="text-gray-400 text-justify">Lakukan Pembayaran dengan mudah tanpa keluar rumah! website kami membantu anda melakukan pengecekan penggunaan listrik
              dan juga biaya bulan. Bayar mudah gak pake ribet!
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-6">
    <div class="container mx-auto flex items-center justify-between">
      <div>
        <img src="assets/images/slider-dec.png" alt="Logo" class="h-20 w-auto mr-2 flex ">
        <span class="font-bold text-center ml-1">LISTRIKU</span>
      </div>
      <div>
        <p class="text-gray-400">Contact us: bherdyanto26@gmail.com</p>
      </div>
    </div>
    <div class="container mx-auto px-4">
    <div class="flex justify-center items-center">
      <p class="text-gray-500 text-sm">&copy; 2023 Barkah Herdyanto S. All rights reserved.</p>
    </div>
  </footer>
  <script src="assets/js/script.js"></script>
</body>


</html>
