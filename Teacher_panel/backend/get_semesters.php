<?php
session_start();
require 'db_connection.php';
header('Content-Type: application/json');


// Check if teacher is logged in
if (!isset($_SESSION['teacher_id'])) {
    echo json_encode(["status" => "error", "message" => "Teacher not logged in"]);
    exit;
}

$teacherId = $_SESSION['teacher_id'];

// Fetch all semesters
$query = "SELECT SemId, SemName FROM semester ORDER BY SemName ASC";
$result = $conn->query($query);

$semesters = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $semesters[] = $row;
    }
    echo json_encode(["status" => "success", "semesters" => $semesters]);
} else {
    echo json_encode(["status" => "error", "message" => "No semesters found"]);
}

$conn->close();
?>
