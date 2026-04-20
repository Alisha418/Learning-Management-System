<?php
include 'db_connection.php';

if (isset($_POST['section'], $_POST['subject'], $_POST['date'], $_POST['attendance'])) {
    $sectionId = $_POST['section'];
    $subjectId = $_POST['subject'];
    $date = $_POST['date'];
    $attendanceList = json_decode($_POST['attendance'], true);

    // Find OfferId
    $offerSql = "SELECT OfferId FROM subjectoffer WHERE Section_Id='$sectionId' AND Sub_Id='$subjectId' LIMIT 1";
    $offerResult = mysqli_query($conn, $offerSql);

    if ($rowOffer = mysqli_fetch_assoc($offerResult)) {
        $offerId = $rowOffer['OfferId'];

        // Save attendance
        foreach ($attendanceList as $entry) {
            $studentId = $entry['studentId'];
            $status = $entry['status'];

            // Find EnrollId
            $enrollSql = "SELECT EnrollId FROM studentenroll WHERE Stu_Id='$studentId' AND Offer_Id='$offerId' LIMIT 1";
            $enrollResult = mysqli_query($conn, $enrollSql);

            if ($rowEnroll = mysqli_fetch_assoc($enrollResult)) {
                $enrollId = $rowEnroll['EnrollId'];

                $insertSql = "INSERT INTO attendance (Enroll_Id, Date, Status) 
                              VALUES ('$enrollId', '$date', '$status')";
                mysqli_query($conn, $insertSql);
            }
        }

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Offer not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
?>
