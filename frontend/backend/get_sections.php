<?php
include 'db_connection.php';

$sql = "SELECT SectionId, SectionName FROM section";
$result = mysqli_query($conn, $sql);

$sections = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sections[] = $row;
    }
    echo json_encode(['status' => 'success', 'sections' => $sections]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch sections']);
}
?>
