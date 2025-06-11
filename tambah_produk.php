<?php
include 'db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $deskripsi = trim($_POST['deskripsi']);
    $link_shopee = trim($_POST['link_shopee']);
    $gambar = '';

    if (!empty($_FILES['gambar']['name'])) {
        $target_dir = "img/";
        $gambar = basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $gambar;

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $max_size = 2 * 1024 * 1024; // 2MB

        if (!in_array($imageFileType, $allowed_types)) {
            $error = "Format gambar tidak valid. Hanya JPG, PNG, GIF.";
        } elseif ($_FILES["gambar"]["size"] > $max_size) {
            $error = "Ukuran gambar maksimal 2MB.";
        } elseif (!move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $error = "Gagal mengupload gambar.";
        }
    }

    if (!$error) {
        $stmt = $conn->prepare("INSERT INTO produk (nama, deskripsi, link_shopee, gambar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $deskripsi, $link_shopee, $gambar);
        
        if ($stmt->execute()) {
            echo "<script>window.addEventListener('DOMContentLoaded', () => showSuccessPopup());</script>";
        } else {
            $error = "Gagal menyimpan data produk.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #f8f9fa;
            padding: 15px;
        }
        .card {
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: none;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .form-control, .form-select {
            padding: 10px 15px;
            border-radius: 8px;
        }
        .btn {
            padding: 10px;
            border-radius: 8px;
            font-weight: 500;
        }
        .swal2-popup {
            font-size: 0.95rem !important;
        }
        @media (max-width: 768px) {
            .swal2-popup {
                width: 85vw !important;
                max-width: 85vw !important;
            }
            .swal2-title {
                font-size: 1.3rem !important;
            }
        }
        @media (min-width: 769px) {
            .swal2-popup {
                width: 32rem !important;
                max-width: 32rem !important;
            }
            .swal2-title {
                font-size: 1.6rem !important;
            }
        }
    </style>
</head>
<body>

<div class="container form-container">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h3 class="mb-4 text-center fw-bold">Tambah Produk Baru</h3>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data" id="productForm" onsubmit="return handleFormSubmit(event)">
                <div class="mb-3">
                    <label for="nama" class="form-label fw-medium">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label fw-medium">Deskripsi <span class="text-danger">*</span></label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="link_shopee" class="form-label fw-medium">Link Shopee <span class="text-danger">*</span></label>
                    <input type="url" name="link_shopee" id="link_shopee" class="form-control" placeholder="https://shopee.co.id/produk-anda" required>
                </div>
                <div class="mb-4">
                    <label for="gambar" class="form-label fw-medium">Gambar Produk</label>
                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                    <div class="form-text">Format: JPG, PNG, GIF (Maks. 2MB)</div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2">
                        <i class="bi bi-save me-2"></i>Simpan
                    </button>
                    <a href="dashboard.php" class="btn btn-outline-secondary py-2">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
let formSubmitted = false;

function handleFormSubmit(e) {
    if (formSubmitted) {
        e.preventDefault();
        return false;
    }
    formSubmitted = true;
    return true;
}

function showSuccessPopup() {
    Swal.fire({
        title: "Sukses!",
        text: "Produk berhasil ditambahkan.",
        icon: "success",
        confirmButtonText: "OK",
        allowOutsideClick: false
    }).then(() => {
        window.location.href = "dashboard.php";
    });
}
</script>

</body>
</html>
