<?php
include 'config.php';
session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $user_name = trim($_POST['user_name']);
    $password = $_POST['password'];

    // Validation
    if (empty($user_name) || empty($password)) {
        $error = "Both username and password are required.";
    } else {
        // Check in the admin table only
        $sql = "SELECT * FROM admin WHERE user_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['role'] = 'admin';  // Role set to admin
                header("Location: home.php");
                exit();
            } else {
                $error = "Incorrect password!";
            }
        } else {
            $error = "Username not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
        }
        .container {
            width: 100%;
            max-width: 400px; /* Max width of the form */
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        label {
            font-size: 14px;
            color: #333;
            text-align: left;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], 
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box; /* Ensures padding doesn't affect width */
        }
        .input-container {
            position: relative;
            width: 100%;
            margin-bottom: 15px;
        }
        .input-container input {
            padding-right: 40px; /* Space for eye icon */
        }
        .eye-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #333;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }
        p {
            text-align: center;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Login</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="user_name">Username:</label>
        <input type="text" name="user_name" id="user_name" required>

        <label for="password">Password:</label>
        <div class="input-container">
            <input type="password" name="password" id="password" required>
            <span class="eye-icon" onclick="togglePassword()">👁️</span>
        </div>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>

<script>
    function togglePassword() {
        var passwordField = document.getElementById("password");
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    }
</script>

</body>
</html>
