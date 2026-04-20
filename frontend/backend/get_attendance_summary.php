<?php
include 'db_connection.php';

if (isset($_POST['section'], $_POST['subject'])) {
    $sectionId = $_POST['section'];
    $subjectId = $_POST['subject'];

    // Find OfferId
    $offerSql = "SELECT OfferId FROM subjectoffer WHERE Section_Id='$sectionId' AND Sub_Id='$subjectId' LIMIT 1";
    $offerResult = mysqli_query($conn, $offerSql);

    if ($rowOffer = mysqli_fetch_assoc($offerResult)) {
        $offerId = $rowOffer['OfferId'];

        $sql = "SELECT Date, 
                       COUNT(CASE WHEN Status = 'present' THEN 1 END) as TotalPresent,
                       COUNT(*) as TotalStudents
                FROM attendance
                WHERE Enroll_Id IN (SELECT EnrollId FROM studentenroll WHERE Offer_Id='$offerId')
                GROUP BY Date
                ORDER BY Date DESC";

        $result = mysqli_query($conn, $sql);

        $records = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $percentage = ($row['TotalStudents'] > 0) ? round(($row['TotalPresent'] / $row['TotalStudents']) * 100, 2) : 0;

            $records[] = [
                'ClassName' => 'Section ' . $sectionId . ' - Subject ' . $subjectId, // You can replace with names if needed
                'Date' => $row['Date'],
                'TotalPresent' => $row['TotalPresent'],
                'Percentage' => $percentage,
                'AttendanceGroupId' => md5($row['Date'] . $offerId) // unique id for Update/Delete
            ];
        }

        echo json_encode(['status' => 'success', 'records' => $records]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Offer not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
}
?>
