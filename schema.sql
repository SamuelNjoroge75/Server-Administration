-- Run with:  sudo mysql < schema.sql
CREATE DATABASE IF NOT EXISTS CAT2;
USE CAT2;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS feedback (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  message TEXT NOT NULL,
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Dedicated database user (change the password before running!)
CREATE USER IF NOT EXISTS 'catuser'@'localhost' IDENTIFIED BY 'ChangeThisPassword123!';
GRANT SELECT, INSERT ON CAT2.* TO 'catuser'@'localhost';
FLUSH PRIVILEGES;
