<?php
include 'config.php';  // Include database connection

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists in the database
    $sql = "SELECT * FROM users WHERE reset_token = '$token' AND verified = 0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mark the email as verified
        $sql = "UPDATE users SET verified = 1, reset_token = NULL WHERE reset_token = '$token'";
        if ($conn->query($sql) === TRUE) {
            echo "Email verified successfully! You can now log in.";
        } else {
            echo "Error verifying email.";
        }
    } else {
        echo "Invalid or expired token.";
    }
}
