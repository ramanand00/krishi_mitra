CREATE DATABASE krishi_mitra;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    user_type ENUM('farmer', 'consumer', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE users
ADD COLUMN reset_token VARCHAR(255) DEFAULT NULL;
ALTER TABLE users ADD COLUMN   profile_picture VARCHAR(300) NOT NULL DEFAULT 'default.jpg';
