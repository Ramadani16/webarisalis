<?php
session_start(); // Tambahkan ini
require 'db.php';

$configFile = 'config.json';
$config = json_decode(file_get_contents($configFile), true);

// Ambil username dari form
$username = trim($_POST['username']);
$config['username'] = $username;

// Cek upload foto
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array(strtolower($ext), $allowed)) {
        $newName = 'foto_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], 'img/' . $newName);

        // Hapus foto lama (kecuali default)
        if ($config['foto'] !== 'arisalis.jpg' && file_exists('img/' . $config['foto'])) {
            unlink('img/' . $config['foto']);
        }

        $config['foto'] = $newName;
    } else {
        die("Format gambar tidak didukung.");
    }
}

// Simpan ke file config.json
file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));

// ✅ Set session untuk notifikasi
$_SESSION['pesan'] = 'Setting berhasil diperbarui.';

// Redirect kembali ke dashboard
header("Location: dashboard.php");
exit();
