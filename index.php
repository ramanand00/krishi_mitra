<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nav Bar</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Open Sans", "Arial", "Helvetica Neue", "Helvetica",
          sans-serif;
        color: white;
      }

      .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 30px;
        background: #4c6d34;
        position: relative;
      }

      .logo img {
        height: 50px;
      }

      .nav-links {
        position: relative;
        display: flex;
      }

      .nav-links a {
        text-decoration: none;
        margin: 0 15px;
        color: #c2a470;
        position: relative;
        padding-bottom: 5px;
      }

      .nav-links a::after {
        content: "";
        position: absolute;
        left: 50%;
        bottom: 0;
        width: 0;
        height: 2px;
        background: #c2a470;
        transition: width 0.3s ease-in-out, left 0.3s ease-in-out;
      }

      .nav-links a:hover::after {
        width: 100%;
        left: 0;
      }

      .underline {
        position: absolute;
        bottom: 0;
        height: 2px;
        background: #c2a470;
        transition: all 0.3s ease-in-out;
        width: 0;
      }

      .profile {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .profile img {
        height: 40px;
        width: 40px;
        border-radius: 50%;
        overflow: hidden;
      }

      .profile p {
        margin-top: 5px;
        color: white;
      }
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Open Sans", Arial, sans-serif;
      }

      .hero {
        width: 100%;
        height: 50vh;
        background: url("auth/login.png") no-repeat center center/cover;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 80px; 
        position: relative;
        color: white;
      }

      .hero-content {
        max-width: 550px;
        padding: 20px;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(0.1px);
        border-radius: 10px;
      }

      .hero h1 {
        font-size: 42px;
        font-weight: bold;
        color: #c2a470;
        margin-bottom: 15px;
      }

      .hero p {
        font-size: 18px;
        margin-bottom: 25px;
        color: white;
      }

      .btn {
        padding: 12px 24px;
        font-size: 16px;
        background-color: #695522;
        color: white;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        margin-top: 10px;
      }

      .btn:hover {
        background-color: #8b6f3d;
      }

      .search-box {
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 30px;
        padding: 12px 25px; 
        position: absolute;
        right: 100px; 
        top: 55%;
        transform: translateY(-50%);
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        width: 500px; 
      }

      .search-box input {
        border: none;
        outline: none;
        font-size: 16px;
        background: transparent;
        padding: 5px;
        width: 350px; 
      }

      .search-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 18px;
      }

    .services-container {
        flex-grow: 1;
        margin-left: 30px;
      }

      .services-container h2 {
        font-size: 24px;
        margin-bottom: 20px;
      }

      .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
      }

      .service-card {
        position: relative;
        width: 100%;
        height: 250px;
        border-radius: 15px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
        font-weight: bold;
        text-align: center;
      }

      .service-card img {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.7);
      }

      .service-card .overlay {
        position: relative;
        z-index: 2;
      }

      .service-card button {
        background:#695522;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 20px;
        font-size: 14px;
        margin-top: 10px;
        cursor: pointer;
      }

      .service-card button:hover {
        background: #8b6f3d;
      }

