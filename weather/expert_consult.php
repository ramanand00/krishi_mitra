<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $topic = $_POST['topic'];
    $message = $_POST['message'];
    
    $conn = new mysqli("localhost", "root", "", "organic_marketplace");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $stmt = $conn->prepare("INSERT INTO consultations (name, email, phone, topic, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $topic, $message);
    
    if ($stmt->execute()) {
        echo "<script>alert('Consultation request submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error submitting request.');</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expert Consultation</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="navbar">
      <div class="logo">
        <img src="auth/logo.png" alt="Logo" />
      </div>
      <div class="nav-links">
        <div class="underline"></div>
        <a href="index.php">Home</a>
        <a href="ecommerce/marketplace.php">Marketplace</a>
        <a href="auth/about.html"> About us</a>
        <a href="auth/contact1.html">Contact</a>
        <a href="auth/faq.html">FAQ</a>
        <a href="auth/chat.html">AI Suggestions</a>
      </div>
      <div class="profile">
        <img
          src="https://img.freepik.com/premium-vector/avatar-profile-icon-flat-style-female-user-profile-vector-illustration-isolated-background-women-profile-sign-business-concept_157943-38866.jpg"
          alt="Profile Picture"
        />
        <a href="auth/login.html">Login</a>
      </div>
    </nav>
    
    <section class="hero">
        <h2>Expert Consultation for Organic Farming</h2>
        <p>Connect with our experts for guidance on organic products and sustainable farming.</p>
    </section>
    
    <section class="consultation-section">
        <h2>Book a Consultation</h2>
        <form class="consultation-form" method="POST" action="">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            <select name="topic">
                <option value="">Select Consultation Topic</option>
                <option value="farming">Organic Farming Techniques</option>
                <option value="nutrition">Organic Nutrition Guidance</option>
                <option value="market">Selling Organic Products</option>
            </select>
            <textarea name="message" placeholder="Briefly describe your query" rows="4" required></textarea>
            <button type="submit">Submit Request</button>
        </form>
    </section>
    
    <footer style="background-color: #4c6d34; color: white; padding: 20px 0;">
    <div class="footer-content" style="display: flex; justify-content: space-around; flex-wrap: wrap; text-align: center;">
        <div class="footer-section">
            <h3 style="color: #c2a470;">AgriConnect</h3>
            <p>Connecting Farmers, Buyers, and Experts for a Sustainable Future </p>
            <div class="social-links">
                <a href="#" style="color: white; margin: 0 10px;"><i class="fab fa-facebook"></i></a>
                <a href="#" style="color: white; margin: 0 10px;"><i class="fab fa-twitter"></i></a>
                <a href="#" style="color: white; margin: 0 10px;"><i class="fab fa-linkedin"></i></a>
                <a href="#" style="color: white; margin: 0 10px;"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="footer-section">
            <h4 style="color: #c2a470;">Quick Links</h4>
            <ul style="list-style: none; padding: 0;">
                <li><a href="index.php" style="color: white; text-decoration: none;">Home</a></li>
                <li><a href="ecommerce/includes/markeltplace.php" style="color: white; text-decoration: none;">Marketplace</a></li>
                <li><a href="#" style="color: white; text-decoration: none;">Blog</a></li>
                <li><a href="auth/contact1.html" style="color: white; text-decoration: none;">Contact</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4 style="color: #c2a470;">Support</h4>
            <ul style="list-style: none; padding: 0;">
                <li><a href="#" style="color: white; text-decoration: none;">Help Center</a></li>
                <li><a href="#" style="color: white; text-decoration: none;">Privacy Policy</a></li>
                <li><a href="#" style="color: white; text-decoration: none;">Terms of Service</a></li>
                <li><a href="ecommerce/includes/faq.phpttt4" style="color: white; text-decoration: none;">FAQ</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom" style="text-align: center; padding-top: 10px;">
        <p>© 2024 AgriConnect. All rights reserved. <br>
        Developed by Krishi-Mitra </p>
    </div>
</footer>
</body>
</html>
