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
  <div class="blur-layer bg-fixed" style="background-image: url('assets/images/hero1.webp'); background-size: cover; z-index: -1;"></div>
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
  <div class="blur-layer bg-fixed" style="background-image: url('assets/images/hero1.webp'); background-size: cover; z-index: -1;"></div>
  <div class="z-99 grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
    <div class="rounded-md p-4 mr-auto place-self-center lg:col-span-7" data-aos="fade-up" data-aos-duration="2000">
    <h3 class="z-10 mt-6 text-yellow-400 flex flex-row items-center text-3xl"><img class="h-auto w-14" src="assets/images/slider-dec.png" alt="logo">Listriku</h3>
      <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight text-yellow-300 stroke-black leading-none md:text-5xl xl:text-7xl dark:text-white">Effortless Payment</h1>
      <p class="max-w-2xl mb-6 font-md text-gray-300 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">Kami membantu anda untuk melakukan pembayaran <a class="text-yellow-300">listrik</a> bulanan tanpa harus keluar rumah.</p>
      <a href="auth/login" class="inline-flex items-center justify-center text-base font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
        <svg class="w-8 h-8 ml-2 -mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
      </a>
    </div>
    <div class="hidden lg:mt-0 lg:col-span-5 lg:flex" data-aos="fade-up" data-aos-duration="2000">
      <img class="opacity-0" src="assets/images/slider-dec.png" alt="brand-logo">
    </div>                
  </div>
</section>

  <!-- Company Information section -->
  <section class="pt-20 bg-transparent dark:bg-gray-900 pt-42">
    <div class="gap-8 items-center py-32 px-4 mx-auto max-w-screen-xl xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6">
        <img class="w-full dark:hidden" data-aos="fade-right" data-aos-duration="2000" src="assets/images/slider-dec.png" alt="dashboard image">
        <img class="w-full hidden dark:block" src="assets/images/slider-dec.png" alt="dashboard image">
        <div class="mt-4 md:mt-0" data-aos="fade-left" data-aos-duration="2000">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-yellow-300 dark:text-white">Selamat Datang Di Website Kami</h2>
            <p class="mb-6 font-light text-gray-300 md:text-lg dark:text-gray-400">"Kami berkomitmen untuk memberikan pengalaman yang nyaman dan mudah bagi Anda dalam menggunakan layanan website kami. Silahkan kunjungi platform kami atau hubungi layanan pelanggan kami untuk menikmati berbagai fitur dan kemudahan yang kami tawarkan."</p>
        </div>
    </div>
</section>

  <!-- quote Section -->
  <section class="dark:bg-gray-900 relative">
<div class="blur-layer bg-fixed" style="background-image: url('assets/images/hero6.webp'); background-size: cover; padding-top: 100px; z-index: -1;"></div>
  <div class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-16 lg:px-6">
      <figure class="max-w-screen-md mx-auto">
          <svg class="h-12 mx-auto mb-3 text-gray-400 dark:text-gray-600" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M14.017 18L14.017 10.609C14.017 4.905 17.748 1.039 23 0L23.995 2.151C21.563 3.068 20 5.789 20 8H24V18H14.017ZM0 18V10.609C0 4.905 3.748 1.038 9 0L9.996 2.151C7.563 3.068 6 5.789 6 8H9.983L9.983 18L0 18Z" fill="currentColor"/>
          </svg> 
          <blockquote>
              <p class="text-2xl font-medium text-gray-200 dark:text-white">"Website ini di rancang dan di buat untuk memenuhi tugas sertifikasi Sistem Analisis LSP UBSI, dengan fitur yang dapat membuat user melakukan transaksi tagihan listrik, dan juga pengecekan penggunaan listrik bulanan."</p>
          </blockquote>
          <figcaption class="flex items-center justify-center mt-6 space-x-3">
              <img class="w-6 h-6 rounded-full" src="assets/images/fotbar2.png" alt="profile picture">
              <div class="flex items-center divide-x-2 divide-gray-500 dark:divide-gray-700">
                  <div class="pr-3 font-medium text-yellow-400 dark:text-white">Barkah Herdyanto S</div>
                  <div class="pl-3 text-sm font-light text-gray-200 dark:text-gray-400">Student at UBSI</div>
              </div>
          </figcaption>
      </figure>
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
      <div class="space-y-4 bg-yellow-300 rounded-md">
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

      <div class="space-y-4 bg-yellow-300 rounded-md" data-aos="fade-up" data-aos-duration="2000">
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

      <div class="space-y-4 bg-yellow-300 rounded-md" data-aos="fade-up" data-aos-duration="3000">
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

<section class="bg-fixed py-36 dark:bg-gray-900 relative">
  <div class="blur-layer bg-fixed" style="background-image: url('assets/images/hero6.webp'); background-size: cover; padding-top: 100px; z-index: -1;"></div>
  <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
      <div class="mx-auto max-w-screen-md sm:text-center">
          <h2 class="mb-4 text-3xl tracking-tight font-extrabold text-yellow-400 sm:text-4xl dark:text-yellow-300">Daftar untuk berita terbaru</h2>
          <p class="mx-auto mb-8 max-w-2xl font-light text-gray-200 md:mb-12 sm:text-xl dark:text-gray-400">Hubungi kami jika mengalami kendala, dan dapatkan informasi terbaru dari kami.</p>
          <form action="#">
              <div class="items-center mx-auto mb-3 space-y-4 max-w-screen-sm sm:flex sm:space-y-0">
                  <div class="relative w-full">
                      <label for="email" class="hidden mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email address</label>
                      <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                          <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                      </div>
                      <input class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:rounded-none sm:rounded-l-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter your email" type="email" id="email" required="">
                  </div>
                  <div>
                      <button type="submit" class="py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg border cursor-pointer bg-primary-700 border-primary-600 sm:rounded-none sm:rounded-r-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Subscribe</button>
                  </div>
              </div>
              <div class="mx-auto max-w-screen-sm text-sm text-left text-gray-500 newsletter-form-footer dark:text-gray-300">We care about the protection of your data. <a href="#" class="font-medium text-primary-600 dark:text-primary-500 hover:underline">Read our Privacy Policy</a>.</div>
          </form>
      </div>
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
              <a href="#" class="mr-4 hover:underline md:mr-6 ">Campaigns</a>
          </li>
          <li>
              <a href="#" class="mr-4 hover:underline md:mr-6">Blog</a>
          </li>
      </ul>
  </div>
</footer>


<div class="copyright-container py-6">
    <div class="flex justify-center ml-4">
      <p class="text-gray-400 font-semibold text-sm">&copy; 2023 Listriku. All rights reserved.</p>
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
