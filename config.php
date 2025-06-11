<?php
// Konfigurasi akun admin
define('ADMIN_USER', 'admin');
define('ADMIN_PASS_HASH', '$2y$10$QkY0Dl3I2BNaK3/2VKq3/.O06C9I69drjGNqgvjM7NqWX1cxDi1rC'); // hash dari 'admin123'

// Batasi hanya bisa dari localhost
if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
    die('❌ Akses ditolak. Hanya bisa dari localhost.');
}

// Mulai session
session_start();
