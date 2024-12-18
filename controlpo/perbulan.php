<?php
require 'function.php';
require 'cek.php';

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "controlpo");

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mendapatkan bulan dan tahun yang dipilih dari form (jika ada)
$selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Laporan Barang Masuk Per Bulan</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color:navy;">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">NamuraTehnikSejahtera</a>

        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-ligth" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="Perbulan.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-file"></i></i></div>
                            Laporan Perbulan
                        </a>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-folder"></i></div>
                            Data PO Barang 
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-people-carry-box"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                            Barang Keluar
                        </a>
                        <a class="nav-link" href="admin.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                            Kelola Admin
                        </a>
                        <a class="nav-link" href="logout.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-power-off"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Laporan Barang Masuk Per Bulan</h1>

                    <!-- Form untuk Memilih Bulan dan Tahun -->
                    <form method="GET" action="">
                        <div class="mb-3">
                            <label for="month" class="form-label">Pilih Bulan:</label>
                            <select name="month" id="month" class="form-select" required>
                                <option value="">--Pilih Bulan--</option>
                                <?php
                                for ($m = 1; $m <= 12; $m++) {
                                    $selected = ($m == $selectedMonth) ? 'selected' : '';
                                    echo "<option value='$m' $selected>" . date('F', mktime(0, 0, 0, $m, 1)) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Pilih Tahun:</label>
                            <select name="year" id="year" class="form-select" required>
                                <?php
                                $currentYear = date('Y');
                                for ($y = $currentYear; $y >= $currentYear - 5; $y--) {
                                    $selected = ($y == $selectedYear) ? 'selected' : '';
                                    echo "<option value='$y' $selected>$y</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Tampilkan Data</button>
                        <a href="exportperbulan.php" class="btn btn-info">Export Data</a>
                    </form>

                    <!-- Tabel Laporan Barang Masuk -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Rekap Laporan Barang Masuk Bulanan
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No PO</th>
                                        <th>Tanggal</th>
                                        <th>Nama Perusahaan</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Mengambil data barang masuk selama bulan dan tahun yang dipilih
                                    $query = "
                                        SELECT m.no_po, m.tanggal, m.nama_perusahaan, s.namabarang, m.qty
                                        FROM masuk m
                                        JOIN stock s ON m.id_barang = s.id_barang
                                        WHERE MONTH(m.tanggal) = $selectedMonth AND YEAR(m.tanggal) = $selectedYear
                                    ";
                                    $result = mysqli_query($conn, $query);

                                    // Memeriksa apakah query berhasil dieksekusi
                                    if (!$result) {
                                        die("Query gagal dijalankan: " . mysqli_error($conn));
                                    }

                                    // Mengecek jika ada data yang ditemukan
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($data = mysqli_fetch_array($result)) {
                                            $no_po = $data['no_po'];
                                            $tanggal = $data['tanggal'];
                                            $nama_perusahaan = $data['nama_perusahaan'];
                                            $namabarang = $data['namabarang'];
                                            $qty = $data['qty'];
                                    
                                            ?>
                                            <tr>
                                                <td><?=$no_po;?></td>
                                                <td><?=$tanggal;?></td>
                                                <td><?=$nama_perusahaan;?></td>
                                                <td><?=$namabarang;?></td>
                                                <td><?=$qty;?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>Tidak ada data untuk bulan ini.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; PT Namura Tehnik Sejahtera 2024</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
