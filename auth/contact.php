<?php
include 'config.php';
// Check Connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $first_name = $conn->real_escape_string($_POST['first_name']);
  $last_name = $conn->real_escape_string($_POST['last_name']);
  $email = $conn->real_escape_string($_POST['email']);
  $phone = $conn->real_escape_string($_POST['phone']);
  $message = $conn->real_escape_string($_POST['message']);

  // Insert Data into Database
  $sql = "INSERT INTO contacts (first_name, last_name, email, phone, message) 
            VALUES ('$first_name', '$last_name', '$email', '$phone', '$message')";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Form submitted successfully!'); window.location.href='contact.html';</script>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

$conn->close();
