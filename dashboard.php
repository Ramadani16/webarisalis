<?php

require 'db.php';

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: login.php');
    exit();

    
}

$query_admin = "SELECT id, username, password FROM admin";
$result_admin = $conn->query($query_admin);

$query = "SELECT * FROM produk";
$result = $conn->query($query);

$count_admin_query = "SELECT COUNT(*) as total_admin FROM admin";
$count_admin_result = $conn->query($count_admin_query);
$total_admin = ($count_admin_result->num_rows > 0) ? $count_admin_result->fetch_assoc()['total_admin'] : 0;

$count_produk_query = "SELECT COUNT(*) as total_produk FROM produk";
$count_produk_result = $conn->query($count_produk_query);
$total_produk = ($count_produk_result->num_rows > 0) ? $count_produk_result->fetch_assoc()['total_produk'] : 0;

$config = json_decode(file_get_contents(filename: "config.json"), true);

if (isset($_SESSION['pesan'])) 
    $pesan = $_SESSION['pesan'];
    unset($_SESSION['pesan']);

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard Admin - Kelola Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <style>
    body {
      overflow-x: hidden;
    }
    .sidebar-btn {
      width: 100%;
      text-align: left;
      padding: 10px 15px;
      border: none;
      background: none;
      font-size: 1rem;
      color: #000;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .sidebar-btn:hover {
      background-color: #f0f0f0;
      color: #007bff;
    }
    .page-section {
      display: none;
    }
    .page-section.active {
      display: block;
    }
    .min-vh-100 {
      min-height: 100vh;
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar Desktop -->
     <div class="col-md-3 d-none d-md-block bg-light min-vh-100 p-3 shadow">

      <h5 class="mb-4">Menu <span class="text-primary">Aplikasi</span></h5>
      <ul class="nav flex-column">
        <li class="nav-item mb-2">
          <button class="nav-link sidebar-btn" onclick="showPage('dashboard')">
            <i class="bi bi-speedometer2"></i> Dashboard
          </button>
        </li>
        <li class="nav-item mb-2">
          <button class="nav-link sidebar-btn" onclick="showPage('profile')">
            <i class="bi bi-person-circle"></i> User
          </button>
        </li>
        <li class="nav-item mb-2">
          <button class="nav-link sidebar-btn" onclick="showPage('produk')">
            <i class="bi bi-box-seam"></i> Produk
          </button>
        </li>
        <li class="nav-item mb-2">
          <button class="nav-link sidebar-btn" onclick="showPage('setting')">
          <i class="bi bi-gear"></i> Setting
          </button>
        </li>
        <li class="nav-item mt-4">
          <a href="logout.php" class="nav-link sidebar-btn logout-btn">
            <i class="bi bi-box-arrow-right"></i> Logout
          </a>
        </li>
      </ul>
    </div>

    <!-- Konten dan Sidebar Mobile -->
    <div class="col-md-9 p-4">
      <!-- Navbar Mobile -->
      <nav class="navbar navbar-light bg-light d-md-none mb-3">
        <div class="container-fluid">
          <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
            ☰ Menu
          </button>
          <span class="navbar-brand ms-2">My Website</span>
        </div>
      </nav>

      <!-- Sidebar Mobile (Offcanvas) -->
      <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title">Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column">
              <li class="nav-item">
                <button class="nav-link sidebar-btn" onclick="showPage('dashboard')">
                  <i class="bi bi-speedometer2"></i> Dashboard
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link sidebar-btn" onclick="showPage('profile')">
                  <i class="bi bi-person-circle"></i> User
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link sidebar-btn" onclick="showPage('produk')">
                  <i class="bi bi-box-seam"></i> Produk
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link sidebar-btn" onclick="showPage('setting')">
                  <i class="bi bi-gear"></i> Setting
                </button>
              </li>
              <li class="nav-item">
                <a href="logout.php" class="nav-link sidebar-btn">
                  <i class="bi bi-box-arrow-right"></i> Logout
                </a>
              </li>
            </ul>
          </div>

      </div>

      <!-- Konten Halaman -->
      <div id="dashboard" class="page-section active">
        <h3 class="mb-4">Dashboard</h3>

        <div class="row g-4">
          <!-- Card Jumlah Admin -->
          <div class="col-md-6">
            <div class="card border-0 text-white shadow" style="background: linear-gradient(135deg, #1e3c72, #2a5298);">
              <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                  <h5 class="card-title fw-semibold">Jumlah Admin</h5>
                  <h2 class="fw-bold"><?= $total_admin ?></h2>
                </div>
                <i class="bi bi-person-gear display-4"></i>
              </div>
            </div>
          </div>

          <!-- Card Jumlah Produk -->
          <div class="col-md-6">
            <div class="card border-0 text-white shadow" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
              <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                  <h5 class="card-title fw-semibold">Jumlah Produk</h5>
                  <h2 class="fw-bold"><?= $total_produk ?></h2>
                </div>
                <i class="bi bi-box-seam display-4"></i>
              </div>
            </div>
          </div>

          <!-- Grafik -->
          <div class="col-12">
            <div class="card border-0 shadow">
              <div class="card-body">
                <h5 class="card-title">Statistik Data</h5>
                <canvas id="statsChart" height="120"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>



      <div id="profile" class="page-section">
      <h3>Data Admin</h3>
      <div class="table-responsive mt-3">
        <table class="table table-bordered table-hover align-middle">
          <thead class="table-dark text-center">
            <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Password</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result_admin && $result_admin->num_rows > 0): ?>
              <?php while ($row = $result_admin->fetch_assoc()): ?>
                <tr>
                  <td class="text-center"><?= $row['id'] ?></td>
                  <td><?= htmlspecialchars($row['username']) ?></td>
                  <td><?= htmlspecialchars($row['password']) ?></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="3" class="text-center">Tidak ada data admin</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>


      <div id="produk" class="page-section">
        <h3>Kelola Produk</h3>

        <!-- Tombol Tambah Produk -->
        <div class="mb-3 text-end">
          <a href="tambah_produk.php" class="btn btn-success">+ Tambah Produk</a>
        </div>

        <div class="table-responsive mt-3">
          <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Link Shopee</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($result && $result->num_rows > 0): ?>
                <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                  <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                    <td class="text-center">
                      <?php if (!empty($row['gambar']) && file_exists('img/' . $row['gambar'])): ?>
                        <img src="img/<?= $row['gambar'] ?>" width="80" class="img-thumbnail" />
                      <?php else: ?>
                        <span class="text-muted">Tidak ada gambar</span>
                      <?php endif; ?>
                    </td>
                    <td class="text-center">
                      <?php if (!empty($row['link_shopee'])): ?>
                        <a href="<?= htmlspecialchars($row['link_shopee']) ?>" target="_blank" class="btn btn-sm btn-primary">Lihat di Shopee</a>
                      <?php else: ?>
                        <span class="text-muted">Belum diisi</span>
                      <?php endif; ?>
                    </td>
                    <td class="text-center">
                      <a href="edit_produk.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning me-1">Edit</a>
                      <a href="hapus_produk.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr><td colspan="6" class="text-center">Tidak ada produk</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        
      </div>
      <div id="setting" class="page-section">
      
        <h3>Pengaturan Akun</h3>
          <form action="update_setting.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($config['username']) ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Foto Profil</label><br>
              <img src="img/<?= $config['foto'] ?>" width="100" class="img-thumbnail mb-2"><br>
              <input type="file" name="foto" accept="image/*" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
          </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
