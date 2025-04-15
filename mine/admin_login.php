<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Admin validation
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header('Location: admin_dashboard.php');
    } else {
        echo '<p style="color: red;">Invalid credentials</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Font Awesome CDN for Eye Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* General Body Styling */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc); /* Gradient Background */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Form Container Styling */
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Header Styling */
        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        /* Label Styling */
        label {
            font-size: 16px;
            margin-bottom: 8px;
            color: #444;
            text-align: left;
        }

        /* Input Field Styling */
        input[type="text"], 
        input[type="password"] {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
            transition: border 0.3s ease;
        }

        input[type="text"]:focus, 
        input[type="password"]:focus {
            border-color: #2575fc;
            outline: none;
        }

        /* Password Container Styling */
        .password-container {
            position: relative;
        }

        /* Eye Icon Styling */
        .eye-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 20px; /* Adjust size of the eye icon */
            color: #333;
            transition: color 0.3s ease;
        }

        .eye-icon:hover {
            color: #2575fc; /* Change color when hovered */
        }

        /* Submit Button Styling */
        button {
            width: 100%;
            padding: 14px;
            background-color: #2575fc;
            color: #fff;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #6a11cb;
        }

        /* Text Link Styling */
        p {
            font-size: 14px;
            color: #444;
        }

        p a {
            text-decoration: none;
            color: #2575fc;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script>
        // JavaScript function to toggle password visibility
        function togglePassword() {
            var passwordField = document.getElementById('password');
            var toggleIcon = document.getElementById('toggle-icon');

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            }
        }
    </script>
</head>
<body>
    <div class="form-container">
        <h2>Admin Login</h2>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required>
                <i class="fas fa-eye-slash" id="toggle-icon" onclick="togglePassword()" class="eye-icon"></i>
            </div>

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="admin_register.php">Register</a></p>
    </div>
</body>
</html>
