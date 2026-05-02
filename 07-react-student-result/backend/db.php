<?php
$conn = mysqli_connect('localhost', 'root', '', '');

if (!$conn) die("Connection failed: " . mysqli_connect_error());

mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS vit_results");
mysqli_select_db($conn, 'vit_results');

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS results (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    name   VARCHAR(100),
    course VARCHAR(100),
    marks  TEXT
)");
