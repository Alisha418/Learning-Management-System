<?php
// Include database connection
include('db_connection.php');

header('Content-Type: application/json');

// Get parameters
$semesterId = isset($_GET['semester']) ? $_GET['semester'] : '';
$sectionId = isset($_GET['section']) ? $_GET['section'] : '';

if (!$semesterId || !$sectionId) {
    echo json_encode(['status' => 'error', 'message' => 'Semester and Section are required']);
    exit;
}

// Query to fetch subjects based on semester and section
$query = "SELECT subject.SubId, subject.SubName, subject.CreditHors
          FROM subject
          JOIN subjectoffer ON subjectoffer.Sub_Id = subject.SubId
          WHERE subjectoffer.Sem_Id = '$semesterId' AND subjectoffer.Section_Id = '$sectionId'";

$result = mysqli_query($conn, $query);

if ($result) {
    $subjects = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $subjects[] = $row;
    }
    echo json_encode(['status' => 'success', 'subjects' => $subjects]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch subjects']);
}
?>
