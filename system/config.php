<?php
$host = "localhost"; 
$user = "root"; // Your database username
$pass = ""; // Your database password
$dbname = "hospital management system"; // Your database name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
