<?php
// Start the session
session_start();

// Include the database connection
include 'db.php';

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user information
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$role = isset($_SESSION['role']) ? $_SESSION['role'] : $_SESSION['role_id'];

// Fetch books from the database
$book_query = "SELECT * FROM books";
$books_result = $conn->query($book_query);

// Function to display the list of books
function displayBooks($books_result) {
    if ($books_result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Title</th><th>Author</th><th>Year</th><th>Action</th></tr>";
        while ($book = $books_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $book['title'] . "</td>";
            echo "<td>" . $book['author'] . "</td>";
            echo "<td>" . $book['year'] . "</td>";
            echo "<td><a href='view_book.php?id=" . $book['book_id'] . "'>View</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No books found!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="dashboard-container">
        <h1>Welcome, <?php echo $user_name; ?>!</h1>

        <!-- Admin Dashboard -->
        <?php if ($role == 'admin'): ?>
            <h2>Admin Dashboard</h2>
            <p><a href="add_book.php">Add a New Book</a></p>
            <p><a href="manage_users.php">Manage Users</a></p>
            <h3>List of Books</h3>
            <?php displayBooks($books_result); ?>
        
        <!-- Doctor and Patient Dashboard -->
        <?php elseif ($role == 2 || $role == 3): ?>
            <h2>User Dashboard</h2>
            <h3>List of Books</h3>
            <?php displayBooks($books_result); ?>
        
        <?php else: ?>
            <h2>Unauthorized Access</h2>
            <p>You do not have the required permissions to view this page.</p>
        <?php endif; ?>

        <p><a href="logout.php">Logout</a></p>
    </div>

</body>
</html>
