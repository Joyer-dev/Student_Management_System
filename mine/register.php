<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
        echo "<p>Please fill all fields.</p>";
    } else {
        try {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            // Hash the password before storing it
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert new admin into the database
            $stmt = $pdo->prepare("INSERT INTO admin (username, password, email, created_at) VALUES (:username, :password, :email, NOW())");
            $stmt->execute([
                'username' => $username,
                'password' => $hashedPassword,
                'email' => $email
            ]);

            // Success message and redirection
            echo "<p>Admin registered successfully!</p>";
            header('Location: admin_login.php');
            exit();
        } catch (PDOException $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
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
        <h2>Admin Registration</h2>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required>
                <i class="fas fa-eye-slash" id="toggle-icon" onclick="togglePassword()" class="eye-icon"></i>
            </div>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="admin_login.php">Login</a></p>
    </div>
</body>
</html>
