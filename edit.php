<?php
include "koneksi/db.php";
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM
mahasiswa WHERE id=$id"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <h2>Edit Data Mahasiswa</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama</label>
            10
            <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
        </div>
        <div class="mb-3">
            <label>NIM</label>
            <input type="text" name="nim" class="form-control" value="<?= $data['nim'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="gambar" accept="image/*" class="form-control" value="<?= $data['gambar'] ?>" required>
        </div>
        <button type="submit" name="update" class="btn btn-warning">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
    <?php
    if (isset($_POST['update'])) {
        $nama = $_POST['nama'];
        $nim = $_POST['nim'];
        $file = $_FILES['gambar'];
        $namaFile = $file['name'];
        $pathGambar = "uploads/" . $namaFile;
        $tmpName = $file['tmp_name'];
        $folderTujuan = "uploads/";
        
        if(file_exists($data['gambar'])) {
            unlink($data['gambar']);
        }

        // Pastikan folder uploads/ ada
        if (!is_dir($folderTujuan)) {
            mkdir($folderTujuan, 0777, true);
        }

        // Simpan file
        if (move_uploaded_file($tmpName, $folderTujuan . $namaFile)) {
            echo "Upload berhasil!<br>";
            echo "<img src='uploads/$namaFile' width='300'>";
        } else {
            echo "Upload gagal.";
        }
        mysqli_query($conn, "UPDATE mahasiswa SET nama='$nama', 
nim='$nim', gambar='$pathGambar' WHERE id=$id");
        echo "<div class='alert alert-success mt-3'>Data berhasil diupdate.</div>
        <script>
 alert('Data Berhasil Diupdate')
 window.location.href = 'index.php'
 
 </script>";

    }
    ?>
</body>

</html>