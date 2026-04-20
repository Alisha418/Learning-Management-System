<?php
require_once 'db_connection.php'; // Make sure this connects to your DB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session = $_POST['session'];
    $section = $_POST['section'];
    $subject = $_POST['subject'];

    // Fetch students enrolled in the given session, section, and subject
    $query = "
        SELECT s.StudentId AS id, s.SName AS name
        FROM studentenroll se
        JOIN student s ON se.StudentId = s.StudentId
        WHERE se.Session = ? AND se.Section = ? AND se.SubjectCode = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $session, $section, $subject);
    $stmt->execute();
    $result = $stmt->get_result();

    $students = [];

    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    echo json_encode($students);
}
?>
