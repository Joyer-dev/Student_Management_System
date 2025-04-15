<?php
// Include the database connection
include 'db.php';

// Start the session
session_start();

// Handle form submission to log in
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate email and password
    if (empty($email) || empty($password)) {
        $error = "Email and password are required!";
    } else {
        // Check if the email exists in the Admin table first
        $stmt = $conn->prepare("SELECT admin_id, admin_name, password FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Admin found
            $stmt->bind_result($admin_id, $admin_name, $hashed_password);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $admin_id;
                $_SESSION['user_name'] = $admin_name;
                $_SESSION['role'] = 'admin'; // Admin role

                header("Location: admin_dashboard.php");
                exit();
            } else {
                $error = "Incorrect password!";
            }
        } else {
            // Check if the email exists in the Users table (for Doctors/Patients)
            $stmt = $conn->prepare("SELECT user_id, user_name, password, role_id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // User found (Doctor/Patient)
                $stmt->bind_result($user_id, $user_name, $hashed_password, $role_id);
                $stmt->fetch();

                // Verify the password
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['user_name'] = $user_name;
                    $_SESSION['role_id'] = $role_id; // Set the user role (Doctor/Patient)

                    // Redirect users based on their roles
                    if ($role_id == 2) {
                        header("Location: doctor_dashboard.php");
                    } else if ($role_id == 3) {
                        header("Location: patient_dashboard.php");
                    } else {
                        header("Location: login.php");
                    }
                    exit();
                } else {
                    $error = "Incorrect password!";
                }
            } else {
                $error = "No account found with this email!";
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
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>

        <!-- Display error message if there is any -->
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
