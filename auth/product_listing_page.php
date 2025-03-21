<?php
session_start();
include 'config.php';

// Set number of products per page
$products_per_page = 10;

// Get the current page number (default is page 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting product index for the SQL query
$start_from = ($page - 1) * $products_per_page;

// Fetch total number of products
$sql = "SELECT COUNT(*) AS total_products FROM products";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_products = $row['total_products'];

// Calculate total pages
$total_pages = ceil($total_products / $products_per_page);

// Fetch products for the current page
$sql = "SELECT * FROM products LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $start_from, $products_per_page);
$stmt->execute();
$result = $stmt->get_result();

// Display products
echo "<h2>Product Listing</h2>";
while ($product = $result->fetch_assoc()) {
  echo "<div>";
  echo "<h3>" . htmlspecialchars($product['name']) . "</h3>";
  echo "<p>" . htmlspecialchars($product['description']) . "</p>";
  echo "<p>Price: " . htmlspecialchars($product['price']) . "</p>";
  echo "<p><a href='edit_product.php?id=" . $product['id'] . "'>Edit</a> | <a href='delete_product.php?id=" . $product['id'] . "'>Delete</a></p>";
  echo "</div>";
}

// Display pagination links
echo "<div>";
if ($page > 1) {
  echo "<a href='?page=" . ($page - 1) . "'>Previous</a> | ";
}

for ($i = 1; $i <= $total_pages; $i++) {
  if ($i == $page) {
    echo "<strong>$i</strong> | ";
  } else {
    echo "<a href='?page=$i'>$i</a> | ";
  }
}

if ($page < $total_pages) {
  echo "<a href='?page=" . ($page + 1) . "'>Next</a>";
}
echo "</div>";

$stmt->close();
