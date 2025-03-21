<?php
include 'config.php';

// Function to validate password strength
function validatePassword($password) {
    return preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
}

if (!isset($_GET['token'])) {
    die("❌ Token not provided!");
}

$token = $_GET['token'];

// Use a prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("❌ Invalid or expired token.");
}

$user = $result->fetch_assoc();
$user_id = $user['id'];
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = trim($_POST['password']);

    // Validate password
    if (!validatePassword($password)) {
        die("❌ Password must be at least 8 characters, contain one uppercase letter, one number, and one special character!");
    }

    // Hash the new password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update the user's password and clear the reset token using prepared statements
    $update_stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE id = ?");
    $update_stmt->bind_param("si", $hashed_password, $user_id);

    if ($update_stmt->execute()) {
        echo "✅ Password has been successfully reset! <a href='login.php'>Login here</a>";
    } else {
        echo "❌ Error resetting password. Please try again.";
    }

    $update_stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>

    <form method="POST" action="">
        <label for="password">New Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Reset Password">
    </form>
    <br>
    <a href="login.php">Back to Login</a>
</body>
</html>
