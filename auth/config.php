<?php
// Turn off error reporting in production (only for development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database credentials
$host = "localhost";
$user = "root";
$password = "";  // Empty for XAMPP
$dbname = "krishi_mitra";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error); // Handle connection error
} else {
    // Uncomment the line below for testing
    // echo "Database Connected Successfully!";
}
?>
