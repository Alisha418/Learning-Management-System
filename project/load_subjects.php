<?php
session_start();
include('connection.php');

// Ensure the student is logged in
if (!isset($_SESSION['user_email'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$stuEmail = $_SESSION['user_email'];
$sectionId = $_POST['sectionId'];
$sessionId = $_POST['sessionId'];

// STEP 1: Get student id and department id
$sql = "
    SELECT student.StuId, department.DepId
    FROM student
    JOIN section ON student.SectionId = section.SectionId
    JOIN department ON section.Dep_Id = department.DepId
    WHERE student.StuEmail = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $stuEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $stuId = $row['StuId'];
    $depId = $row['DepId'];

    // STEP 2: Get offered subjects + whether the student has registered or not
    $sqlSubjects = "
        SELECT 
            subject.SubName, 
            teacher.TName, 
            subjectoffer.OfferId,
            CASE 
                WHEN studentenroll.Stu_Id IS NULL THEN 0
                ELSE 1
            END AS isRegistered
        FROM subjectoffer
        JOIN subject ON subjectoffer.Sub_Id = subject.SubId
        JOIN teacher ON subjectoffer.T_Id = teacher.TeacherId
        JOIN section ON subjectoffer.Section_Id = section.SectionId
        LEFT JOIN studentenroll ON subjectoffer.OfferId = studentenroll.Offer_Id 
                                 AND studentenroll.Stu_Id = ?
        WHERE subjectoffer.Section_Id = ?
          AND subjectoffer.Sem_Id = ?
          AND section.Dep_Id = ?
    ";

    $stmtSubjects = $conn->prepare($sqlSubjects);
    $stmtSubjects->bind_param("iiii", $stuId, $sectionId, $sessionId, $depId);
    $stmtSubjects->execute();
    $subjectsResult = $stmtSubjects->get_result();

    $subjects = [];
    while ($subjectRow = $subjectsResult->fetch_assoc()) {
        $subjects[] = $subjectRow;
    }

    echo json_encode($subjects);
} else {
    echo json_encode(['error' => 'Department or student not found']);
}
?>
