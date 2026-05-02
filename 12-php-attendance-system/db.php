<?php
$conn = mysqli_connect('localhost', 'root', '', '');
if (!$conn) die("Connection failed: " . mysqli_connect_error());

mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS attendance_db");
mysqli_select_db($conn, 'attendance_db');

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS students (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    name   VARCHAR(100) NOT NULL,
    rollno VARCHAR(20)  NOT NULL UNIQUE,
    email  VARCHAR(100) NOT NULL
)");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS attendance (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    date       DATE NOT NULL,
    status     ENUM('Present','Absent') NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(id)
)");
