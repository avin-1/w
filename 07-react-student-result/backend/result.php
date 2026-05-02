<?php
require 'db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $name   = htmlspecialchars($data['name']);
    $course = htmlspecialchars($data['course']);
    $marks  = json_encode($data['marks']); // store marks as JSON string

    $stmt = mysqli_prepare($conn, "INSERT INTO results (name, course, marks) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $name, $course, $marks);
    mysqli_stmt_execute($stmt);

    echo json_encode(['success' => true, 'message' => 'Result saved']);
}

if ($method === 'GET') {
    $result = mysqli_query($conn, "SELECT * FROM results ORDER BY id DESC");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['marks'] = json_decode($row['marks']);
        $rows[] = $row;
    }
    echo json_encode($rows);
}
