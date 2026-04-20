<?php
include 'db_connection.php';

if (isset($_POST['attendanceGroupId'], $_POST['section'], $_POST['subject'])) {
    $attendanceGroupId = $_POST['attendanceGroupId'];
    $sectionId = $_POST['section'];
    $subjectId = $_POST['subject'];

    // Get OfferId
    $offerSql = "SELECT OfferId FROM subjectoffer WHERE Section_Id='$sectionId' AND Sub_Id='$subjectId' LIMIT 1";
    $offerResult = mysqli_query($conn, $offerSql);

    if ($rowOffer = mysqli_fetch_assoc($offerResult)) {
        $offerId = $rowOffer['OfferId'];

        $attendanceSql = "SELECT DISTINCT Date FROM attendance 
                          WHERE Enroll_Id IN (SELECT EnrollId FROM studentenroll WHERE Offer_Id='$offerId')";

        $attendanceResult = mysqli_query($conn, $attendanceSql);

        $found = false;
        while ($row = mysqli_fetch_assoc($attendanceResult)) {
            $date = $row['Date'];
            $checkId = md5($date . $offerId);

            if ($checkId === $attendanceGroupId) {
                $deleteSql = "DELETE FROM attendance 
                              WHERE Date='$date' 
                              AND Enroll_Id IN (SELECT EnrollId FROM studentenroll WHERE Offer_Id='$offerId')";

                if (mysqli_query($conn, $deleteSql)) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to delete attendance.']);
                }
                $found = true;
                break;
            }
        }

        if (!$found) {
            echo json_encode(['status' => 'error', 'message' => 'Attendance record not found.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Offer not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
