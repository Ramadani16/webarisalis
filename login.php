<?php
require 'db.php';


if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // Jika password disimpan pakai SHA2
        if (hash('sha256', $password) === $row['password']) {
            $_SESSION['admin_logged'] = true;
            $_SESSION['admin_name'] = $username;
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Password salah.';
        }

    } else {
        $error = 'Username tidak ditemukan.';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            background: linear-gradient(135deg, #667eea,rgb(162, 75, 162));
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            width: 90%;
            max-width: 400px;
            padding: 2rem;
            border-radius: 1rem;
            background: white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .form-icon {
            font-size: 1.2rem;
            color: #764ba2;
        }
        h2 {
            color: #764ba2;
            margin-bottom: 1.5rem;
            font-weight: 700;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h2><i class="bi bi-shield-lock-fill"></i> Login</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="POST" autocomplete="off">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person-fill form-icon"></i></span>
                <input type="text" class="form-control" id="username" name="username" required placeholder="Masukkan username">
            </div>
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-key-fill form-icon"></i></span>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan password">
            </div>
        </div>
        <button type="submit" class="btn btn-gradient w-100" style="background: linear-gradient(90deg,#764ba2,#667eea); color:white; font-weight:bold;">
            <i class="bi bi-box-arrow-in-right"></i> Login
        </button>
    </form>
</div>

<!-- Bootstrap JS Bundle (Popper.js included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
