<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}

include 'config.php';

// Fetch categories from the database
$categories = [];
$sql = "SELECT * FROM categories";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
  $categories[] = $row;
}
$stmt->close();

// Handle form submission when the user submits the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Sanitizing and validating input data
  $name = htmlspecialchars(trim($_POST["name"]));
  $description = htmlspecialchars(trim($_POST["description"]));
  $price = floatval($_POST["price"]);
  $category_id = intval($_POST["category_id"]);
  $quantity = intval($_POST["quantity"]);
  $product_keywords = htmlspecialchars(trim($_POST["product_keywords"]));

  // Generate unique invoice number
  $invoice_number = strtoupper("INV-" . uniqid());

  // Validate form data
  if (empty($name) || empty($description) || $price <= 0 || $quantity <= 0 || $category_id <= 0) {
    echo "All fields are required and price/quantity must be valid.";
    exit();
  }

  // Handle file upload for product image
  $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/KRISHI_MITRA/uploads/products/';
  $file_name = $_FILES['product_image']['name'];
  $file_tmp_name = $_FILES['product_image']['tmp_name'];
  $file_error = $_FILES['product_image']['error'];

  // Debugging file upload error
  if ($file_error != 0) {
    echo "File upload error: " . $file_error;
    exit();
  }

  // Check if file is uploaded and handle validation
  if (isset($file_name) && $file_name != "") {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_type = $_FILES['product_image']['type'];
    $file_size = $_FILES['product_image']['size'];
    $max_size = 2 * 1024 * 1024; // 2MB limit

    if (!in_array($file_type, $allowed_types)) {
      echo "Invalid file type! Only JPG, PNG, and GIF are allowed.";
      exit();
    }

    if ($file_size > $max_size) {
      echo "File size exceeds the 2MB limit!";
      exit();
    }

    // Generate a unique filename for the uploaded image
    $file_name_new = uniqid() . "_" . basename($file_name);
    $file_path = $upload_dir . $file_name_new;

    // Attempt to move uploaded file to the server
    if (!move_uploaded_file($file_tmp_name, $file_path)) {
      echo "Error uploading file.";
      exit();
    }
  } else {
    $file_path = NULL; // No file uploaded, set to NULL
  }

  // Insert product data into the database using prepared statement
  $user_id = $_SESSION["user_id"];
  $sql = "INSERT INTO products (user_id, name, description, price, quantity, category_id, image, invoice_number, product_keywords) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);

  // Correct binding with the proper number of placeholders
  $stmt->bind_param("isdiissss", $user_id, $name, $description, $price, $quantity, $category_id, $file_path, $invoice_number, $product_keywords);

  // Execute the statement
  if ($stmt->execute()) {
    echo "Product added successfully!";
  } else {
    echo "Error adding product: " . $stmt->error;
  }
  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Product</title>
</head>

<body>
  <h2>Add New Product</h2>
  <form method="POST" action="add_product.php" enctype="multipart/form-data">
    <label for="name">Product Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="description">Description:</label><br>
    <textarea id="description" name="description" required></textarea><br><br>

    <label for="price">Price:</label><br>
    <input type="number" id="price" name="price" step="0.01" required><br><br>

    <label for="quantity">Quantity:</label><br>
    <input type="number" id="quantity" name="quantity" required><br><br>

    <label for="category_id">Category:</label><br>
    <select name="category_id" id="category_id" required>
      <?php
      // Display categories dynamically
      foreach ($categories as $category) {
        echo "<option value='" . $category['id'] . "'>" . $category['name'] . "</option>";
      }
      ?>
    </select><br><br>

    <label for="product_image">Product Image:</label><br>
    <input type="file" id="product_image" name="product_image" accept="image/*"><br><br>

    <label for="product_keywords">Product Keywords (comma separated):</label><br>
    <input type="text" id="product_keywords" name="product_keywords" required><br><br>

    <input type="submit" value="Add Product"><br><br>
  </form>
  <br>
  <a href="dashboard.php">Back to Dashboard</a> | <a href="logout.php">Logout</a>
</body>

</html>