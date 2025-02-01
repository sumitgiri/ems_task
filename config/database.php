<?php
$host = 'localhost';  // Database host
$dbname = 'ems';  // Database name
$username = 'root';  // Database username
$password = '';  // Database password (leave empty if none)

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If there's an error, display it
    echo "Connection failed: " . $e->getMessage();
}
?>
