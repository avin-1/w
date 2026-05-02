<?php
$conn = mysqli_connect('localhost', 'root', '', '');
if (!$conn) die("Connection failed: " . mysqli_connect_error());
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS waste_db");
mysqli_select_db($conn, 'waste_db');
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS waste_reports (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    waste_type   ENUM('Plastic','Paper','Metal','Other') NOT NULL,
    location     VARCHAR(255) NOT NULL,
    description  TEXT,
    status       ENUM('Pending','Assigned','Collected') DEFAULT 'Pending',
    reported_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
