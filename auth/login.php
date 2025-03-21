<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        die("❌ Email and password are required!");
    }

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, name, email, password, user_type FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $user["password"])) {
            // Regenerate session ID for security
            session_regenerate_id(true);

            // Store user data in session
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_email"] = $user["email"];
            $_SESSION["user_type"] = $user["user_type"];

            // Redirect to dashboard
            header("Location: ../index.php");
            exit();
        } else {
            die("❌ Invalid email or password!");
        }
    } else {
        die("❌ No user found with this email!");
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$conn->close();
