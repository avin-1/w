<?php
$conn = mysqli_connect('localhost', 'root', '', '');
if (!$conn) die("Connection failed: " . mysqli_connect_error());
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS student_db");
mysqli_select_db($conn, 'student_db');
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS students (
    id    INT AUTO_INCREMENT PRIMARY KEY,
    name  VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    course VARCHAR(100) NOT NULL
)");
