<?php
$conn = mysqli_connect('localhost', 'root', '', '');
if (!$conn) die("DB connection failed: " . mysqli_connect_error());

mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS login_db");
mysqli_select_db($conn, 'login_db');

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS users (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email    VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)");
