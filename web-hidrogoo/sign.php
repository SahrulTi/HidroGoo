<?php
// Koneksi ke database
$host = 'localhost'; // Nama host
$dbname = 'hydro'; // Nama database
$username = 'root'; // Username database
$password = ''; // Password database

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Proses registrasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $konfirm_password = trim($_POST['konfirm_password']);

    // Validasi input
    if ($password !== $konfirm_password) {
        echo "<script>alert('Password dan Konfirmasi Password tidak cocok!'); window.location.href='register.html';</script>";
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Simpan data ke database
    try {
        $stmt = $pdo->prepare("INSERT INTO users (nama, email, password) VALUES (:nama, :email, :password)");
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->execute();

        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='login.php';</script>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<script>alert('Email sudah terdaftar!'); window.location.href='sign.php';</script>";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form - Hydroponics Theme</title>
    <link rel="icon" href="assets/imgs/logo2.png">
    <link rel="stylesheet" href="assets/css/login.css" />

</head>

<body>
<div class="container">
        <div class="content-wrapper">
            <div class="form-container">
                <img src="assets/imgs/logo1.png" alt="Logo" class="logo">
                <h1 class="title">Create an Account</h1>
                <p class="subtitle">Join the hydroponics revolution today!</p>
                <form action="sign.php" method="POST">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama" placeholder="Enter your name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="form-group">
                        <label for="konfirm_password">Konfirmasi Password</label>
                        <input type="password" id="konfirm_password" name="konfirm_password" placeholder="Confirm your password" required>
                    </div>
                    <button type="submit" class="btn">Register</button>
                </form>
                <p class="signup-link">Already have an account? <a href="login.php" class="link">Login here</a></p>
            </div>
            <div class="image-container">
                <img src="assets/imgs/Ilustrasi-tanaman-hidroponik-dari-piyasuk-via-Getty-Images.jpg"
                    alt="Illustration">
            </div>
        </div>
    </div>

    <script>
        const loginContainer = document.getElementById('loginContainer');
        const loginButton = document.getElementById('loginButton');
        const googleSignInButton = document.getElementById('googleSignInButton');

        loginButton.addEventListener('click', (e) => {
            e.preventDefault();
            loginContainer.classList.add('exiting');
            setTimeout(() => {
                alert('Logged in successfully!');
                loginContainer.classList.remove('exiting');
            }, 1000);
        });

        googleSignInButton.addEventListener('click', () => {
            alert('Google Sign-In clicked!');
        });
    </script>
</body>

</html>