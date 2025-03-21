<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION["user_id"];

// Fetch user data securely using prepared statements
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
  echo "User not found!";
  exit();
}

// Validate password strength function
function validatePassword($password)
{
  return preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
}

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = htmlspecialchars(trim($_POST["name"]));
  $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $phone = htmlspecialchars(trim($_POST["phone"]));
  $address = htmlspecialchars(trim($_POST["address"]));

  // Validate email format
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["error" => "Invalid email format!"]);
    exit();
  }

  // Update user details using prepared statements
  $update_sql = "UPDATE users SET name=?, email=?, phone=?, address=? WHERE id=?";
  $stmt = $conn->prepare($update_sql);
  $stmt->bind_param("ssssi", $name, $email, $phone, $address, $user_id);

  if ($stmt->execute()) {
    $_SESSION["user_name"] = $name;
    $_SESSION["user_email"] = $email;
    echo json_encode(["success" => "Profile updated successfully!"]);
  } else {
    echo json_encode(["error" => "Error updating profile: " . $stmt->error]);
  }
  $stmt->close();

  // Handle password change
  if (isset($_POST["change_password"])) {
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    if (!validatePassword($new_password)) {
      echo json_encode(["error" => "Password must be at least 8 characters, include one uppercase letter, one number, and one special character!"]);
      exit();
    }

    if ($new_password !== $confirm_password) {
      echo json_encode(["error" => "Passwords do not match!"]);
      exit();
    }

    // Get current password hash from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($current_password, $hashed_password)) {
      echo json_encode(["error" => "Current password is incorrect!"]);
      exit();
    }

    // Hash new password and update in the database
    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashed_new_password, $user_id);

    if ($stmt->execute()) {
      echo json_encode(["success" => "Password changed successfully!"]);
    } else {
      echo json_encode(["error" => "Error changing password: " . $stmt->error]);
    }
    $stmt->close();
  }

  // Handle profile picture upload
  if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_type = $_FILES['profile_picture']['type'];
    $file_size = $_FILES['profile_picture']['size'];
    $max_size = 2 * 1024 * 1024; // 2MB limit

    if (!in_array($file_type, $allowed_types)) {
      echo json_encode(["error" => "Invalid file type! Only JPG, PNG, and GIF are allowed."]);
      exit();
    }

    if ($file_size > $max_size) {
      echo json_encode(["error" => "File size exceeds the 2MB limit!"]);
      exit();
    }

    // Set the correct upload directory
    $upload_dir = __DIR__ . '/../uploads/profile_pictures/';

    // Create directory if it doesn't exist
    if (!is_dir($upload_dir)) {
      mkdir($upload_dir, 0775, true);
    }

    if (!is_writable($upload_dir)) {
      echo json_encode(["error" => "Upload directory is not writable."]);
      exit();
    }

    $file_name = uniqid() . "_" . basename($_FILES['profile_picture']['name']);
    $file_path = $upload_dir . $file_name;

    // Move uploaded file
    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $file_path)) {
      $relative_path = "uploads/profile_pictures/" . $file_name;

      $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
      $stmt->bind_param("si", $relative_path, $user_id);

      if ($stmt->execute()) {
        echo json_encode(["success" => "Profile picture updated successfully!", "path" => $relative_path]);
      } else {
        echo json_encode(["error" => "Error updating profile picture: " . $stmt->error]);
      }
      $stmt->close();
    } else {
      echo json_encode(["error" => "Error uploading file."]);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile</title>
</head>

<body>
  <h2>Edit Profile</h2>
  <form method="POST" action="profile.php" enctype="multipart/form-data">
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

    <label for="phone">Phone:</label><br>
    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required><br><br>

    <label for="address">Address:</label><br>
    <textarea id="address" name="address" required><?php echo htmlspecialchars($user['address']); ?></textarea><br><br>

    <input type="submit" value="Update Profile">

    <h3>Upload Profile Picture</h3>
    <label for="profile_picture">Profile Picture:</label><br>
    <input type="file" id="profile_picture" name="profile_picture" accept="image/*"><br><br>

    <input type="submit" value="Upload Picture">
  </form>
  <br>
  <a href="dashboard.php">Back to Dashboard</a> | <a href="logout.php">Logout</a>
</body>

</html>