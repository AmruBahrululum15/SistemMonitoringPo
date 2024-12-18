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
        <title>Kelola Admin</title>
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
                        <h1 class="mt-4">kelola Admin</h1>
                    
                        <div class="card mb-4">
                            <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                          tambah Admin
                         </button>
                         
                            </div>
                        
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>email admin</th>
                                            
                                            <th>Aksi</th>
                                            
                                        </tr>
                                    </thead>
                                    
                                    <tbody>

                  <?php
               
              $ambilsemuadataadmin = mysqli_query($conn,"select * from login");
              $i = 1;
                 while($data=mysqli_fetch_array($ambilsemuadataadmin)){
                $em = $data['email'];
                $iduser = $data['iduser'];
                $pw = $data ['password'];
               
              ?>
            <tr>
                <td><?=$i++;?></td>
                <td><?=$em;?></td>
               
                <td>
                     <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#Edit<?=$iduser;?>">
                     Edit
                     </button>
                    
                     <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Delete<?=$iduser;?>">
                      Delete
                </td>
           </tr>  
         <!--edit modal -->

           <div class="modal fade" id="Edit<?=$iduser;?>">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Admin</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      
      <!-- Modal body -->
<form method="post">
    <div class="modal-body">
        <input type="email" name="emailadmin"value="<?=$em;?>" class="form-control" placeholder="Email" required>
        <br>
        <input type="password" name="passwordbaru" value="<?=$pw;?>" class="form-control" placeholder="password">
        
        <br>
        <input type="hidden" name="iduser" value="<?=$iduser;?>">
        <button type="submit" class="btn btn-primary" name="updateadmin">Submit</button>
    </div>
    </form>


    </div>
  </div>
    </div>

          <!--delete modal -->
          <div class="modal fade" id="Delete<?=$iduser;?>">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Hapus admin </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      
      <!-- Modal body -->
<form method="post">
    <div class="modal-body">
        
       apakah anda yakin ingin menghapus <?=$em;?>?
        <br>
        <br>
        <input type="hidden" name="iduser" value="<?=$iduser;?>">
        <button type="submit" class="btn btn-danger" name="hapusadmin">Hapus</button>
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
        <h4 class="modal-title">Tambah Admin</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
<form method="post">
    <div class="modal-body">
    
        <input type="email" name="email" placeholder="Email" class="form-control" required>
        <br>
        <input type="password" name="password" class="form-control" placeholder="password" required>
        <br>
        <button type="submit" class="btn btn-primary" name="addadmin">Submit</button>
    </div>
    </form>


    </div>
  </div>
</div>

</html>
