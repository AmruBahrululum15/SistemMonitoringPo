<?php  
session_start();
// membuat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "controlpo");

// menambah barang baru
if(isset($_POST['addnewbarang'])){
    $no_po = $_POST['no_po'];
    $namabarang = $_POST['nama_barang'];
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $stok = $_POST['stok'];
      
    $addtotable = mysqli_query($conn, "INSERT INTO stock (no_po, namabarang, nama_perusahaan, stok) VALUES ('$no_po', '$namabarang', '$nama_perusahaan', '$stok')");

    if($addtotable){
        header('location:index.php');
        exit();
    } 
}

// barang masuk
if (isset($_POST['barangmasuk'])) {
    $barangnya = $_POST['barangnya'];           
    $no_po = $_POST['no_po'];                  
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $qty = $_POST['qty'];

    // Ambil stok saat ini dari tabel stock berdasarkan id_barang
    $cekstoksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE id_barang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstoksekarang);

    // Pastikan kolom 'stok' ada dan ambil nilainya
    if (isset($ambildatanya['stok'])) {
        $stoksekarang = $ambildatanya['stok'];
        $tambahkanstoksekarangdenganquantity = $stoksekarang - $qty; // Menambahkan stok

        // Query untuk memasukkan data ke tabel masuk
        $addtomasuk = mysqli_query($conn, "INSERT INTO masuk (no_po, id_barang, nama_perusahaan, qty) VALUES ('$no_po','$barangnya', '$nama_perusahaan','$qty')");
        
        // Perbarui stok barang yang sesuai berdasarkan id_barang
        $updatestokmasuk = mysqli_query($conn, "UPDATE stock SET stok='$tambahkanstoksekarangdenganquantity' WHERE id_barang='$barangnya'");

        // Cek apakah kedua query berhasil
        if ($addtomasuk && $updatestokmasuk) {
            header('location:index.php');
            exit(); // Pastikan skrip berhenti setelah pengalihan
        } else {
            echo 'Gagal: ' . mysqli_error($conn);
        }
    } else {
        echo 'Gagal: Kolom stok tidak ditemukan.';
    }
}

// barang keluar
if (isset($_POST['barangkeluar'])) {
    $barangnya = $_POST['barangnya']; // ID barang
    $pengirim = $_POST['pengirim'];
    $qty = $_POST['qty']; // Jumlah barang yang dikeluarkan

    // Ambil qty saat ini dari tabel masuk berdasarkan id_barang
    $cekstokmasuk = mysqli_query($conn, "SELECT * FROM masuk WHERE id_barang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstokmasuk);

    // Pastikan kolom 'qty' ada dan ambil nilainya
    if (isset($ambildatanya['qty'])) {
        $qtymasuk = $ambildatanya['qty']; // Ambil jumlah dari tabel masuk
        
        // Pastikan qty di tabel masuk mencukupi untuk dikeluarkan
        if ($qtymasuk >= $qty) {
            $kuranginstok = $qtymasuk - $qty; // Hitung sisa qty setelah dikeluarkan

            // Query untuk memasukkan data ke tabel keluar
            $addtokeluar = mysqli_query($conn, "INSERT INTO keluar (id_barang, pengirim, qty) VALUES ('$barangnya', '$pengirim','$qty')");
            
            // Perbarui qty di tabel masuk
            $updatemasuk = mysqli_query($conn, "UPDATE masuk SET qty='$kuranginstok' WHERE id_barang='$barangnya'");
            
            if ($addtokeluar && $updatemasuk) {
                header('location:index.php');
                exit();
            } else {
                echo 'Gagal: ' . mysqli_error($conn);
            }
        } else {
            // Jika qty tidak mencukupi, beri pesan peringatan
            echo '
            <script>
            alert("Stok tidak mencukupi di tabel masuk!");
            window.location.href="keluar.php";
            </script>
            ';
        }
    } else {
        echo 'Gagal: Kolom qty tidak ditemukan di tabel masuk.';
    }
}

// Update Info Barang
if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $no_po = $_POST['no_po'];
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $stok = $_POST['stok'];
    $update = mysqli_query($conn, "UPDATE stock SET no_po='$no_po', nama_perusahaan='$nama_perusahaan', stok='$stok' WHERE id_barang='$idb'");
    if($update){
        header('location:index.php');
        exit();
    } else {
        echo 'Gagal: ' . mysqli_error($conn);
    }
} 

