<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}

include 'config.php';

// Fetch the product to be edited based on the product ID
if (isset($_GET['product_id'])) {
  $product_id = intval($_GET['product_id']);

  // Fetch the product details from the database
  $sql = "SELECT * FROM products WHERE id = ? AND user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $product_id, $_SESSION["user_id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
    echo "Product not found or you do not have permission to edit it.";
    exit();
  }

  $product = $result->fetch_assoc();
  $stmt->close();
}

// Handle form submission for product update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Sanitizing and validating input data
  $name = htmlspecialchars(trim($_POST["name"]));
  $description = htmlspecialchars(trim($_POST["description"]));
  $price = floatval($_POST["price"]);
  $category_id = intval($_POST["category_id"]);
  $quantity = intval($_POST["quantity"]);
  $product_keywords = htmlspecialchars(trim($_POST["product_keywords"]));

  // Validate form data
  if (empty($name) || empty($description) || $price <= 0 || $quantity <= 0 || $category_id <= 0) {
    echo "All fields are required and price/quantity must be valid.";
    exit();
  }

  // Handle file upload for product image (optional)
  $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/products/';
  $file_path = $product['image']; // Keep the original image if no new image is uploaded

  if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
    $file_name = $_FILES['product_image']['name'];
    $file_tmp_name = $_FILES['product_image']['tmp_name'];
    $file_type = $_FILES['product_image']['type'];
    $file_size = $_FILES['product_image']['size'];
    $max_size = 2 * 1024 * 1024; // 2MB limit

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($file_type, $allowed_types)) {
      echo "Invalid file type! Only JPG, PNG, and GIF are allowed.";
      exit();
    }

    if ($file_size > $max_size) {
      echo "File size exceeds the 2MB limit!";
      exit();
    }

    // Generate a unique filename and save the new image
    $file_name_new = uniqid() . "_" . basename($file_name);
    $file_path = $upload_dir . $file_name_new;

    // Move the uploaded file to the server
    if (!move_uploaded_file($file_tmp_name, $file_path)) {
      echo "Error uploading file.";
      exit();
    }
  }

  // Update product details in the database
  $sql = "UPDATE products SET name = ?, description = ?, price = ?, quantity = ?, category_id = ?, image = ?, product_keywords = ? WHERE id = ? AND user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssdisssii", $name, $description, $price, $quantity, $category_id, $file_path, $product_keywords, $product_id, $_SESSION["user_id"]);

  if ($stmt->execute()) {
    echo "Product updated successfully!";
  } else {
    echo "Error updating product: " . $stmt->error;
  }
  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product</title>
</head>

<body>
  <h2>Edit Product</h2>
  <form method="POST" action="edit_product.php?product_id=<?php echo $product['id']; ?>" enctype="multipart/form-data">
    <label for="name">Product Name:</label><br>
    <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" required><br><br>

    <label for="description">Description:</label><br>
    <textarea id="description" name="description" required><?php echo $product['description']; ?></textarea><br><br>

    <label for="price">Price:</label><br>
    <input type="number" id="price" name="price" step="0.01" value="<?php echo $product['price']; ?>" required><br><br>

    <label for="quantity">Quantity:</label><br>
    <input type="number" id="quantity" name="quantity" value="<?php echo $product['quantity']; ?>" required><br><br>

    <label for="category_id">Category:</label><br>
    <select name="category_id" id="category_id" required>
      <?php
      // Display categories dynamically
      $categories = [];
      $sql = "SELECT * FROM categories";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->get_result();
      while ($row = $result->fetch_assoc()) {
        $selected = $product['category_id'] == $row['id'] ? 'selected' : '';
        echo "<option value='" . $row['id'] . "' $selected>" . $row['name'] . "</option>";
      }
      ?>
    </select><br><br>

    <label for="product_image">Product Image:</label><br>
    <input type="file" id="product_image" name="product_image" accept="image/*"><br><br>

    <label for="product_keywords">Product Keywords (comma separated):</label><br>
    <input type="text" id="product_keywords" name="product_keywords" value="<?php echo $product['product_keywords']; ?>" required><br><br>

    <input type="submit" value="Update Product"><br><br>
  </form>
  <br>
  <a href="dashboard.php">Back to Dashboard</a> | <a href="logout.php">Logout</a>
</body>

</html>