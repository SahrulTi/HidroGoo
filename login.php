<?php
// Koneksi ke database
$host = 'localhost'; // Nama host database
$dbname = 'hydro'; // Nama database
$username = 'root'; // Username database
$password = ''; // Password database

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Query untuk memeriksa apakah email ada di database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Login berhasil
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];

        echo "<script>alert('Login berhasil!'); window.location.href='home.html';</script>";
    } else {
        // Login gagal
        echo "<script>alert('Email atau password salah!'); window.location.href='login.php';</script>";
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
                <h1 class="title">Welcome Back</h1>
                <p class="subtitle">Experience the future of hydroponics with us!</p>
        <form action="login.php" method="POST">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
    </div>
    <div class="checkbox-group">
        <label>
            <input type="checkbox"> Remember me
        </label>
        <a href="#" class="link">Forgot password?</a>
    </div>
    <button type="submit" class="btn" id="loginButton">Login</button>
    <button type="button" class="google-btn" id="googleSignInButton">Login with Google</button>
</form>

                <p class="signup-link">Don't have an account? <a href="sign.php" class="link">Sign up</a></p>
            </div>
            <div class="image-container">
                <img src="assets/imgs/Ilustrasi-tanaman-hidroponik-dari-piyasuk-via-Getty-Images.jpg" alt="Illustration">
            </div>
        </div>
    </div>

    <script>
        const loginContainer = document.getElementById('loginContainer');
        const loginButton = document.getElementById('loginButton');
        const googleSignInButton = document.getElementById('googleSignInButton');

        loginButton.addEventListener('click', (e) => {
            // e.preventDefault(); // Remove this line to allow form submission
            loginContainer.classList.add('exiting');
            setTimeout(() => {
                // Add any additional actions here if needed
            }, 300);
        });

        googleSignInButton.addEventListener('click', () => {
            alert('Google Sign-In clicked!');
        });
        document.querySelector("form").addEventListener("submit", (e) => {
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    if (!email || !password) {
        e.preventDefault();
        alert("Email dan password harus diisi!");
    }
});

    </script>
</body>
</html>