// Menghapus barang dari stock
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];
    $hapus = mysqli_query($conn, "DELETE FROM stock WHERE id_barang='$idb'");

    if($hapus){
        header('location:index.php');
        exit();
    } else {
        echo 'Gagal: ' . mysqli_error($conn);
    }
} 

// Edit barang masuk
if(isset($_POST['updatebarangmasuk'])) {
    $idb = $_POST['idb'];    
    $idm = $_POST['idm'];    
    $no_po = $_POST['no_po']; 
    $qty = $_POST['qty'];

    // Ambil detail stok saat ini
    $lihatstok = mysqli_query($conn, "SELECT * FROM stock WHERE id_barang='$idb'");
    $stoknya = mysqli_fetch_array($lihatstok);
    if (isset($stoknya['stok'])) {
        $stokskrng = $stoknya['stok'];
    } else {
        echo "Gagal: Kolom stok tidak ditemukan.";
        exit;
    }

    // Ambil qty barang masuk saat ini
    $qtyskrng_query = mysqli_query($conn, "SELECT qty FROM masuk WHERE idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrng_query);
    if (isset($qtynya['qty'])) {
        $qtyskrng = $qtynya['qty'];
    } else {
        echo "Gagal: Kolom qty tidak ditemukan.";
        exit;
    }

    if($qty > $qtyskrng) {
        $selisih = $qty - $qtyskrng; // Selisih antara qty baru dan lama
        $kurangin = $stokskrng + $selisih; // Perbarui stok sesuai dengan selisih

        // Perbarui tabel stok dan tabel masuk
        $kuranginstoknya = mysqli_query($conn, "UPDATE stock SET stok='$kurangin' WHERE id_barang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE masuk SET qty='$qty', no_po='$no_po' WHERE idmasuk='$idm'");

        if($kuranginstoknya && $updatenya) {
            header('location:masuk.php');
            exit();
        } else {
            echo 'Gagal: ' . mysqli_error($conn);
        }
    } else {
        $selisih = $qtyskrng - $qty;
        $kurangin = $stokskrng - $selisih;

        $kuranginstoknya = mysqli_query($conn, "UPDATE stock SET stok='$kurangin' WHERE id_barang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE masuk SET qty='$qty', no_po='$no_po' WHERE idmasuk='$idm'");

        if ($kuranginstoknya && $updatenya) {
            header('location:masuk.php');
            exit();
        } else {
            echo 'Gagal: ' . mysqli_error($conn);
        }
    }
}

// Hapus barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    
    // Ambil qty dari tabel masuk yang akan dihapus
    $getQtyMasuk = mysqli_query($conn, "SELECT qty FROM masuk WHERE idmasuk='$idm'");
    $dataQty = mysqli_fetch_array($getQtyMasuk);
    
    if (isset($dataQty['qty'])) {
        $qty = $dataQty['qty']; // Ambil qty yang dihapus

        // Ambil data stok saat ini
        $getdatastok = mysqli_query($conn, "SELECT * FROM stock WHERE id_barang='$idb'");
        $data = mysqli_fetch_array($getdatastok);
        
        // Pastikan kita punya data stok
        if (isset($data['stok'])) {
            $stok = $data['stok'];
            
            // Tambahkan kembali qty yang dihapus ke stok
            $selisih = $stok + $qty;

            // Update stok di tabel stock
            $update = mysqli_query($conn, "UPDATE stock SET stok='$selisih' WHERE id_barang='$idb'");
            if (!$update) {
                echo 'Gagal: ' . mysqli_error($conn);
                exit();
            }

            // Hapus record dari tabel masuk
            $hapus = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk='$idm'");
            if ($hapus) {
                header('location:masuk.php');
                exit();
            } else {
                echo 'Gagal: ' . mysqli_error($conn);
            }
        } else {
            echo 'Gagal: Data stok tidak ditemukan.';
        }
    } else {
        echo 'Gagal: Kolom qty tidak ditemukan di tabel masuk.';
    }
}
 // Edit barang keluar
