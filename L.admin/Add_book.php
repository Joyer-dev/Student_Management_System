<?php
// Include the database connection
include 'db.php';

// Start the session
session_start();

// Check if the user is logged in and has an Admin role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: login.php");
    exit();
}

// Handle form submission to add the book
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $availability = $_POST['availability'];

    // Validate the inputs
    if (empty($title) || empty($author) || empty($genre) || empty($availability)) {
        $error = "All fields are required.";
    } else {
        // Prepare the SQL query to insert the book into the database
        $sql = "INSERT INTO books (title, author, genre, availability) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $title, $author, $genre, $availability);

        // Execute the query and check if the book was added successfully
        if ($stmt->execute()) {
            $success = "Book added successfully!";
        } else {
            $error = "Failed to add the book. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Add New Book</h2>
        
        <!-- Display error message if there is any -->
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <!-- Display success message if book is added -->
        <?php if (isset($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <!-- Add Book Form -->
        <form method="post">
            <label for="title">Book Title:</label>
            <input type="text" name="title" placeholder="Enter book title" required><br><br>

            <label for="author">Author:</label>
            <input type="text" name="author" placeholder="Enter author's name" required><br><br>

            <label for="genre">Genre:</label>
            <input type="text" name="genre" placeholder="Enter book genre" required><br><br>

            <label for="availability">Availability:</label>
            <select name="availability" required>
                <option value="Available">Available</option>
                <option value="Not Available">Not Available</option>
            </select><br><br>

            <button type="submit">Add Book</button>
        </form>

        <p><a href="admin_dashboard.php">Back to Admin Dashboard</a></p>
    </div>
</body>
</html>
