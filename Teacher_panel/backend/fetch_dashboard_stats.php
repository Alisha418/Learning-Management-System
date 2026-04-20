<?php
// db_connection.php include kar rahe hain
include 'db_connection.php';

// Total Subjects
$subjectCountQuery = $conn->query("SELECT COUNT(*) AS total_subjects FROM subject");
$subjectCount = $subjectCountQuery->fetch_assoc()['total_subjects'];

// Registered Students
$studentCountQuery = $conn->query("SELECT COUNT(*) AS total_students FROM student");
$studentCount = $studentCountQuery->fetch_assoc()['total_students'];

// Attendance Reports
$attendanceCountQuery = $conn->query("SELECT COUNT(*) AS total_attendance_reports FROM attendance");
$attendanceCount = $attendanceCountQuery->fetch_assoc()['total_attendance_reports'];

// Total Quiz
$quizCountQuery = $conn->query("SELECT COUNT(*) AS total_quiz FROM quiz");
$quizCount = $quizCountQuery->fetch_assoc()['total_quiz'];

// Articles
$articleCountQuery = $conn->query("SELECT COUNT(*) AS total_articles FROM article");
$articleCount = $articleCountQuery->fetch_assoc()['total_articles'];

// Feedback
$feedbackCountQuery = $conn->query("SELECT COUNT(*) AS total_feedback FROM surveysubmit");
$feedbackCount = $feedbackCountQuery->fetch_assoc()['total_feedback'];
?>
