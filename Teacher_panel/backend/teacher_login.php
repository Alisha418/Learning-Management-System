<?php
session_start();

// Database credentials
include 'db_connection.php';

// Set response header
header('Content-Type: application/json');

// Check if input is received
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

$email = trim($data['email']);
$password = trim($data['password']);

if (empty($email)) {
    echo json_encode(["status" => "error", "field" => "email", "message" => "Email field cannot be empty."]);
    exit;
}
if (empty($password)) {
    echo json_encode(["status" => "error", "field" => "password", "message" => "Password field cannot be empty."]);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status" => "error", "field" => "email", "message" => "Enter a valid email address."]);
    exit;
}

// ADD THESE TWO:
if (strlen($password) < 6) {
    echo json_encode(["status" => "error", "field" => "password", "message" => "Password must be at least 6 characters long."]);
    exit;
}
if (!preg_match('/^[a-zA-Z0-9]+$/', $password)) {
    echo json_encode(["status" => "error", "field" => "password", "message" => "Password must be alphanumeric (letters and numbers only)."]);
    exit;
}


// Connect to database
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

// Query to match teacher
$sql = "SELECT * FROM teacher WHERE TEmail = ? AND TPass = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $teacher = $result->fetch_assoc();
    $_SESSION['teacher_id'] = $teacher['TeacherId'];
    $_SESSION['teacher_name'] = $teacher['TName'];
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "field" => "password", "message" => "Email or Password is wrong!"]);
}

$conn->close();
?>
