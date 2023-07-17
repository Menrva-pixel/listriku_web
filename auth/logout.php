<?php
session_start();

function logout() {
    // Hentikan sesi pengguna
    session_unset();
    session_destroy();
    header('Location: login');
    exit;
}
if (isset($_GET['logout'])) {
    logout();
}
?>
