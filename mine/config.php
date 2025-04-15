<?php
// Database configuration
define('DB_HOST', 'localhost'); // Database host (usually localhost)
define('DB_NAME', 'contact system'); // Database name
define('DB_USERNAME', 'root'); // Database username (change if different)
define('DB_PASSWORD', ''); // Database password (empty if no password)


// Site settings (can be customized as per requirement)
define('SITE_NAME', 'Contact System'); // Name of the website
define('SITE_URL', 'http://localhost/contact_system'); // URL of the website

// Session timeout (in seconds)
define('SESSION_TIMEOUT', 3600); // Session timeout of 1 hour

// Error handling settings (display errors in development)
define('DISPLAY_ERRORS', true); // Set to false in production for security reasons
ini_set('display_errors', DISPLAY_ERRORS ? 1 : 0);

// Establishing the database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set PDO error mode to exception to catch any connection errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If the connection fails, display an error message
    die('Database connection failed: ' . $e->getMessage());
}
?>
