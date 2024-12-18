<?php

require 'function.php';

$error = ""; // Variabel untuk menyimpan pesan error

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $cekdatabase = mysqli_query($conn, "SELECT * FROM login WHERE email='$email' AND password='$password'");
    $hitung = mysqli_num_rows($cekdatabase);

    if ($hitung > 0) {
        $_SESSION['log'] = 'true';
        header('location:dashboard.php');
    } else {
        $error = "Email atau password salah, silakan coba lagi.";
    }
}

if (isset($_SESSION['log'])) {
    header('location:dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #1d2671, #c33764);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            display: flex;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 800px;
            max-width: 100%;
        }
        .login-info {
            background: linear-gradient(to bottom right, #6a11cb, #2575fc);
            padding: 40px;
            color: white;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }
        .login-info h2 {
            font-size: 30px;
            margin-bottom: 10px;
        }
        .login-info p {
            font-size: 16px;
            margin-bottom: 30px;
        }
        .login-form {
            padding: 40px;
            flex: 1;
        }
        .login-form h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            position: relative;
            margin-bottom: 20px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            padding-left: 40px;
            border: 1px solid #ccc;
            border-radius: 50px;
            font-size: 16px;
        }
        .form-group i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #999;
        }
        .form-group label {
            margin-left: 10px;
            color: #555;
        }
        .forgot-password {
            text-align: right;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .forgot-password a {
            color: #2575fc;
            text-decoration: none;
        }
        .login-btn {
            width: 100%;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            border: none;
            color: white;
            padding: 10px;
            font-size: 16px;
            border-radius: 50px;
            cursor: pointer;
            transition: 0.3s ease;
        }
        .login-btn:hover {
            background: linear-gradient(to right, #2575fc, #6a11cb);
            transform: scale(1.05);
        }
        .error-message {
            color: red;
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Bagian Kiri: Info dan Welcome -->
        <div class="login-info">
            <h3>PT.NAMURA TEHNIK SEJAHTERA</h3>
            <p>Sign in to continue access</p>
        </div>

        <!-- Bagian Kanan: Form Login -->
        <div class="login-form">
            <h2>Login</h2>

            <!-- Menampilkan pesan error jika ada -->
            <?php if ($error): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                
                <button type="submit" class="login-btn" name="login">Login</button>
            </form>
        </div>
    </div>

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
