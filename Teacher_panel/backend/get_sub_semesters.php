<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection here
include('db_connection.php');

header('Content-Type: application/json');

// Query to get semesters
$query = "SELECT SemId, SemName FROM semester";
$result = mysqli_query($conn, $query);

// Check if query is successful
if ($result) {
    $semesters = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $semesters[] = $row;
    }
    echo json_encode(['status' => 'success', 'semesters' => $semesters]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch semesters']);
}
?>
