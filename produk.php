<?php
// Tidak perlu session_start karena tidak memakai keranjang

// Koneksi ke database MySQL
$host = "localhost";
$user = "root";
$pass = "";
$db   = "arisalis";

$koneksi = new mysqli($host, $user, $pass, $db);
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$cari = isset($_GET['cari']) ? $koneksi->real_escape_string($_GET['cari']) : '';
if (!empty($cari)) {
    $sql = "SELECT * FROM produk WHERE nama LIKE '%$cari%' OR deskripsi LIKE '%$cari%'";
} else {
    $sql = "SELECT * FROM produk";
}


$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Ari Salis Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

  
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
    html, body {
  height: 100%;
}

.wrapper {
  min-height: 100%;
  display: flex;
  flex-direction: column;
}

.content {
  flex: 1;
}
main {
    min-height: calc(100vh - 200px); /* 200px disesuaikan tinggi header + footer */
}

    /* Navbar background dan shadow */
.navbar {
  background: linear-gradient(90deg, #667eea, #764ba2);
  box-shadow: 0 4px 15px rgba(118, 75, 162, 0.4);
  transition: background 0.4s ease;
}

/* Navbar brand */
.navbar-brand {
  color: white;
  font-weight: 700;
  font-size: 1.6rem;
  letter-spacing: 2px;
  transition: color 0.3s ease;
}
.navbar-brand:hover {
  color: #ffdd57;
  text-shadow: 0 0 8px #ffdd57;
}

/* Menu navigasi */


/* Hover efek warna dan underline animasi */
.nav-link:hover,
.nav-link.active {
  color: #ffdd57;
  font-weight: 700;
  font-size: 22px;
}

.nav-link::after {
  content: "";
  position: absolute;
  width: 0%;
  height: 3px;
  bottom: 0;
  left: 0;
  background-color: #ffdd57;
  transition: width 0.3s ease;
  border-radius: 2px;
}

.nav-link:hover::after,
.nav-link.active::after {
  width: 100%;
}

/* Responsif untuk container */
.container {
  max-width: 1140px;
}

/* Cursor pointer untuk item */
.nav-link {
  cursor: pointer;
}
input.form-control:focus {
  box-shadow: 0 0 10px rgba(102, 126, 234, 0.7);
  border-color: #667eea;
}

.btn-primary {
  background: linear-gradient(90deg,rgb(165, 170, 192),rgb(165, 153, 177));
  border: none;
  transition: 0.3s;
}

.btn-primary:hover {
  background: linear-gradient(90deg, #764ba2,rgb(245, 245, 245));
}

    .card-img-top {
      aspect-ratio: 3 / 3;
      object-fit: cover;
      width: 100%;
      height: auto;
    }

    .card {
      transition: transform 0.3s ease;
      height: 100%;
      display: flex;
      flex-direction: column;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card-body {
      display: flex;
      flex-direction: column;
    }

    .card-text.description {
      max-height: 100px;
      overflow-y: auto;
      font-size: 0.9rem;
    }

    .collapse:not(.show) {
      display: none !important;
    }
   footer {
      background-color:rgb(11, 34, 56);
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
<div class="wrapper">

<nav class="navbar navbar-light bg-light sticky-top shadow-sm">
  <div class="container d-flex justify-content-between align-items-center">
    <a class="navbar-brand fw-bold" href="produk.php">ARI STORE</a>

    <!-- Menu navigasi -->
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link active" href="index.php">Home</a>
      </li>
      <!-- Kamu bisa tambah menu lain di sini -->
    </ul>
  </div>
</nav>

<form method="GET" class="mb-4">
  <div class="input-group">
    <input type="text" name="cari" class="form-control" placeholder="Cari produk..." value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '' ?>">
    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Cari</button>
  </div>
</form>
<main class="content">
<div class="container my-4" >
  <div class="row">
    <?php if ($result->num_rows > 0): ?>
      <?php while ($produk = $result->fetch_assoc()): ?>
        <div class="col-6 col-sm-4 col-md-3 mb-4">
          <div class="card h-100 shadow-sm">
            <img src="img/<?= htmlspecialchars($produk['gambar']) ?>" class="card-img-top" alt="<?= htmlspecialchars($produk['nama']) ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($produk['nama']) ?></h5>

              <!-- Tombol Detail -->
              <button class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1 p-1 mb-2"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#desc<?= $produk['id'] ?>"
                aria-expanded="false"
                aria-controls="desc<?= $produk['id'] ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-info-circle" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 
                  1.319.545 0 .877-.252 1.02-.598l.088-.416c.07-.32.07-.513.005-.686-.066-.173-.224-.348-.63-.348-.196 
                  0-.387.08-.538.17l.01-.097 1.293-5.349z"/>
                  <circle cx="8" cy="4.5" r="1"/>
                </svg>
                Detail
              </button>

              <!-- Deskripsi collapsible -->
              <div class="collapse" id="desc<?= $produk['id'] ?>">
                <p class="card-text description"><?= nl2br(htmlspecialchars($produk['deskripsi'])) ?></p>
              </div>

              <!-- Tombol ke Shopee -->
              <?php if (!empty($produk['link_shopee'])): ?>
                <a href="<?= htmlspecialchars($produk['link_shopee']) ?>" target="_blank" class="btn btn-warning w-100 mt-auto">
                  🔗Check Out
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-center">Belum ada produk tersedia.</p>
    <?php endif; ?>
  </div>

  
</div>
</main>
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
 <script>
    const searchInput = document.querySelector('input[name="cari"]');
    searchInput.addEventListener('input', function() {
        if (this.value.trim() === '') {
            window.location.href = window.location.pathname; // reload halaman tanpa query
        }
    });
</script>


<script>
  document.querySelectorAll('button[data-bs-toggle="collapse"]').forEach(button => {
    button.addEventListener('click', () => {
      const targetId = button.getAttribute('data-bs-target');
      document.querySelectorAll('.collapse.show').forEach(openCollapse => {
        if ('#' + openCollapse.id !== targetId) {
          const bsCollapse = bootstrap.Collapse.getInstance(openCollapse);
          if (bsCollapse) {
            bsCollapse.hide();
          }
        }
      });
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
