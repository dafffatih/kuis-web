<?php 
session_start();
include 'koneksi/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Login</h3>
                        <form method="POST" action="">
                            <div class="mb-3"> <label for="nim" class="form-label">NIM</label> <input type="text" name="nim" class="form-control" id="nim" required> </div>
                            <div class="mb-3"> <label for="password" class="form-label">Password</label> <input type="password" name="password" class="form-control" id="password" required> </div> <button type="submit" class="btn btn-primary w-100" name="login">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php 

if (isset($_POST['login'])) {
    $nim = isset($_POST['nim']) ? $_POST['nim'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $query = "SELECT * FROM mahasiswa WHERE nim='$nim'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['nim'] = $user['nim'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>