<?php
session_start();
include 'db_connection.php';

$teacherId = $_SESSION['teacher_Id'];

$sessionId = $_POST['sessionId'];
$sectionId = $_POST['sectionId'];
$subjectId = $_POST['subjectId'];

$query = "SELECT DISTINCT stu.StuId, stu.StuName
FROM student stu
JOIN studentenroll se ON stu.StuId = se.Stu_Id
JOIN subjectoffer so ON se.Offer_Id = so.OfferId
JOIN section sec ON so.Section_Id = sec.SectionId
WHERE so.T_Id = '$teacherId' 
AND so.Sub_Id = '$subjectId'
AND sec.SectionId = '$sectionId'
AND sec.Session_Id = '$sessionId'";

$result = mysqli_query($conn, $query);
$students = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode($students);
?>
