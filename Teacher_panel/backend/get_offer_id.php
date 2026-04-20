<?php
include('db_connection.php');

// Get the parameters from the request
$semesterId = $_GET['semester'];
$sectionId = $_GET['section'];
$subjectId = $_GET['subject'];

// Query to fetch the OfferId based on the Semester, Section, and Subject
$query = "SELECT OfferId FROM subjectoffer WHERE Sem_Id = ? AND Section_Id = ? AND Sub_Id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $semesterId, $sectionId, $subjectId);

$stmt->execute();
$stmt->bind_result($offerId);
$stmt->fetch();

if ($offerId) {
    echo json_encode(["status" => "success", "offerId" => $offerId]);
} else {
    echo json_encode(["status" => "error", "message" => "OfferId not found"]);
}

$stmt->close();
$conn->close();
?>
