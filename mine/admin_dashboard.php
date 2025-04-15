<?php
session_start();
include 'config.php';

// Check if the user is logged in (session exists)
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: admin_login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            color: #fff;
        }

        /* Dashboard Container Styling */
        .dashboard-container {
            background-color: #fff;
            color: #333;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        h2 {
            font-size: 26px;
            color: #2575fc;
            margin-bottom: 30px;
        }

        /* Link Styling */
        p {
            font-size: 18px;
            margin: 15px 0;
        }

        a {
            text-decoration: none;
            color: #2575fc;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #6a11cb;
        }

        /* Logout Button Styling */
        .logout-btn {
            margin-top: 30px;
            padding: 12px 20px;
            background-color: #2575fc;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #6a11cb;
        }

        /* Mobile Responsiveness */
        @media (max-width: 600px) {
            .dashboard-container {
                width: 90%;
                padding: 20px;
            }

            h2 {
                font-size: 22px;
            }

            p {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome to the Admin Dashboard</h2>
        <p><a href="messages.php">View Messages</a></p>
        <p><a href="admin_logout.php" class="logout-btn">Logout</a></p>
    </div>
</body>
</html>