if(isset($_POST['updatebarangkeluar'])) {
    $idb = $_POST['idb'];    // ID Barang
    $idk = $_POST['idk'];    // ID Keluar
    $qty = $_POST['qty'];    // Jumlah yang baru

    // Ambil stok saat ini di tabel masuk
    $lihatstok = mysqli_query($conn, "SELECT * FROM stock WHERE id_barang='$idb'");
    $stoknya = mysqli_fetch_array($lihatstok);
    $stokskrng = $stoknya['stok'];

    // Ambil qty barang keluar yang lama
    $qtyskrng_query = mysqli_query($conn, "SELECT qty FROM keluar WHERE idkeluar='$idk'");
    $qtykeluarskrng = mysqli_fetch_array($qtyskrng_query);
    $qtykeluarskrng = $qtykeluarskrng['qty'];

    if($qty > $qtykeluarskrng) {
        $selisih = $qty - $qtykeluarskrng; // Selisih antara qty baru dan lama
        $kuranginstok = $stokskrng - $selisih; // Kurangi stok sesuai dengan selisih

        // Perbarui tabel stok dan tabel keluar
        $updatestok = mysqli_query($conn, "UPDATE stock SET stok='$kuranginstok' WHERE id_barang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE keluar SET qty='$qty' WHERE idkeluar='$idk'");

        if($updatestok && $updatenya) {
            header('location:keluar.php');
            exit();
        } else {
            echo 'Gagal: ' . mysqli_error($conn);
        }
    } else {
        $selisih = $qtykeluarskrng - $qty;
        $tambahinstok = $stokskrng + $selisih; // Tambahkan stok kembali

        $updatestok = mysqli_query($conn, "UPDATE stock SET stok='$tambahinstok' WHERE id_barang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE keluar SET qty='$qty' WHERE idkeluar='$idk'");

        if ($updatestok && $updatenya) {
            header('location:keluar.php');
            exit();
        } else {
            echo 'Gagal: ' . mysqli_error($conn);
        }
    }
}// Hapus barang keluar
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];  // ID Barang
    $idk = $_POST['idk'];  // ID Keluar

    // Ambil qty barang keluar yang akan dihapus
    $getQtyKeluar = mysqli_query($conn, "SELECT qty FROM keluar WHERE idkeluar='$idk'");
    $dataQtyKeluar = mysqli_fetch_array($getQtyKeluar);
    $qtykeluar = $dataQtyKeluar['qty']; // Jumlah barang yang dikeluarkan

    // Ambil data stok saat ini
    $getdatastok = mysqli_query($conn, "SELECT * FROM stock WHERE id_barang='$idb'");
    $data = mysqli_fetch_array($getdatastok);
    $stok = $data['stok'];

    // Tambahkan kembali qty yang dikeluarkan ke stok
    $selisih = $stok + $qtykeluar;

    // Update stok di tabel stock
    $updatestok = mysqli_query($conn, "UPDATE stock SET stok='$selisih' WHERE id_barang='$idb'");
    if (!$updatestok) {
        echo 'Gagal: ' . mysqli_error($conn);
        exit();
    }

    // Hapus record dari tabel keluar
    $hapus = mysqli_query($conn, "DELETE FROM keluar WHERE idkeluar='$idk'");
    if ($hapus) {
        header('location:keluar.php');
        exit();
    } else {
        echo 'Gagal: ' . mysqli_error($conn);
    }
}

      //Menambah Admin Baru 
      if(isset($_POST['addadmin'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $queryinsert = mysqli_query($conn,"insert into login (email,password) values ('$email','$password')");

        if($queryinsert){
            //if berhasil
            header('location:admin.php');
        } else {
            //if gagal 
            header('location:admin.php');
        }
    }

    //edit data admin
 
    if(isset($_POST['updateadmin'])){
        $emailbaru = $_POST['emailadmin'];
        $passwordbaru = $_POST['passwordbaru'];
        $iduser = $_POST['iduser'];

        $queryupdate = mysqli_query($conn,"update login set email='$emailbaru',password='$passwordbaru' where iduser='$iduser'");

        if($queryupdate){
            //if berhasil
            header('location:admin.php');
        } else {
            //if gagal 
            header('location:admin.php');
        }
    }
        // hapus admin
        if(isset($_POST['hapusadmin'])){
            $iduser = $_POST['iduser'];

            $querydelete = mysqli_query($conn,"delete from login where iduser='$iduser'");
        
        if($querydelete){
            //if berhasil
            header('location:admin.php');
        } else {
            //if gagal 
            header('location:admin.php');
        }
    }
     
   ?>
