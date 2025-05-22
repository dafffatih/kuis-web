<?php include "koneksi/db.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tambah Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <h2>Tambah Data Mahasiswa</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>NIM</label>
            <input type="text" name="nim" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="gambar" accept="image/*" class="form-control" required>
        </div>
        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
    <?php
    if (isset($_POST['simpan'])) {
        $nama = $_POST['nama'];
        $nim = $_POST['nim'];
        $file = $_FILES['gambar'];
        $namaFile = $file['name'];
        $pathGambar = "uploads/" . $namaFile;
        $tmpName = $file['tmp_name'];
        $folderTujuan = "uploads/";

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
        mysqli_query($conn, "INSERT INTO mahasiswa (nama, nim, gambar) VALUES 
('$nama', '$nim', '$pathGambar')");
        echo "<div class='alert alert-success mt-3'>Data berhasil 
disimpan.</div> 
 <script>
 alert('Data Berhasil Ditambah')
 window.location.href = 'index.php'
 
 </script>
 ";
    }
    ?>
</body>

</html>