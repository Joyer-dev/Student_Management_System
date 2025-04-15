<?php
include 'config.php';  // Include database connection

// Check if the ID and new status are provided via POST
if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Prepare the SQL query to update the message status
    $stmt = $pdo->prepare("UPDATE messages SET status = :status WHERE id = :id");
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id);

    // Execute the query and return the appropriate message
    if ($stmt->execute()) {
        echo "Status updated successfully";
    } else {
        echo "Failed to update status";
    }
} else {
    echo "Invalid request";
}
?>
