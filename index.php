<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar sticky top-0 flex items-center justify-around bg-transparent text-white p-6">
    <div class="flex items-center">
      <img src="assets/images/logo.png" alt="Brand-Logo" class="h-10 w-15 mr-2">
    </div>
    <div>
      <a href="#" class="text-white hover:text-gray-400 mx-2">Home</a>
      <a href="#" class="text-white hover:text-gray-400 mx-2">About</a>
      <a href="#" class="text-white hover:text-gray-400 mx-2">Login</a>
    </div>
  </nav>

  <!-- Hero section -->
  <section class="bg-transparent h-96 m-20">
    <div class="container mx-auto mt-56 text-center">
      <h1 class="text-white font-bold text-5xl md:text-6xl xl:text-7xl">Selamat Datang</h1>
      <p class="mt-8 text-gray-400 dark:text-gray-300">Website kami membantu anda untuk melakukan pembayaran listrik bulanan tanpa harus keluar rumah</p>
    </div>
  </section>

  <!-- Company Information section -->
  <section class="bg-transparent py-16">
    <div class="container mx-auto">
      <div class="flex items-center justify-center">
        <div class="w-1/2">
          <img src="assets/images/slider-dec.png" alt="Company Image" class="mb-5 h-25 w-25">
        </div>
        <div class="w-1/2">
          <h2 class="text-white text-4xl font-bold mb-4">LISTRIKU</h2>
          <p class="text-gray-400 text-lg mb-6 text-justify">Kami dengan bangga menyajikan platform yang menyediakan berbagai fitur untuk mempermudah Anda dalam melakukan pembayaran dan pengecekan penggunaan listrik bulanan.</p>
          <p class="text-gray-400 text-lg text-justify">Kami berkomitmen untuk memberikan pengalaman yang nyaman dan mudah bagi Anda dalam menggunakan layanan listrik kami. Silakan kunjungi platform kami atau hubungi layanan pelanggan kami untuk menikmati berbagai fitur dan kemudahan yang kami tawarkan.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Additional features section -->
  <section class="py-16">
    <div class="container mx-auto">
      <div class="grid grid-cols-2 gap-8">
        <div class="p-4 flex flex-row items-center gap-10">
        <img src="assets/images/service-1.jpg" class="w-auto h-48">
          <div class="flex flex-col">
            <h2 class="text-2xl font-bold mb-4 text-white">Laporan</h2>
            <p class="text-gray-400 text-justify">Kami meyediakan layanan untuk melaporkan gangguan kelistrikan di wilayah anda, petugas akan dengan
              segera datang untuk memperbaiki gangguan yang anda alami.</p>
          </div>
        </div>
        <div class="p-4 flex flex-row items-center gap-10">
        <img src="assets/images/service-1.jpg" class="w-auto h-48">
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

  <!-- Additional Information section -->
  <hr class="w-1/2 h-1 mx-auto bg-gray-400 border-0 rounded md:my-10 dark:bg-gray-700">
  <section class="py-8 m-0 border-y border-gray-100 dark:border-gray-800 sm:flex justify-between">
    <div class="container mx-auto">
      <div class="grid grid-cols-3 gap-x-44 mx-auto w-1/2">
        <div class="p-4">
          <h2 class="text-2xl font-bold mb-4">Mudah</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac leo pretium, pulvinar lectus a, vulputate elit.</p>
        </div>
        <div class="p-4">
          <h2 class="text-2xl font-bold mb-4">Cepat</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac leo pretium, pulvinar lectus a, vulputate elit.</p>
        </div>
        <div class="p-4">
          <h2 class="text-2xl font-bold mb-4">Lengkap</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac leo pretium, pulvinar lectus a, vulputate elit.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-6">
    <div class="container mx-auto flex items-center justify-between">
      <div>
        <img src="logo.png" alt="Logo" class="h-8 w-8 mr-2">
        <span class="font-bold">Company Name</span>
      </div>
      <div>
        <p class="text-gray-400">Contact us: info@example.com</p>
      </div>
    </div>
  </footer>
</body>

<script src="assets/js/script.js"></script>

</html>
