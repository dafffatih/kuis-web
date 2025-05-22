<?php
include "koneksi/db.php";
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM
mahasiswa WHERE id=$id"));
if(file_exists($data['gambar'])) {
    unlink($data['gambar']);
}
mysqli_query($conn, "DELETE FROM mahasiswa WHERE id=$id");
header("Location: index.php");
?>