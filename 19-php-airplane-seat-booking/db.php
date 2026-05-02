<?php
$conn = mysqli_connect('localhost', 'root', '', '');
if (!$conn) die("Connection failed: " . mysqli_connect_error());
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS airline_db");
mysqli_select_db($conn, 'airline_db');

// 30 seats total (rows 1-6, cols A-E)
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS seats (
    seat_no   VARCHAR(5) PRIMARY KEY,
    class     ENUM('Business','Economy') NOT NULL,
    status    ENUM('Available','Booked') DEFAULT 'Available',
    passenger VARCHAR(100) DEFAULT NULL
)");

// Seed seats if empty
$count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM seats"))['c'];
if ($count == 0) {
    for ($row = 1; $row <= 6; $row++) {
        foreach (['A','B','C','D','E'] as $col) {
            $seat  = $row . $col;
            $class = $row <= 2 ? 'Business' : 'Economy';
            mysqli_query($conn, "INSERT INTO seats (seat_no, class) VALUES ('$seat', '$class')");
        }
    }
}
