<?php
// Mulai session
session_start();
?>

<form action="" method="POST" enctype="multipart/form-data">
  <b>Upload Dokumen</b> <input type="file" name="NamaFile">
  <input type="submit" name="proses" value="Upload">
</form>

<?php
$conn = mysqli_connect("localhost", "root", "", "controlpo");

if (isset($_POST['proses'])) {

    $direktori = "berkas/";
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
?>
