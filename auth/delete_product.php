<?php
// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Handle product deletion
if (isset($_GET['delete_product_id'])) {
    $product_id = intval($_GET['delete_product_id']);

    // Check if the product belongs to the logged-in user
    $sql = "SELECT * FROM products WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $product_id, $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "Product not found or you do not have permission to delete it.";
        exit();
    }

    // Delete product from the database
    $sql = "DELETE FROM products WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $product_id, $_SESSION["user_id"]);

    if ($stmt->execute()) {
        echo "Product deleted successfully!";
    } else {
        echo "Error deleting product: " . $stmt->error;
    }
    $stmt->close();
}
?>
