<?php


session_start();
// Batasi akses hanya dari localhost
if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
    die('❌ Akses ditolak. Hanya bisa dari localhost.');
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "arisalis";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
