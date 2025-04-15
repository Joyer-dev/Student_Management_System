<?php
include 'config.php'; // Include the database connection

// Fetch all messages from the database
$stmt = $pdo->query("SELECT * FROM messages");
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages List</title>

    <!-- CSS styles -->
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc); /* Gradient Background */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container for the page content */
        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Header styling */
        h2 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        td {
            background-color: #fff;
        }

        /* Button styling */
        button {
            padding: 8px 16px;
            border: none;
            background-color: #2575fc;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #6a11cb;
        }

        /* Add some spacing for readability */
        tbody tr td {
            word-wrap: break-word;
        }
    </style>

    <!-- JavaScript for updating the message status -->
    <script>
        function updateStatus(messageId) {
            // Send AJAX request to update message status
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_status.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Prepare the data to send to the server
            const statusElement = document.getElementById('status-' + messageId);
            const currentStatus = statusElement.innerHTML.trim();
            const newStatus = currentStatus === 'unread' ? 'read' : 'unread'; // Toggle between read/unread

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // If successful, update the status in the table
                    statusElement.innerHTML = newStatus;
                } else {
                    alert('Failed to update status');
                }
            };

            // Send data to the server
            xhr.send('id=' + messageId + '&status=' + newStatus);
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Messages</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr id="message-<?php echo $message['id']; ?>">
                        <td><?php echo htmlspecialchars($message['name']); ?></td>
                        <td><?php echo htmlspecialchars($message['email']); ?></td>
                        <td><?php echo htmlspecialchars($message['subject']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($message['message'])); ?></td>
                        <td id="status-<?php echo $message['id']; ?>"><?php echo htmlspecialchars($message['status']); ?></td>
                        <td>
                            <button class="update-status-btn" data-id="<?php echo $message['id']; ?>" onclick="updateStatus(<?php echo $message['id']; ?>)">Update Status</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
