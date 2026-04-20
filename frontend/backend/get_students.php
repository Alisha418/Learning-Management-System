<?php
include 'db_connection.php';

if (isset($_POST['section']) && isset($_POST['subject'])) {
    $sectionId = $_POST['section'];
    $subjectId = $_POST['subject'];

    // First find OfferId from subjectoffer
    $sqlOffer = "SELECT OfferId FROM subjectoffer 
                 WHERE Section_Id = '$sectionId' AND Sub_Id = '$subjectId' LIMIT 1";

    $resultOffer = mysqli_query($conn, $sqlOffer);

    if ($rowOffer = mysqli_fetch_assoc($resultOffer)) {
        $offerId = $rowOffer['OfferId'];

        // Now find students enrolled in this OfferId
        $sqlStudents = "SELECT student.StuId, student.StuName 
                        FROM studentenroll
                        INNER JOIN student ON student.StuId = studentenroll.Stu_Id
                        WHERE studentenroll.Offer_Id = '$offerId'";

        $resultStudents = mysqli_query($conn, $sqlStudents);

        $students = [];

        if ($resultStudents) {
            while ($row = mysqli_fetch_assoc($resultStudents)) {
                $students[] = $row;
            }
            echo json_encode(['status' => 'success', 'students' => $students]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to fetch students']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No offer found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
}
?>
