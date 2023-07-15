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
  <nav class="mx-4 lg:mx-0 navbar z-50 sticky top-0 flex items-center justify-between bg-transparent text-white drop-shadow-md p-2 border-b border-slate-900/10 lg:px-8 lg:border-0 dark:border-slate-300/10">
    <div class="flex flex-row items-center">
    <img src="assets/images/slider-dec.png" alt="Brand-Logo" class="h-12 w-15 ml-12">
      <a class="nav-title font-bold text-2xl ">Listriku</a>
    </div>
    <div class="mr-12 font-semibold flex flex-row items-center">
      <a href="#" class="text-white hover:text-blue-400 mx-6">Home</a>
      <a href="#" class="text-white hover:text-blue-400 mx-6">About</a>
      <?php if (isset($username)) : ?>
        <!-- Pengguna sudah login, tampilkan nama pengguna -->
        <a href="pages/user" class="text-yellow-400 font-bold mx-2"><i class="fa-regular fa-user yellow-400 mr-2"></i><?php echo $username; ?></a>
      <?php else : ?>
        <!-- Pengguna belum login, tampilkan opsi login -->
        <a href="auth/login" class="login-icon text-white hover:text-blue-400 p-3 rounded-3xl mx-2 transform hover:scale-75"><i class="fa-solid fa-right-to-bracket"></i></a>
      <?php endif; ?>
      <a href="https://github.com/menrva-pixel/listriku_web" target="_blank" class=" ml-6 text-slate-400 hover:text-slate-500 dark:hover:text-slate-300"><span class="sr-only">Tailwind CSS on GitHub</span><svg viewBox="0 0 16 16" class="w-5 h-5" fill="currentColor" aria-hidden="true"><path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"></path></svg></a>
    </div>
  </nav>

  <!-- Hero section -->
  <section class="z-0 bg-transparent h-96 m-20" data-aos="fade-up" data-aos-duration="2000">
    <div class="container mx-auto mt-56 text-center">
      <h1 class="z-10 text-white font-black text-8xl">Selamat Datang</h1>
      <p class="mt-8 text-gray-400 text-2xl dark:text-gray-300">Kami membantu anda untuk melakukan pembayaran <a class="text-yellow-400">listrik </a>bulanan tanpa harus keluar rumah</p>
    </div>
  </section>


  <!-- Company Information section -->
  <section class="bg-transparent p-16 overflow-hidden">
    <div class="container mx-auto">
      <div class="flex items-center justify-center">
        <div class="w-1/2">
          <img src="assets/images/slider-dec.png" alt="Company Image" class="logo-img drop-shadow-2xl mb-5 h-25 w-25" data-aos="fade-right" data-aos-duration="1000">
        </div>
        <div class="rounded-lg shadow-xl w-1/2 bg-gray-900 p-12 bg-opacity-80 rounded flex-auto relative block text-slate-50 overflow-auto" data-aos="fade-left" data-aos-duration="1000">
          <h2 class="text-white text-4xl font-bold mb-4">Listriku</h2>
          <p class="text-gray-300 text-md text-justify">"Kami berkomitmen untuk memberikan pengalaman yang nyaman dan mudah bagi Anda dalam menggunakan layanan listrik kami. Silakan kunjungi platform kami atau hubungi layanan pelanggan kami untuk menikmati berbagai fitur dan kemudahan yang kami tawarkan."</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Additional Information section -->
  <hr class="w-96 h-1 mx-auto bg-gray-400 rounded md:my-10 dark:bg-gray-700">
  <section class="py-8 m-0 border-y border-gray-100 dark:border-gray-800 sm:flex justify-between">
  <div class="container mx-auto">
    <div class="grid grid-cols-3 gap-10 mx-auto w-1/2">
      <div class="card">
        <div class="image-container">
        <svg class="p-4" width="auto" height="auto" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="10" cy="6" r="4" stroke="#fff" stroke-width="1.5"/>
          <path d="M18.0429 12.3656L18.4865 11.7609L18.4865 11.7609L18.0429 12.3656ZM19 8.69135L18.4813 9.23307C18.7713 9.51077 19.2287 9.51077 19.5187 9.23307L19 8.69135ZM19.9571 12.3656L19.5135 11.7609L19.5135 11.7609L19.9571 12.3656ZM19 12.8276L19 13.5776H19L19 12.8276ZM18.4865 11.7609C18.0686 11.4542 17.6081 11.0712 17.2595 10.6681C16.8912 10.2423 16.75 9.91131 16.75 9.69673H15.25C15.25 10.4666 15.6912 11.1479 16.1249 11.6493C16.5782 12.1735 17.1391 12.6327 17.5992 12.9703L18.4865 11.7609ZM16.75 9.69673C16.75 9.12068 17.0126 8.87002 17.2419 8.78964C17.4922 8.70189 17.9558 8.72986 18.4813 9.23307L19.5187 8.14963C18.6943 7.36028 17.6579 7.05432 16.7457 7.3741C15.8125 7.70123 15.25 8.59955 15.25 9.69673H16.75ZM20.4008 12.9703C20.8609 12.6327 21.4218 12.1735 21.8751 11.6493C22.3088 11.1479 22.75 10.4666 22.75 9.69672H21.25C21.25 9.91132 21.1088 10.2424 20.7405 10.6681C20.3919 11.0713 19.9314 11.4542 19.5135 11.7609L20.4008 12.9703ZM22.75 9.69672C22.75 8.59954 22.1875 7.70123 21.2543 7.37409C20.3421 7.05432 19.3057 7.36028 18.4813 8.14963L19.5187 9.23307C20.0442 8.72986 20.5078 8.70189 20.7581 8.78964C20.9874 8.87002 21.25 9.12068 21.25 9.69672H22.75ZM17.5992 12.9703C17.9678 13.2407 18.3816 13.5776 19 13.5776L19 12.0776C18.9756 12.0776 18.9605 12.0775 18.9061 12.0488C18.8202 12.0034 18.7128 11.9269 18.4865 11.7609L17.5992 12.9703ZM19.5135 11.7609C19.2872 11.9269 19.1798 12.0034 19.0939 12.0488C19.0395 12.0775 19.0244 12.0776 19 12.0776L19 13.5776C19.6184 13.5776 20.0322 13.2407 20.4008 12.9703L19.5135 11.7609Z" fill="#fff"/>
          <path d="M17.9975 18C18 17.8358 18 17.669 18 17.5C18 15.0147 14.4183 13 10 13C5.58172 13 2 15.0147 2 17.5C2 19.9853 2 22 10 22C12.231 22 13.8398 21.8433 15 21.5634" stroke="#fff" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
          <div class="caption">User Friendly</div>
        </div>
      </div>
      <div class="card">
        <div class="image-container">
        <svg class="p-4" fill="#000000" height="auto" width="auto" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	    viewBox="0 0 289.939 289.939" xml:space="preserve">
      <g>
        <path fill="#fff" id="circle8953" d="M144.969,20.485c-37.119,0-74.239,14.145-102.531,42.438c-56.584,56.584-56.584,148.478,0,205.063
          c1.951,1.955,5.118,1.957,7.072,0.006s1.957-5.118,0.006-7.072c-0.002-0.002-0.004-0.004-0.006-0.006
          c-52.763-52.763-52.763-138.155,0-190.918c52.763-52.763,138.155-52.763,190.918,0c52.763,52.763,52.763,138.155,0,190.918
          c-1.955,1.951-1.959,5.117-0.008,7.072s5.117,1.959,7.072,0.008c0.003-0.003,0.005-0.005,0.008-0.008
          c56.584-56.584,56.584-148.478,0-205.063C219.209,34.63,182.089,20.485,144.969,20.485z M144.969,35.798
          c-32.626,0-65.271,12.458-90.156,37.344c-49.771,49.771-49.771,130.541,0,180.312c0.956,0.996,2.539,1.028,3.535,0.072
          c0.996-0.956,1.028-2.539,0.072-3.535c-0.023-0.024-0.047-0.048-0.072-0.072c-47.86-47.861-47.86-125.38,0-173.24
          c23.93-23.93,55.267-35.881,86.621-35.881c1.381,0.02,2.516-1.084,2.535-2.465s-1.084-2.516-2.465-2.535
          C145.017,35.797,144.993,35.797,144.969,35.798z M224.872,80.405c-1.299,0.039-2.532,0.582-3.438,1.514l-62.701,62.701
          c-3.955-2.627-8.687-4.166-13.764-4.166c-13.748,0-25,11.252-25,25s11.252,25,25,25s25-11.252,25-25
          c0-5.076-1.539-9.809-4.166-13.764l62.701-62.701C231.775,85.81,229.431,80.271,224.872,80.405z M144.969,150.454
          c8.343,0,15,6.657,15,15s-6.657,15-15,15s-15-6.657-15-15S136.626,150.454,144.969,150.454z M144.969,152.954
          c-6.874,0-12.5,5.626-12.5,12.5c-0.02,1.381,1.084,2.516,2.465,2.535c1.381,0.02,2.516-1.084,2.535-2.465c0-0.024,0-0.047,0-0.071
          c0-4.172,3.328-7.5,7.5-7.5c1.381,0.02,2.516-1.084,2.535-2.465c0.02-1.381-1.084-2.516-2.465-2.535
          C145.017,152.953,144.993,152.953,144.969,152.954z"/>
      </g>
      </svg>
          <div class="caption">Penanganan Cepat</div>
        </div>
      </div>
      <div class="card shadow-xl">
        <div class="image-container">
        <svg class="p-4" width="auto" height="auto" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.4933 6.93502C15.8053 7.20743 15.8374 7.68122 15.565 7.99325L7.70786 16.9933C7.56543 17.1564 7.35943 17.25 7.14287 17.25C6.9263 17.25 6.72031 17.1564 6.57788 16.9933L3.43502 13.3933C3.16261 13.0812 3.19473 12.6074 3.50677 12.335C3.8188 12.0626 4.29259 12.0947 4.565 12.4068L7.14287 15.3596L14.435 7.00677C14.7074 6.69473 15.1812 6.66261 15.4933 6.93502Z" fill="#fff"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M20.5175 7.01946C20.8174 7.30513 20.829 7.77986 20.5433 8.07981L11.9716 17.0798C11.8201 17.2389 11.6065 17.3235 11.3872 17.3114C11.1679 17.2993 10.9649 17.1917 10.8318 17.0169L10.4035 16.4544C10.1526 16.1249 10.2163 15.6543 10.5458 15.4034C10.8289 15.1878 11.2161 15.2044 11.4787 15.4223L19.4571 7.04531C19.7428 6.74537 20.2175 6.73379 20.5175 7.01946Z" fill="#fff"/>
        </svg>
          <div class="caption">Fitur Lengkap</div>
        </div>
      </div>
    </div>
  </div>
