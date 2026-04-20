<?php
// get_attendance_for_update.php
include 'db_connection.php';// apna DB connection include karo

$response = [];

if (isset($_POST['attendanceGroupId']) && isset($_POST['section']) && isset($_POST['subject'])) {
    $attendanceGroupId = $_POST['attendanceGroupId'];
    $sectionId = $_POST['section'];
    $subjectId = $_POST['subject'];

    // Fetch enrolled students and their attendance status
    $query = "
        SELECT 
            se.StudentEnrollId,
            s.StudentName,
            a.Status AS AttendanceStatus
        FROM 
            studentenroll se
        INNER JOIN 
            student s ON se.StudentId = s.StudentId
        LEFT JOIN 
            attendance a ON se.StudentEnrollId = a.StudentEnrollId AND a.AttendanceGroupId = ?
        WHERE 
            se.SectionId = ? 
            AND se.SubjectId = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('iii', $attendanceGroupId, $sectionId, $subjectId);
    $stmt->execute();
    $result = $stmt->get_result();

    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = [
            'StudentEnrollId' => $row['StudentEnrollId'],
            'StudentName' => $row['StudentName'],
            'AttendanceStatus' => $row['AttendanceStatus'] ?? '' // null ho to empty string
        ];
    }

    $response['status'] = 'success';
    $response['students'] = $students;
} else {
    $response['status'] = 'error';
    $response['message'] = 'Missing required fields.';
}

echo json_encode($response);
?>
