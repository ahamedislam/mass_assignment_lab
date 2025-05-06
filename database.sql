-- Create the database
CREATE DATABASE IF NOT EXISTS mass_assignment;
USE mass_assignment;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'user'
);

-- Add an admin user for testing (password: admin123)
INSERT INTO users (username, email, password, role) 
VALUES ('admin', 'admin@example.com', '$2y$10$8MJKwBMFVGW5.aOWyOlpXeUCRqBjJUZJJ5eBEEqLqU3.lXBw3ZzQi', 'admin');
