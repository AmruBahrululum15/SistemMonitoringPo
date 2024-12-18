<?php
require 'function.php';
require 'cek.php';
?>

<!DOCTYPE html>
<div lang="en">
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js" integrity="sha512-zP5W8791v1A6FToy+viyoyUUyjCzx+4K8XZCKzW28AnCoepPNIXecxh9mvGuy3Rt78OzEsU+VCvcObwAMvBAww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>
    <body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color: navy;">
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
                        <h1 class="mt-4">Data PO Barang </h1>
                    
                        <div class="card mb-4">
                            <div class="card-header">
                           
                         <div class="card-header d-flex justify-content-between">
         <div>
        <!-- Tombol Tambah Barang -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
            Tambah Barang
        </button>
    </div>
    <?php
   // Mulai session dan output buffering

  ob_start();
    ?>
     <div class="d-flex">
        <!-- Tombol Upload Dokumen -->

        <form action="" method="POST" enctype="multipart/form-data" class="me-2">
            <input type="file" name="NamaFile" class="form-control form-control-sm" style="display: inline-block; width: auto;">
            <input type="submit" name="proses" value="Upload" class="btn btn-secondary btn-sm">
        </form>
        <?php
  $conn = mysqli_connect("localhost", "root", "", "controlpo");

  if (isset($_POST['proses'])) {

    $direktori = "PO Masuk/";
    $file_name = $_FILES['NamaFile']['name'];
    
    // Cek apakah file berhasil diunggah
    if (move_uploaded_file($_FILES['NamaFile']['tmp_name'], $direktori . $file_name)) {
        // Simpan pesan keberhasilan di session
        $_SESSION['pesan'] = "File berhasil diunggah.";

        // Masukkan data ke dalam database
        $upload = mysqli_query($conn, "INSERT INTO upload (namafile) VALUES ('$file_name')");
        if ($upload) {
            // Jika sukses, redirect dan tampilkan pesan
            header("Location: " . $_SERVER['PHP_SELF']);
            exit(); // Hentikan eksekusi script setelah redirect
        } else {
            echo "Kesalahan saat mengunggah ke database: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal mengunggah file.";
    }
}

// Tampilkan pesan jika ada
if (isset($_SESSION['pesan'])) {
    echo "<b>" . $_SESSION['pesan'] . "</b>";
    unset($_SESSION['pesan']); // Hapus pesan setelah ditampilkan
 }

// Kirim output buffer ke browser
 ob_end_flush();
 ?>
        <!-- Tombol Export Data -->
        <a href="export.php" class="btn btn-info btn-sm">Export Data</a>
    </div>
</div>

                         
    

                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No PO</th>
                                            <th>Nama Barang</th>
                                            <th>Perusahaan</th>
                                            <th>Stock</th>
                                            <th>Aksi</th>
                                            
                                        </tr>
                                    </thead>
                                    
                                    <tbody>

                  <?php
               
              $ambilsemuadatanya = mysqli_query($conn,"select * from stock");
              $i = 1;
                 while($data=mysqli_fetch_array($ambilsemuadatanya)){
                $no_po = $data['no_po'];
                $namabarang = $data['namabarang'];
               $nama_perusahaan = $data['nama_perusahaan'];
               $stok = $data['stok'];
               $idb = $data['id_barang'];
              ?>
            <tr>
                <td><?=$i++;?></td>
                <td><?=$no_po;?></td>
                <td><?=$namabarang;?></td>
                <td><?=$nama_perusahaan;?></td>
                <td><?=$stok;?></td>
                <td>
                     <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#Edit<?=$idb;?>">
                     Edit
                     </button>
                    
                     <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Delete<?=$idb;?>">
                      Delete
                </td>
           </tr>  
         <!--edit modal -->

           <div class="modal fade" id="Edit<?=$idb;?>">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Barang</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      
      <!-- Modal body -->
<form method="post">
    <div class="modal-body">
        <input type="text" name="no_po"value="<?=$no_po;?>" class="form-control" required>
        <br>
        <input type="text" name="nama_barang" value="<?=$namabarang;?>" class="form-control" required>
        <br>
        <input type="text" name="nama_perusahaan" value="<?=$nama_perusahaan;?>" class="form-control" required>
        <br>
        <input type="number" name="stok" value="<?=$stok;?>" class="form-control" required>
        <br>
        <input type="hidden" name="idb" value="<?=$idb;?>">
        <button type="submit" class="btn btn-primary" name="updatebarang">Submit</button>
    </div>
    </form>


    </div>
  </div>
    </div>

          <!--delete modal -->
          <div class="modal fade" id="Delete<?=$idb;?>">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Hapus Barang </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      
      <!-- Modal body -->
<form method="post">
    <div class="modal-body">
        
       apakah anda yakin ingin menghapus <?=$namabarang;?>?
        <br>
        <br>
        <input type="hidden" name="idb" value="<?=$idb;?>">
        <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
    </div>
    </form>


    </div>
  </div>
    </div>
               <?php 
               };
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
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Barang</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
<form method="post">
    <div class="modal-body">
        <input type="text" name="no_po" placeholder="no po" class="form-control" required>
        <br>
        <input type="text" name="nama_barang" placeholder="nama barang" class="form-control" required>
        <br>
        <input type="text" name="nama_perusahaan" placeholder="nama perusahaan" class="form-control" required>
        <br>
        <input type="number" name="stok" class="form-control" placeholder="stok" required>
        <br>
        <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
    </div>
    </form>


    </div>
  </div>
</div>

</html>
