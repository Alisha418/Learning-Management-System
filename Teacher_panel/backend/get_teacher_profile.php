<?php
session_start();  // Start the session
header('Content-Type: application/json');

// ✅ Check if teacher is logged in
if (!isset($_SESSION['teacher_id'])) {  // Check if 'teacher_id' exists in the session
    echo json_encode(["status" => "error", "message" => "Unauthorized access. Please login first."]);
    exit;
}

// Debugging line to check session
error_log("Teacher ID in session: " . $_SESSION['teacher_id']);  

include 'db_connection.php';

// Check for connection errors
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

$teacherId = $_SESSION['teacher_id'];  // Use 'teacher_id' consistently here

// Fetch teacher profile based on the logged-in teacher's ID
$sql = "SELECT TName, TGender, TAddress, TQualification, TMarried, TPhone, TSalary, TEmail FROM teacher WHERE TeacherId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacherId);  // Binding the teacher's ID as an integer
$stmt->execute();
$result = $stmt->get_result();  // Get the result of the query

// Check if the teacher profile was found
if ($result->num_rows === 1) {
    $teacher = $result->fetch_assoc();  // Fetch teacher data
    echo json_encode(["status" => "success", "data" => $teacher]);  // Return the teacher's data as JSON
} else {
    echo json_encode(["status" => "error", "message" => "Teacher not found"]);  // Handle case where no teacher is found
}

$conn->close();  // Close the database connection
?>
