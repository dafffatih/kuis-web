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
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
    <?php
    if (isset($_POST['simpan'])) {
        $nama = $_POST['nama'];
        $nim = $_POST['nim'];
        $password = $_POST['password'];
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $file = $_FILES['gambar'];
        $tmpName = $file['tmp_name'];
        $folderTujuan = "uploads/";

        // Pastikan folder uploads/ ada
        if (!is_dir($folderTujuan)) {
            mkdir($folderTujuan, 0777, true);
        }

        // Simpan file
        $insert = mysqli_query($conn, "INSERT INTO mahasiswa (nama, nim, password) VALUES ('$nama', '$nim', '$passwordHash')");
        if ($insert) {
            $idUser = mysqli_insert_id($conn); // ambil id yang baru saja masuk

            // Tentukan ekstensi file asli
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $namaFileBaru = $idUser . "." . $ext; // contoh: 5.jpg

            $pathGambar = $folderTujuan . $namaFileBaru;

            // Upload file ke folder uploads dengan nama baru
            if (move_uploaded_file($tmpName, $pathGambar)) {
                // Update kolom gambar di database
                mysqli_query($conn, "UPDATE mahasiswa SET gambar='$pathGambar' WHERE id=$idUser");

                echo "Upload berhasil!<br>";
                echo "<img src='$pathGambar' width='300'>";
                echo "<script>
                    alert('Data Berhasil Ditambah');
                    window.location.href = 'index.php';
                    </script>";
            } else {
                echo "Upload gagal.";
            }
        } else {
            echo "Gagal menyimpan data mahasiswa.";
        }
    }
    ?>
</body>

</html>