</section>


  <hr class="w-1/2 h-1 mx-auto bg-gray-400 border-0 rounded md:my-10 dark:bg-gray-700">

  <!-- Additional features section -->
  <section class="py-16">
  <div class="container3 ml-16 mx-auto">
    <div class="stacked-cards" id="stackedCards">
      <div class="card3" onclick="swapCards(0)">
        <img src="assets/images/assets-2.png" class="card-image">
        <div class="card-content p-24 ml-14">
          <h2 class="card-title">Laporan</h2>
          <p class="card-description">Kami menyediakan layanan untuk melaporkan gangguan kelistrikan di wilayah anda, petugas akan dengan
            segera datang untuk memperbaiki gangguan yang anda alami.</p>
        </div>
      </div>
      <div class="card3" onclick="swapCards(1)">
        <img src="assets/images/assets-1.png" class="card-image">
        <div class="card-content">
          <h2 class="card-title">Pembayaran</h2>
          <p class="card-description">Lakukan Pembayaran dengan mudah tanpa keluar rumah! website kami membantu anda melakukan pengecekan penggunaan listrik
            dan juga biaya bulan. Bayar mudah gak pake ribet!
          </p>
        </div>
      </div>
    </div>
    <div class="description-container ml-24 text-white m-auto" id="descriptionContainer">
      <h2 id="selectedTitle" class="text-3xl mb-4 font-2xl">Laporan</h2>
      <p id="selectedDescription">Kami menyediakan layanan untuk melaporkan gangguan kelistrikan di wilayah anda, petugas akan dengan
        segera datang untuk memperbaiki gangguan yang anda alami.</p>
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
