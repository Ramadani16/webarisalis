<?php
$config = json_decode(file_get_contents("config.json"), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Arisalis</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background-image: url('/img/background.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .main-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 60px 15px 100px; /* bottom padding untuk footer */
      text-align: center;
    }

    .profile-img {
      width: 150px;
      height: 150px;
      object-position: 50% 15%;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      margin-bottom: 15px;
    }

    .username {
      font-size: 28px;
      font-weight: bold;
      margin-top: 15px;
      color: black;
      -webkit-text-stroke: 0.1px rgb(0, 0, 0);
    }

    .btn-linktree {
      background-color: white;
      border: none;
      border-radius: 50px;
      padding: 12px;
      margin: 10px auto;
      width: 80%;
      max-width: 350px;
      font-size: 16px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
      display: block;
    }

    .btn-linktree:hover {
      transform: scale(1.02);
    }

    footer {
      background-color: rgb(11, 34, 56);
      color: white;
      text-align: center;
      padding: 10px 15px;
      font-size: 13px;
      position: relative;
    }

    footer a {
      color: #ffdd57;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    footer a:hover {
      text-shadow: 0 0 5px white;
    }

    .social-icons a {
      margin: 0 10px;
      font-size: 20px;
    }

    @media (max-width: 576px) {
      .username {
        font-size: 24px;
      }

      .btn-linktree {
        font-size: 14px;
        padding: 10px;
      }
    }
  </style>
</head>
<body>

  <div class="main-content">
    <img src="img/<?= htmlspecialchars($config['foto']) ?>" alt="Foto Profil" class="profile-img">
    <div class="username">@<?= htmlspecialchars($config['username']) ?></div>

    <!-- Tombol link -->
    <a href="produk.php" class="btn btn-linktree">Produk</a>
    <a href="https://www.facebook.com/ari.salispartii" class="btn btn-linktree">Facebook</a>
    <a href="https://www.instagram.com/ari.salis?igsh=MTRyNXhxODhyeTd1Mg==" class="btn btn-linktree">Instagram</a>
    <a href="https://www.tiktok.com/@ari.salis?_t=ZS-8waxFe80nxw&_r=1" class="btn btn-linktree">TikTok</a>
  </div>

  <!-- Footer -->
  <footer>
    <p style="margin-bottom: 5px;">Credit By Ramadani</p>
    <p>
      <a href="https://mail.google.com/mail/?view=cm&fs=1&to=rmadani1602@gmail.com&su=Permintaan%20Website&body=Halo%20Ramadani,%20saya%20butuh%20website."
        target="_blank">
        Contact Me
      </a>
    </p>
    <div class="social-icons mt-2">
      <a href="https://www.instagram.com/rma_dani16?igsh=ZHN6enVvZG8xcG41" target="_blank" style="color:#E1306C;">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="https://github.com/Ramadani16" target="_blank" style="color:#fff;">
        <i class="fab fa-github"></i>
      </a>
      <a href="https://linkedin.com/in/username" target="_blank" style="color:#0A66C2;">
        <i class="fab fa-linkedin"></i>
      </a>
    </div>
  </footer>

</body>
</html>