Swal.fire({
    icon: 'success',
    title: 'Sukses!',
    text: '<?= $pesan ?>',
    confirmButtonText: 'OK',
    confirmButtonColor: '#7e57c2' // ungu seperti contohmu
});
</script>
<script>
const ctx = document.getElementById('statsChart').getContext('2d');
const statsChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Admin', 'Produk'],
    datasets: [{
      label: 'Jumlah Data',
      data: [<?= $total_admin ?>, <?= $total_produk ?>],
      backgroundColor: [
        'rgba(30, 60, 114, 0.8)',
        'rgba(17, 153, 142, 0.8)'
      ],
      borderRadius: 8,
      borderSkipped: false
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false },
      tooltip: { backgroundColor: '#333', titleColor: '#fff', bodyColor: '#fff' }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: { stepSize: 1 }
      }
    }
  }
});

</script>

<script>
function showPage(pageId) {
  // Menampilkan section yang dipilih
  const sections = document.querySelectorAll('.page-section');
  sections.forEach(section => {
    section.classList.remove('active');
  });

  const selected = document.getElementById(pageId);
  if (selected) {
    selected.classList.add('active');
  }

  // Menutup offcanvas jika sedang terbuka (khusus mobile)
  const offcanvasElement = document.getElementById('mobileSidebar');
  const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
  if (bsOffcanvas) {
    bsOffcanvas.hide();
  }
}
</script>

</body>
</html>
