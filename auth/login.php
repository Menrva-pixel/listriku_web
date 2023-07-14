<?php

include '../env/config.php';

error_reporting(0);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Pages / Login - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/user.css">
    <style>
        .bg-blur {
            background-size: cover;
            backdrop-filter: blur(8px);
        }

        .logo {
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="bg-blur">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>

    <main>
        <div class="container mx-auto flex items-center justify-center h-screen">
            <section class="w-full max-w-xs">
                <div class="bg-white bg-opacity-75 shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <div class="text-center">
                        <img class="logo mx-auto" src="../assets/images/slider-dec.png" alt="Logo">
                        <p class="text-black mx-auto py-10 font-bold">LISTRIKU</p>
                    </div>
                    <form class="mb-4" method="post" action="../env/login-act.php">
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                                Username
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="username" type="text" placeholder="Username" name="username">
                        </div>
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                Password
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                id="password" type="password" placeholder="Password" name="password">
                        </div>
                        <div class="flex items-center justify-between">
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="submit">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
</body>

</html>



