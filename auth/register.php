<?php
include 'config.php';  // Include your database connection

// Function to validate email
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Function to validate password strength
function validatePassword($password)
{
    // return preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
    return strlen($password) >= 6;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Trim and sanitize input values
    $name = trim($_POST['name']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $user_type = trim($_POST['user_type']);

    // Validate input fields
    if (empty($name) || empty($email) || empty($password) || empty($phone) || empty($address)) {
        die("❌ All fields are required!");
    } elseif (!validateEmail($email)) {
        die("❌ Invalid email format!");
    } elseif (!validatePassword($password)) {
        die("❌ Password must be at least 8 characters, contain one uppercase letter, one number, and one special character!");
    }

    // Check if the email already exists using a prepared statement
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("❌ This email is already registered! Please try logging in.");
    }
    $stmt->close();

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to insert user data
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone, address, user_type) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("❌ Error in preparing the SQL statement: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $name, $email, $hashed_password, $phone, $address, $user_type);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to login page after successful registration
        header("Location: login.html");
        exit();
    } else {
        die("❌ Error executing query: " . $stmt->error);
    }

    // Close statement and database connection
    $stmt->close();
}
$conn->close();
