<?php
include '../env/config.php';
error_reporting(0);

session_start();

function displayError($error) {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '$error',
                showConfirmButton: false,
                timer: 2000
            });
        </script>";
}

// Fungsi login dan lainnya tetap sama seperti sebelumnya

// ambil data username dan password dari form login
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (login($username, $password)) {
        redirect();
    } else {
        displayError("Username atau Password salah");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login | Listriku</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- user CSS -->
    <link rel="stylesheet" href="../assets/css/user.css">

    <!-- Vendor -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-200">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-sm bg-white rounded-lg shadow-md p-6 animate__animated animate__fadeIn">
            <div class="text-center">
                <img class="w-24 mx-auto" src="../assets/images/slider-dec.png" alt="Logo">
                <h1 class="text-xl font-bold text-gray-800 mt-4">LISTRIKU</h1>
            </div>
            <form class="mt-6" id="login-form" action="../env/login-act" method="post">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Username
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline animate__animated animate__fadeInUp"
                        id="username" type="text" placeholder="Username" name="username" pattern="[A-Za-z0-9]+">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline animate__animated animate__fadeInUp"
                        id="password" type="password" placeholder="Password" name="password" pattern="[A-Za-z0-9!@#$%^&*()_+=\-]+">
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline animate__animated animate__fadeInUp"
                        type="submit">
                        Login
                    </button>
                    <button
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline animate__animated animate__fadeInUp"
                        type="button" id="to-register-btn">
                        Register
                    </button>
                </div>
            </form>

            <form class="mt-4 hidden" id="register-form" action="../env/register-act" method="post">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Username
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline animate__animated animate__fadeInUp"
                        id="username" type="text" placeholder="Username" name="username" pattern="[A-Za-z0-9]+"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="email" type="email" placeholder="Email" name="email" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline animate__animated animate__fadeInUp"
                        id="password" type="password" placeholder="Password" name="password" pattern="[A-Za-z0-9!@#$%^&*()_+=-]+"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="alamat">
                        Alamat
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="alamat" type="text" placeholder="Alamat" name="alamat" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="no_telp">
                        Nomor Telepon
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="no_telp" type="number" placeholder="Nomor Telepon" name="no_telp" required>
                </div>
                <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline animate__animated animate__fadeInUp"
                    type="submit" id="register-btn" disabled>
                    Register
                </button>

                    <button
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline animate__animated animate__fadeInUp"
                        type="button" id="cancel-btn">
                        Cancel
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Animate.css -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.js"></script>
    <script>
        // Toggle form display
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const toRegisterBtn = document.getElementById('to-register-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        const registerBtn = document.getElementById('register-btn');

        toRegisterBtn.addEventListener('click', function () {
            loginForm.classList.add('hidden');
            registerForm.classList.remove('hidden');
        });

        cancelBtn.addEventListener('click', function () {
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
        });
        // event listener pada setiap input field
        const inputFields = registerForm.querySelectorAll('input');
        inputFields.forEach(function(input) {
            input.addEventListener('input', function() {
                const isFormValid = validateForm(registerForm);
                registerBtn.disabled = !isFormValid;
            });
        });
        // Fungsi untuk memeriksa validitas form
        function validateForm(form) {
            let isValid = true;
            const inputFields = form.querySelectorAll('input');
            inputFields.forEach(function(input) {
                if (input.checkValidity() === false) {
                    isValid = false;
                    return;
                }
            });
            return isValid;
        }

        registerBtn.addEventListener('click', function (e) {
                e.preventDefault(); // Menghentikan submit form

                // Menampilkan SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: 'Registrasi Berhasil!',
                    text: 'Selanjutnya, Daftarkan Rumah anda!',
                    showConfirmButton: true, // Ubah showConfirmButton menjadi true
                    allowOutsideClick: false, // Tambahkan allowOutsideClick untuk memastikan pengguna harus mengklik tombol "OK" pada SweetAlert2
                }).then(function (result) {
                    if (result.isConfirmed) {
                        // Submit form
                        document.getElementById('register-form').submit();
                    }
                });
            });
    </script>
</body>


</html>






