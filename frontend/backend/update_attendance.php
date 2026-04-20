<?php
// update_attendance.php
include 'db_connection.php'; // apna DB connection include karo

$response = [];

if (isset($_POST['attendanceGroupId']) && isset($_POST['attendanceData'])) {
    $attendanceGroupId = $_POST['attendanceGroupId'];
    $attendanceData = json_decode($_POST['attendanceData'], true); // true -> associative array

    if (is_array($attendanceData)) {
        foreach ($attendanceData as $attendance) {
            $studentEnrollId = $attendance['studentEnrollId'];
            $status = $attendance['status'];

            // Update query
            $query = "UPDATE attendance 
                      SET Status = ?
                      WHERE AttendanceGroupId = ? 
                      AND StudentEnrollId = ?";

            $stmt = $conn->prepare($query);
            $stmt->bind_param('sii', $status, $attendanceGroupId, $studentEnrollId);
            $stmt->execute();
        }

        $response['status'] = 'success';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Invalid attendance data.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Missing required fields.';
}

echo json_encode($response);
?>
