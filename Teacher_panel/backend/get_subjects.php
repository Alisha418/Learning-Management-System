<?php
include 'db_connection.php';

if (isset($_GET['section'])) {
    $sectionId = $_GET['section'];

    // Fetch subjects offered in this section
    $sql = "SELECT subject.SubId, subject.SubName 
            FROM subject 
            INNER JOIN subjectoffer ON subject.SubId = subjectoffer.Sub_Id 
            WHERE subjectoffer.Section_Id = '$sectionId'";

    $result = mysqli_query($conn, $sql);

    $subjects = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $subjects[] = $row;
        }
        echo json_encode(['status' => 'success', 'subjects' => $subjects]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to fetch subjects']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing section parameter']);
}
?>
