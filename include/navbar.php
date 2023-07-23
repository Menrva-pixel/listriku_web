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
<nav class="mx-4 lg:mx-0 navbar z-50 top-0 flex items-center justify-between bg-gray-700 text-white drop-shadow-md p-2 border-b border-slate-900/10 lg:px-8 lg:border-0 dark:border-slate-300/10">
  <div class="flex flex-row items-center">
    <img src="../assets/images/slider-dec.png" alt="Brand-Logo" class="h-12 w-15 ml-12">
      <a class="nav-title font-bold text-2xl ">Listriku</a>
    </div>
    <div class="mr-12 font-semibold flex flex-row items-center">
      <a href="../index" class="home text-white hover:text-blue-400 mx-6">Home</a>
      <a href="../pages/blog" class="home text-white hover:text-blue-400 mx-6">Blog</a>
      <a href="../pages/about" class="text-white hover:text-blue-400 mx-6">About</a>
      <?php if (isAdminLoggedIn()) : ?>
    <a href="pages/admin" class="text-yellow-400 font-bold mx-2"><i class="fa-regular fa-user yellow-400 mr-2"></i>Admin</a>
      <?php elseif (isUserLoggedIn()) : ?>
          <a href="../pages/user" class="text-yellow-400 font-bold mx-2"><i class="fa-regular fa-user yellow-400 mr-2"></i><?php echo $_SESSION['username']; ?></a>
      <?php else : ?>
          <a href="../auth/login" class="login-icon text-white hover:text-blue-400 p-3 rounded-3xl mx-2 transform hover:scale-75"><i class="fa-solid fa-right-to-bracket"></i></a>
      <?php endif; ?>
      <a href="https://github.com/menrva-pixel/listriku_web" target="_blank" class=" ml-6 text-slate-400 hover:text-slate-500 dark:hover:text-slate-300"><span class="sr-only">Tailwind CSS on GitHub</span><svg viewBox="0 0 16 16" class="w-5 h-5" fill="currentColor" aria-hidden="true"><path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"></path></svg></a>
    </div>
  </nav>