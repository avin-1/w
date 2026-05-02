<?php
$conn = mysqli_connect('localhost', 'root', '', '');
if (!$conn) die("Connection failed: " . mysqli_connect_error());
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS pmc_complaints");
mysqli_select_db($conn, 'pmc_complaints');
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS complaints (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(100) NOT NULL,
    email        VARCHAR(100) NOT NULL,
    organization ENUM('PMC','PMT','VIT','Other') NOT NULL,
    category     VARCHAR(100) NOT NULL,
    complaint    TEXT NOT NULL,
    status       ENUM('Pending','In Progress','Resolved') DEFAULT 'Pending',
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
