<?php
require 'function.php';
require 'cek.php';

// Database connection
$conn = mysqli_connect("localhost", "root", "", "controlpo");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the total quantity of items per company for the current month
$query = "
    SELECT 
        nama_perusahaan, 
        SUM(stok) AS total_stok 
    FROM stock 
    WHERE MONTH(CURDATE()) = MONTH(NOW()) 
    GROUP BY nama_perusahaan
";
$result = mysqli_query($conn, $query);

// Prepare data for the chart
$companies = [];
$totalQuantities = [];
while ($row = mysqli_fetch_assoc($result)) {
    $companies[] = $row['nama_perusahaan'];
    $totalQuantities[] = $row['total_stok'];
}

// Prepare data for the donut chart
$query_donut = "
    SELECT 
        namabarang, 
        SUM(stok) AS total_stok 
    FROM stock 
    WHERE MONTH(CURDATE()) = MONTH(NOW())
    GROUP BY namabarang
";
$result_donut = mysqli_query($conn, $query_donut);

$donut_labels = [];
$donut_data = [];
while ($row = mysqli_fetch_assoc($result_donut)) {
    $donut_labels[] = $row['namabarang'];
    $donut_data[] = (int)$row['total_stok'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Stock Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="sb-nav-fixed">
<<nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color: navy;">
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
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-file"></i></div>
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
                    <h1 class="mt-4">Dashboard Control PO</h1>

                    <!-- Chart Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Total Kuantitas Barang Per Perusahaan
                        </div>
                        <div class="card-body">
                            <canvas id="quantityChart"></canvas>
                        </div>
                    </div>

                    <!-- Donut Chart Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-pie me-1"></i>
                            Donut Chart Per Item
                        </div>
                        <div class="card-body">
                            <canvas id="donutChart" width="10" height="10"></canvas> <!-- Ukuran Donut Chart -->
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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script>
        // Chart.js configuration for Quantity Chart
        const labels = <?php echo json_encode($companies); ?>;
        const data = {
            labels: labels,
            datasets: [{
                label: 'Total Kuantitas',
                data: <?php echo json_encode($totalQuantities); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        const quantityChart = new Chart(
            document.getElementById('quantityChart'),
            config
        );

        // Donut Chart configuration
        const donutLabels = <?php echo json_encode($donut_labels); ?>;
        const donutData = {
            labels: donutLabels,
            datasets: [{
                label: 'Total Kuantitas Per Item',
                data: <?php echo json_encode($donut_data); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(153, 102, 255, 1)',
                ],
                borderWidth: 1
            }]
        };
        const donutConfig = {
            type: 'doughnut',
            data: donutData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Donut Chart Qty Per Item'
                    }
                }
            }
        };
        const donutChart = new Chart(
            document.getElementById('donutChart'),
            donutConfig
        );
    </script>
</body>
</html>
