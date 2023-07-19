<?php
session_start();

if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
}

function isAdminLoggedIn()
{
    return isset($_SESSION['username']) && $_SESSION['privilege'] === 'Admin';
}

function isUserLoggedIn()
{
    return isset($_SESSION['username']) && $_SESSION['privilege'] === 'Pelanggan';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Selamat datang di Listriku - Aplikasi Pelayanan Listrik Terbaik. Nikmati kemudahan dalam mengelola penggunaan listrik Anda dan pantau tagihan secara efisien. Daftarkan rumah Anda dan rasakan kenyamanan layanan yang maksimal. Hemat energi, hemat waktu, dan nikmati kenyamanan dalam satu platform. Bergabunglah dengan ribuan pengguna puas di Listriku sekarang!">
  <meta name="keywords" content="Listriku, pelayanan listrik, aplikasi listrik, penggunaan listrik, tagihan listrik, hemat energi, manajemen listrik">
  <meta name="author" content="Listriku Team">
  <meta name="robots" content="index, follow">

  <title>Listriku | Website Latihan</title>
  <!-- Favicons -->
  <link href="assets/icons/favicon.ico" rel="icon">
  <link href="assets/icons/apple-touch-icon.png" rel="apple-touch-icon">


  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/responsive.css">

  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
</head>

<body>
  <!-- Navbar -->
  <nav class="mx-4 lg:mx-0 navbar z-50 top-0 flex items-center justify-between bg-lightblue-200 text-white drop-shadow-md p-2 border-b border-slate-900/10 lg:px-8 lg:border-0 dark:border-slate-300/10">
    <div class="flex flex-row items-center">
    <img src="assets/images/slider-dec.png" alt="Brand-Logo" class="h-12 w-15 ml-12">
      <a class="nav-title font-bold text-2xl ">Listriku</a>
    </div>
    <div class="mr-12 font-semibold flex flex-row items-center">
      <a href="#" class="home text-white hover:text-blue-400 mx-6">Home</a>
      <a href="pages/about" class="text-white hover:text-blue-400 mx-6">About</a>
      <?php if (isAdminLoggedIn()) : ?>
    <a href="pages/admin" class="text-yellow-400 font-bold mx-2"><i class="fa-regular fa-user yellow-400 mr-2"></i>Admin</a>
      <?php elseif (isUserLoggedIn()) : ?>
          <a href="pages/user" class="text-yellow-400 font-bold mx-2"><i class="fa-regular fa-user yellow-400 mr-2"></i><?php echo $_SESSION['username']; ?></a>
      <?php else : ?>
          <a href="auth/login" class="login-icon text-white hover:text-blue-400 p-3 rounded-3xl mx-2 transform hover:scale-75"><i class="fa-solid fa-right-to-bracket"></i></a>
      <?php endif; ?>
      <a href="https://github.com/menrva-pixel/listriku_web" target="_blank" class=" ml-6 text-slate-400 hover:text-slate-500 dark:hover:text-slate-300"><span class="sr-only">Tailwind CSS on GitHub</span><svg viewBox="0 0 16 16" class="w-5 h-5" fill="currentColor" aria-hidden="true"><path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"></path></svg></a>
    </div>
  </nav>

  <!-- Hero section -->
  <section class="dark:bg-gray-900 relative">
  <div class="blur-layer bg-fixed" style="background-image: url('assets/images/hero6.jpg'); background-size: cover; padding-top: 100px; z-index: -1;"></div>
  <div class="z-99 grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
    <div class="rounded-md p-4 mr-auto place-self-center lg:col-span-7" data-aos="fade-up" data-aos-duration="2000">
      <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight text-yellow-300 stroke-black leading-none md:text-5xl xl:text-6xl dark:text-white">Effortless Payment</h1>
      <p class="max-w-2xl mb-6 font-semibold text-gray-300 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">Kami membantu anda untuk melakukan pembayaran listrik bulanan tanpa harus keluar rumah.</p>
      <a href="#" class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
        Get started
        <svg class="w-5 h-5 ml-2 -mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
      </a>
      <a href="auth/login" class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-200 border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-black focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
        Daftar
      </a> 
    </div>
    <div class="hidden lg:mt-0 lg:col-span-5 lg:flex" data-aos="fade-up" data-aos-duration="2000">
      <img src="assets/images/slider-dec.png" alt="brand-logo">
    </div>                
  </div>
</section>

  <!-- Company Information section -->
  <section class="bg-transparent dark:bg-gray-900">
    <div class="gap-8 items-center py-8 px-4 mx-auto max-w-screen-xl xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6">
        <img class="w-full dark:hidden" data-aos="fade-right" data-aos-duration="2000" src="assets/images/img-1.jpg" alt="dashboard image">
        <img class="w-full hidden dark:block" src="assets/images/img-1.jpg" alt="dashboard image">
        <div class="mt-4 md:mt-0" data-aos="fade-left" data-aos-duration="2000">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-yellow-300 dark:text-white">Selamat Datang Di Website Kami</h2>
            <p class="mb-6 font-light text-gray-300 md:text-lg dark:text-gray-400">"Kami berkomitmen untuk memberikan pengalaman yang nyaman dan mudah bagi Anda dalam menggunakan layanan website kami. Silahkan kunjungi platform kami atau hubungi layanan pelanggan kami untuk menikmati berbagai fitur dan kemudahan yang kami tawarkan."</p>
        </div>
    </div>
</section>

  <!-- Performance Section -->
  <section class="bg-fixed py-36 dark:bg-gray-900 relative">
  <div class="blur-layer bg-fixed" style="background-image: url('assets/images/hero6.jpg'); background-size: cover; padding-top: 100px; z-index: -1;"></div>
  <div class="performa-container relative mx-auto">
    <div class="performa-card mx-auto grid grid-cols-1 md:grid-cols-3 w-1/2 h-auto gap-8">
      <div class="card-container">
        <div class="card p-4 h-36 w-36 ml-24 rounded-full border-4 border-white transition-all duration-300" data-aos="fade-right" data-aos-duration="3000">
          <div class="image-container">
            <svg class="p-4" width="auto" height="auto" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <svg class="p-4" width="auto" height="auto" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="10" cy="6" r="4" stroke="#fff" stroke-width="1.5"/>
          <path d="M18.0429 12.3656L18.4865 11.7609L18.4865 11.7609L18.0429 12.3656ZM19 8.69135L18.4813 9.23307C18.7713 9.51077 19.2287 9.51077 19.5187 9.23307L19 8.69135ZM19.9571 12.3656L19.5135 11.7609L19.5135 11.7609L19.9571 12.3656ZM19 12.8276L19 13.5776H19L19 12.8276ZM18.4865 11.7609C18.0686 11.4542 17.6081 11.0712 17.2595 10.6681C16.8912 10.2423 16.75 9.91131 16.75 9.69673H15.25C15.25 10.4666 15.6912 11.1479 16.1249 11.6493C16.5782 12.1735 17.1391 12.6327 17.5992 12.9703L18.4865 11.7609ZM16.75 9.69673C16.75 9.12068 17.0126 8.87002 17.2419 8.78964C17.4922 8.70189 17.9558 8.72986 18.4813 9.23307L19.5187 8.14963C18.6943 7.36028 17.6579 7.05432 16.7457 7.3741C15.8125 7.70123 15.25 8.59955 15.25 9.69673H16.75ZM20.4008 12.9703C20.8609 12.6327 21.4218 12.1735 21.8751 11.6493C22.3088 11.1479 22.75 10.4666 22.75 9.69672H21.25C21.25 9.91132 21.1088 10.2424 20.7405 10.6681C20.3919 11.0713 19.9314 11.4542 19.5135 11.7609L20.4008 12.9703ZM22.75 9.69672C22.75 8.59954 22.1875 7.70123 21.2543 7.37409C20.3421 7.05432 19.3057 7.36028 18.4813 8.14963L19.5187 9.23307C20.0442 8.72986 20.5078 8.70189 20.7581 8.78964C20.9874 8.87002 21.25 9.12068 21.25 9.69672H22.75ZM17.5992 12.9703C17.9678 13.2407 18.3816 13.5776 19 13.5776L19 12.0776C18.9756 12.0776 18.9605 12.0775 18.9061 12.0488C18.8202 12.0034 18.7128 11.9269 18.4865 11.7609L17.5992 12.9703ZM19.5135 11.7609C19.2872 11.9269 19.1798 12.0034 19.0939 12.0488C19.0395 12.0775 19.0244 12.0776 19 12.0776L19 13.5776C19.6184 13.5776 20.0322 13.2407 20.4008 12.9703L19.5135 11.7609Z" fill="#fff"/>
          <path d="M17.9975 18C18 17.8358 18 17.669 18 17.5C18 15.0147 14.4183 13 10 13C5.58172 13 2 15.0147 2 17.5C2 19.9853 2 22 10 22C12.231 22 13.8398 21.8433 15 21.5634" stroke="#fff" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
            </svg>
            <div class="caption">User Friendly</div>
          </div>
        </div>
      </div>

      <div class="card-container" data-aos="fade-right" data-aos-duration="2000">
      <div class="card p-4 h-36 w-36 ml-24 rounded-full border-4 border-white transition-all duration-300">
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
            </svg>
            <div class="caption">Respon Cepat</div>
          </div>
        </div>
      </div>
      <div class="card-container" data-aos="fade-right" data-aos-duration="1000">
      <div class="card p-4 h-36 w-36 ml-24 rounded-full border-4 border-white transition-all duration-300">
          <div class="image-container">
            <svg class="p-4" width="auto" height="auto" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.4933 6.93502C15.8053 7.20743 15.8374 7.68122 15.565 7.99325L7.70786 16.9933C7.56543 17.1564 7.35943 17.25 7.14287 17.25C6.9263 17.25 6.72031 17.1564 6.57788 16.9933L3.43502 13.3933C3.16261 13.0812 3.19473 12.6074 3.50677 12.335C3.8188 12.0626 4.29259 12.0947 4.565 12.4068L7.14287 15.3596L14.435 7.00677C14.7074 6.69473 15.1812 6.66261 15.4933 6.93502Z" fill="#fff"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M20.5175 7.01946C20.8174 7.30513 20.829 7.77986 20.5433 8.07981L11.9716 17.0798C11.8201 17.2389 11.6065 17.3235 11.3872 17.3114C11.1679 17.2993 10.9649 17.1917 10.8318 17.0169L10.4035 16.4544C10.1526 16.1249 10.2163 15.6543 10.5458 15.4034C10.8289 15.1878 11.2161 15.2044 11.4787 15.4223L19.4571 7.04531C19.7428 6.74537 20.2175 6.73379 20.5175 7.01946Z" fill="#fff"/>
        </svg>
            </svg>
            <div class="caption">Fitur lengkap</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- Project section -->
  <section class="bg-transparent dark:bg-gray-900 antialiased">
  <div class="max-w-screen-xl px-4 py-8 mx-auto lg:px-6 sm:py-16 lg:py-24">
    <div class="max-w-2xl mx-auto text-center">
      <h2 class="text-3xl font-extrabold leading-tight tracking-tight text-yellow-400 sm:text-4xl dark:text-white">
        Our work
      </h2>
      <p class="mt-4 text-base font-normal text-gray-100 sm:text-xl dark:text-gray-400">
        Proyek yang sedang kami kembangkan
      </p>
    </div>

    <div class="grid grid-cols-1 mt-12 text-center sm:mt-16 gap-x-20 gap-y-12 sm:grid-cols-2 lg:grid-cols-3" data-aos="fade-up" data-aos-duration="1000">
      <div class="space-y-4 bg-gray-400 rounded-md">
        <img src="assets/images/proyek-2.webp" alt="proyek-1">
        <h3 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white">
          Kincira Project
        </h3>
        <p class="text-lg font-normal text-gray-700 dark:text-gray-400">
        Proyek Kincira (Kincir Angin) adalah proyek yang ditargetkan untuk meningkatkan efisiensi dan daya listrik negara.
        </p>
        <a href="#" title=""
          class="text-white bg-primary-700 justify-center hover:bg-primary-800 inline-flex items-center  focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
          role="button">
          Lihat detail
          <svg aria-hidden="true" class="w-5 h-5 ml-2 -mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
            fill="currentColor">
            <path fill-rule="evenodd"
              d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
              clip-rule="evenodd" />
          </svg>
        </a>
      </div>

      <div class="space-y-4 bg-gray-400 rounded-md" data-aos="fade-up" data-aos-duration="2000">
        <img src="assets/images/hero2.webp" alt="proyek-2">
        <h3 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white">
          Widera Project
        </h3>
        <p class="text-lg font-normal text-gray-700 dark:text-gray-400">
        Proyek jangkauan listrik ke seluruh pelosok Indonesia, merata hingga ke pelosok negeri.
        </p>
        <a href="#" title=""
          class="text-white bg-primary-700 justify-center hover:bg-primary-800 inline-flex items-center  focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
          role="button">
          Lihat detail
          <svg aria-hidden="true" class="w-5 h-5 ml-2 -mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
            fill="currentColor">
            <path fill-rule="evenodd"
              d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
              clip-rule="evenodd" />
          </svg>
        </a>
      </div>

      <div class="space-y-4 bg-gray-400 rounded-md" data-aos="fade-up" data-aos-duration="3000">
        <img src="assets/images/proyek-3.webp" alt="proyek-3">
        <h3 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white">
          Solaris Project
        </h3>
        <p class="text-lg font-normal text-gray-700 dark:text-gray-400">
        Proyek Solar panel untuk meningkatkan effisiensi penggunaan listrik di siang hari.
        </p>
        <a href="#" title=""
          class="text-white bg-primary-700 justify-center hover:bg-primary-800 inline-flex items-center  focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
          role="button">
          Lihat detail
          <svg aria-hidden="true" class="w-5 h-5 ml-2 -mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
            fill="currentColor">
            <path fill-rule="evenodd"
              d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
              clip-rule="evenodd" />
          </svg>
        </a>
      </div>
    </div>
  </div>
</section>

<section class="dark:bg-gray-900 relative">
<div class="blur-layer bg-fixed" style="background-image: url('assets/images/hero6.jpg'); background-size: cover; padding-top: 100px; z-index: -1;"></div>
  <div class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-16 lg:px-6">
      <figure class="max-w-screen-md mx-auto">
          <svg class="h-12 mx-auto mb-3 text-gray-400 dark:text-gray-600" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M14.017 18L14.017 10.609C14.017 4.905 17.748 1.039 23 0L23.995 2.151C21.563 3.068 20 5.789 20 8H24V18H14.017ZM0 18V10.609C0 4.905 3.748 1.038 9 0L9.996 2.151C7.563 3.068 6 5.789 6 8H9.983L9.983 18L0 18Z" fill="currentColor"/>
          </svg> 
          <blockquote>
              <p class="text-2xl font-medium text-gray-200 dark:text-white">"Wow! Layanan dari website listrik ini sangat memuaskan. Pelayanan pelanggan yang cepat dan responsif, serta produk yang berkualitas tinggi. Saya sangat puas dengan pengalaman berbelanja di sini. Tidak perlu mencari tempat lain, website ini sudah menjadi pilihan terbaik untuk semua kebutuhan listrik saya. Terima kasih atas layanan yang luar biasa!"</p>
          </blockquote>
          <figcaption class="flex items-center justify-center mt-6 space-x-3">
              <img class="w-6 h-6 rounded-full" src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="profile picture">
              <div class="flex items-center divide-x-2 divide-gray-500 dark:divide-gray-700">
                  <div class="pr-3 font-medium text-yellow-400 dark:text-white">Aqshal Maulana</div>
                  <div class="pl-3 text-sm font-light text-gray-200 dark:text-gray-400">Cyber Security at BCP</div>
              </div>
          </figcaption>
      </figure>
  </div>
</section>

<hr>
  <!-- Footer -->
  <footer class="p-4 bg-transparent md:p-8 lg:p-10 dark:bg-gray-800">
  <div class="mx-auto max-w-screen-xl text-center">
      <a href="#" class="flex justify-center items-center text-2xl font-bold text-gray-900 dark:text-white">
        <img class="mr-2 h-8" src="assets/images/slider-dec.png">
          Listriku   
      </a>
      <p class="my-6 text-gray-500 dark:text-gray-400">Memberikan kemudahan bagi anda dalam mendaftar, melapor, dan membayar tagihan listrik rumah.</p>
      <ul class="flex flex-wrap justify-center items-center mb-6 text-gray-900 dark:text-white">
          <li>
              <a href="#" class="mr-4 hover:underline md:mr-6 ">About</a>
          </li>
          <li>
              <a href="#" class="mr-4 hover:underline md:mr-6">Premium</a>
          </li>
          <li>
              <a href="#" class="mr-4 hover:underline md:mr-6 ">Campaigns</a>
          </li>
          <li>
              <a href="#" class="mr-4 hover:underline md:mr-6">Blog</a>
          </li>
          <li>
              <a href="#" class="mr-4 hover:underline md:mr-6">Affiliate Program</a>
          </li>
          <li>
              <a href="#" class="mr-4 hover:underline md:mr-6">FAQs</a>
          </li>
          <li>
              <a href="#" class="mr-4 hover:underline md:mr-6">Contact</a>
          </li>
      </ul>
  </div>
</footer>


<div class="copyright-container py-6">
    <div class="flex justify-start ml-4">
      <p class="text-gray-500 text-sm">&copy; 2023 Listriku. All rights reserved.</p>
    </div>
  </div>

  <script src="assets/js/script.js"></script>
  <script src="assets/js/service-worker.js"></script>
  <script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('assets/js/service-worker.js')
        .then(registration => {
          console.log('Service Worker registered:', registration);
        })
        .catch(error => {
          console.error('Service Worker registration failed:', error);
        });
    });
  }
        const images = document.querySelectorAll('.absolute.transition-opacity');
        let currentImageIndex = 0;

        function fadeInImage(imageIndex) {
            images.forEach((image, index) => {
                if (index === imageIndex) {
                    image.style.opacity = '1';
                } else {
                    image.style.opacity = '0';
                }
            });
        }

        function slideImages() {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            fadeInImage(currentImageIndex);
        }

        // Auto slide images every 5 seconds (5000 milliseconds)
        setInterval(slideImages, 5000);
    </script>

</body>


</html>
