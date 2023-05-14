<?php

// Set headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Connect to the database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'students';
$port = 3306;

$conn = mysqli_connect($host, $username, $password, $database, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create a new student
    $data = json_decode(file_get_contents('php://input'), true);

    $name = mysqli_real_escape_string($conn, $data['name']);
    $last_name = mysqli_real_escape_string($conn, $data['last_name']);
    $age = mysqli_real_escape_string($conn, $data['age']);
    $course = mysqli_real_escape_string($conn, $data['course']);
    $email = mysqli_real_escape_string($conn, $data['email']);

    $sql = "INSERT INTO students (name, last_name, age, course, email)
            VALUES ('$name', '$last_name', $age, '$course', '$email')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['message' => 'Student created']);
    } else {
        echo json_encode(['error' => mysqli_error($conn)]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get all students
    $sql = "SELECT * FROM students";
    $result = mysqli_query($conn, $sql);

    $students = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }

    echo json_encode($students);
}

// Close the database connection
mysqli_close($conn);