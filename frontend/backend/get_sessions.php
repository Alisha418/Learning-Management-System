<?php
session_start(); // ✅ Required to use session variables

require_once 'db_connection.php';

// ✅ Check if teacher is logged in
if (!isset($_SESSION['teacher_id'])) {
    echo json_encode(["status" => "error", "message" => "Teacher not logged in"]);
    exit;
}

$teacherId = $_SESSION['teacher_id'];

// Prepare the SQL query to fetch sessions for the logged-in teacher
$sql = "SELECT DISTINCT s.SessionId, s.SessionName
        FROM session s
        INNER JOIN section sec ON s.SessionId = sec.Session_Id
        INNER JOIN subjectoffer so ON sec.SectionId = so.Section_Id
        WHERE so.T_Id = ?";

// Prepare the statement
$stmt = mysqli_prepare($conn, $sql);

// Check if the statement was prepared successfully
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Failed to prepare the query"]);
    exit;
}

// Bind the teacherId parameter to the prepared statement
mysqli_stmt_bind_param($stmt, "i", $teacherId);

// Execute the statement
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $sessions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $sessions[] = $row;
    }
    echo json_encode(["status" => "success", "sessions" => $sessions]);
} else {
    echo json_encode(["status" => "success", "sessions" => []]);
}

// Close the prepared statement
mysqli_stmt_close($stmt);

?>
