<?php
session_start();
include 'db.php';

$error = ''; // Variable to store error messages

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate inputs
    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        // Prepare the SQL query to check if the email exists in the database
        $stmt = $conn->prepare("SELECT user_id, user_name, password, role_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Bind the result to variables
            $stmt->bind_result($user_id, $user_name, $hashed_password, $role_id);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Store session variables
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $user_name;
                $_SESSION['role_id'] = $role_id;

                // Redirect based on the user role
                if ($role_id == 1) {
                    header("Location: admin_dashboard.php"); // Redirect admin to the admin dashboard
                } elseif ($role_id == 2) {
                    header("Location: doctor_dashboard.php"); // Redirect doctor to the doctor dashboard
                } else {
                    header("Location: patient_dashboard.php"); // Redirect patient to the patient dashboard
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your style.css file -->
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
1