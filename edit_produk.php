<?php
include 'db.php';

$success = '';
$error = '';
$produk = [
    'nama' => '',
    'deskripsi' => '',
    'gambar' => '',
    'link_shopee' => ''
];

// Ambil data produk berdasarkan ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM produk WHERE id = $id");
    if ($result && $result->num_rows > 0) {
        $produk = $result->fetch_assoc();
    } else {
        $error = "Produk tidak ditemukan.";
    }
}

// Proses update jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $nama = trim($_POST['nama']);
    $deskripsi = trim($_POST['deskripsi']);
    $link_shopee = trim($_POST['link_shopee']);
    $gambar = $produk['gambar'];

    if (!empty($_FILES['gambar']['name'])) {
        $target_dir = "img/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $gambar_baru = basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $gambar_baru;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                if (!empty($produk['gambar']) && file_exists('img/' . $produk['gambar'])) {
                    unlink('img/' . $produk['gambar']);
                }
                $gambar = $gambar_baru;
            } else {
                $error = "Gagal mengupload gambar.";
            }
        } else {
            $error = "Format gambar tidak valid. Hanya JPG, PNG, GIF.";
        }
    }

    if (empty($error)) {
        $stmt = $conn->prepare("UPDATE produk SET nama=?, deskripsi=?, gambar=?, link_shopee=? WHERE id=?");
        $stmt->bind_param("ssssi", $nama, $deskripsi, $gambar, $link_shopee, $id);
        if ($stmt->execute()) {
            $success = "Produk berhasil diperbarui.";
            $produk = [
                'nama' => $nama,
                'deskripsi' => $deskripsi,
                'gambar' => $gambar,
                'link_shopee' => $link_shopee
            ];
        } else {
            $error = "Gagal menyimpan perubahan: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .btn-container {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .current-image {
            max-width: 150px;
            margin-top: 10px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Edit Produk</h1>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($produk['nama']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?= htmlspecialchars($produk['deskripsi']) ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="link_shopee" class="form-label">Link Shopee</label>
                <input type="url" class="form-control" id="link_shopee" name="link_shopee" value="<?= htmlspecialchars($produk['link_shopee']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Produk</label>
                <input type="file" class="form-control" id="gambar" name="gambar">
                <?php if (!empty($produk['gambar']) && file_exists('img/' . $produk['gambar'])): ?>
                    <img src="img/<?= htmlspecialchars($produk['gambar']) ?>" alt="Gambar saat ini" class="current-image">
                <?php endif; ?>
            </div>
            
            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>