footer {
    background-color: #1e293b;
    color: white;
    padding: 4rem 2rem 2rem;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

.footer-section h3 {
    margin-bottom: 1rem;
}

.social-links {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.social-links a {
    color: white;
    font-size: 1.25rem;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin-bottom: 0.5rem;
}

.footer-section ul a {
    color: #94a3b8;
    text-decoration: none;
}

.footer-bottom {
    text-align: center;
    padding-top: 2rem;
    margin-top: 2rem;
    border-top: 1px solid #334155;
}

@media (max-width: 768px) {
    .hero {
        grid-template-columns: 1fr;
        text-align: center;
    }

    .hero-buttons {
        justify-content: center;
    }

    .hero-stats {
        justify-content: center;
    }

    .hero-image {
        grid-row: 1;
    }

    .newsletter-form {
        flex-direction: column;
    }
}

    </style>
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
      <div class="hero-content">
        <h1>Grow, Trade & Thrive Together</h1>
        <p>
          Connect with fellow farmers, sell organic produce, and access
          top-quality tools to boost your harvest.
        </p>
        <button class="btn">Join the Marketplace</button>
      </div>

      <div class="search-box">
        <form action="ecommerce/search_product.php" class="form-search" name="desktop-seacrh" method="get">
            <input type="text" name="keyword" class="input-text" placeholder="Search for fresh produce, tools, or expert advice">
          <button  type="submit" class=" search-btn" value="search" name="search" style="margin-left: 20px; boader: none"> Search</button>
        </form>
    </div>
    </section>


    <!-- Services Section -->
    <section class="services-container">
      <h2>Our Services</h2>
      <div class="services-grid">
        <!-- Expert Consultation -->
        <div class="service-card">
          <img src="auth/agriculture_expert.png" />
          <div class="overlay">
            <p>Expert Consultation</p>
            <a href="#"><button>Talk to an Expert</button></a>
          </div>
        </div>

        <!-- Organic Marketplace -->
        <div class="service-card">
          <img src="auth/market.png" alt="Organic Marketplace" />
          <div class="overlay">
            <p>Organic Marketplace</p>
            <a href="#"><button>Explore Now</button></a>
          </div>
        </div>

        <!-- Farm Machinery Rental -->
        <div class="service-card">
          <img src="auth/farm.png" alt="Farm Machinery Rental" />
          <div class="overlay">
            <p>Farm Machinery Rental</p>
            <button>Rent Equipment</button>
          </div>
        </div>

        <!-- AI-Based Farming Suggestions -->
        <div class="service-card">
          <img src="auth/ai.png" alt="AI-Based Suggestions" />
          <div class="overlay">
            <p>AI-Based Farming Suggestions</p>
            <a href="#"><button>Get AI Advice</button></a>
          </div>
        </div>

        <!-- Farmer Community Forum -->
        <div class="service-card">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR7_yCxygk3jEjrYBz96lHMf-GoAcQfz1RRsQ&s" alt="Farmer Community" />
          <div class="overlay">
            <p>Farmer Community Forum</p>
            <a href="#"><button>Join Now</button></a>
          </div>
        </div>

        <!-- Organic Certification Assistance -->
        <div class="service-card">
          <img src="auth/organic.png" alt="Organic Certification" />
          <div class="overlay">
            <p>Organic Certification Assistance</p>
            <a href="#"><button>Get Certified</button></a>
          </div>
        </div>

        <!-- Weather & Crop Alerts -->
        <div class="service-card">
          <img src="auth/weather.png" alt="Weather & Crop Alerts" />
          <div class="overlay">
            <p>Weather & Crop Alerts</p>
            <a href="#"><button>Get Alerts</button></a>
          </div>
        </div>

        <!-- Online Training & Workshops -->
        <div class="service-card">
          <img src="auth/agriculture_training.png" alt="Online Training" />
          <div class="overlay">
            <p>Online Training & Workshops</p>
            <a href="#"><button>Learn More</button></a>
          </div>
        </div>
      </div>
    </section>
<br><br>


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

    <script>
      const navLinks = document.querySelectorAll(".nav-links a");
      const underline = document.querySelector(".underline");

      function moveUnderline(e) {
        const { left, width } = e.target.getBoundingClientRect();
        const navLeft = document
          .querySelector(".nav-links")
          .getBoundingClientRect().left;
        underline.style.width = `${width}px`;
        underline.style.transform = `translateX(${left - navLeft}px)`;
      }

      navLinks.forEach((link) => {
        link.addEventListener("mouseover", moveUnderline);
      });

      document
        .querySelector(".nav-links")
        .addEventListener("mouseleave", () => {
          underline.style.width = "0";
        });
    </script>
  </body>
</html>
