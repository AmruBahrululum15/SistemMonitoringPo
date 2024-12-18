<?php
require 'function.php';
require 'cek.php';

?>
<html>
<head>
  <title>Laporan Stock Barang</title>
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
<div class="container">
			<h2>Control PO</h2>
			<h4>Stok Barang </h4>
				<div class="data-tables datatable-dark">
					
	
                    <table id="mauexport">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No PO</th>
                                            <th>Nama Barang</th>
                                            <th>Perusahaan</th>
                                            <th>Stock</th>
                                        
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
                <td><?php echo $no_po;?></td>
                <td><?php echo $namabarang;?></td>
                <td><?php echo $nama_perusahaan;?></td>
                <td><?php echo  $stok;?></td>
           </tr>  
         
               <?php 
               };
             ?>
                         </tbody>
                                </table>
					
				</div>
</div>
	
<script>
$(document).ready(function() {
    $('#mauexport').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
    } );
} );

</script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

	

</body>

</html>