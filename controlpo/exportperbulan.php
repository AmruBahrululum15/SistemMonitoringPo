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
<html>
<head>
  <title> Rekap Laporan Barang Masuk Bulanan</title>
  
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
			<h2>PT.Namura Tehnik Sejahtera</h2>
			<h4>Rekap Laporan Barang Masuk Bulanan </h4>
				<div class="data-tables datatable-dark">
					
	
                    <table id="mauexport">
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