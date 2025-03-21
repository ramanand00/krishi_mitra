<?php
include 'config.php';  // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "❌ Invalid email format.";
        exit();
    }

    // Check if the email exists in the database using a prepared statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(50)); // Generate a unique token

        // Insert the token into the database for later verification using a prepared statement
        $token_sql = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
        $token_sql->bind_param("ss", $token, $email);

        if ($token_sql->execute()) {
            // Generate the reset password link with the token
            $reset_link = "http://localhost/krishi_mitra/auth/reset_password.php?token=$token";

            // Send the reset email
            $subject = "Password Reset Request";
            $message = "Click the following link to reset your password: $reset_link";
            $headers = "From: no-reply@krishimitra.com";

            if (mail($email, $subject, $message, $headers)) {
                echo "✅ A password reset link has been sent to your email.";
            } else {
                echo "❌ Error sending email. Please try again.";
            }
        } else {
            echo "❌ Error updating reset token. Please try again.";
        }
    } else {
        echo "❌ No user found with this email.";
    }

    $stmt->close();
    $token_sql->close();
}

// Close the database connection
$conn->close();
?>

