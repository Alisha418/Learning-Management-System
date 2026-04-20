<?php
// Include database connection
include('db_connection.php');

header('Content-Type: application/json');

// Get semesterId from the request
$semesterId = isset($_GET['semester']) ? $_GET['semester'] : '';

if (!$semesterId) {
    echo json_encode(['status' => 'error', 'message' => 'Semester ID is required']);
    exit;
}

// Query to fetch sections for the given semester
$query = "SELECT section.SectionId, section.SectionName
          FROM section
          JOIN subjectoffer ON section.SectionId = subjectoffer.Section_Id
          WHERE subjectoffer.Sem_Id = '$semesterId'";

$result = mysqli_query($conn, $query);

if ($result) {
    $sections = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $sections[] = $row;
    }
    // Return the sections in JSON format
    echo json_encode(['status' => 'success', 'sections' => $sections]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch sections']);
}
?>
