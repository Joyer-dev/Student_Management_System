<?php
session_start();
include 'config.php';

$error = $success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['user_name']); // Corrected to match form field name
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role_id']; // Corrected to match form field name

    // Validation for empty fields and password mismatch
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Hash the password before saving to the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare query to check if email already exists in the appropriate table based on role
        if ($role == 1) {
            // Admin Registration
            $stmt = $conn->prepare("SELECT email FROM admin WHERE email = ?");
        } else {
            // User Registration (Doctor or Patient)
            $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Check if the email is already registered
        if ($stmt->num_rows > 0) {
            $error = "Email is already registered!";
        } else {
            // Insert into the appropriate table based on role
            if ($role == 1) {
                // Insert into Admin table
                $stmt = $conn->prepare("INSERT INTO admin (admin_name, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $name, $email, $hashed_password);
            } else {
                // Insert into Users table (Doctor or Patient)
                $stmt = $conn->prepare("INSERT INTO users (user_name, email, password, role_id) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sssi", $name, $email, $hashed_password, $role);
            }

            // Execute the insertion and check if it was successful
            if ($stmt->execute()) {
                $success = "Registration successful! You can now log in.";
                header("Location: login.php"); // Redirect to login page after success
                exit(); // Make sure no further code executes
            } else {
                $error = "Registration failed! Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>
        <?php if ($success): ?><div class="success"><?php echo $success; ?></div><?php endif; ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <select name="role">
                <option value="1">Admin</option>
                <option value="2">Doctor</option>
                <option value="3">Patient</option>
            </select>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
