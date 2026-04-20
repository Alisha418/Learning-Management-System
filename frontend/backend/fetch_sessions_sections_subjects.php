<?php
session_start();
include 'db_connection.php'; // your DB connection file

$teacherId = $_SESSION['teacher_Id']; // Logged-in teacher

// Fetch sessions
$sessionsQuery = "SELECT DISTINCT s.SessionId, s.SessionName
FROM session s
JOIN section sec ON sec.Session_Id = s.SessionId
JOIN subjectoffer so ON so.Section_Id = sec.SectionId
WHERE so.T_Id = '$teacherId'";

$sessionsResult = mysqli_query($conn, $sessionsQuery);
$sessions = mysqli_fetch_all($sessionsResult, MYSQLI_ASSOC);

// Fetch sections
$sectionsQuery = "SELECT DISTINCT sec.SectionId, sec.SectionName
FROM section sec
JOIN subjectoffer so ON so.Section_Id = sec.SectionId
WHERE so.T_Id = '$teacherId'";

$sectionsResult = mysqli_query($conn, $sectionsQuery);
$sections = mysqli_fetch_all($sectionsResult, MYSQLI_ASSOC);

// Fetch subjects
$subjectsQuery = "SELECT DISTINCT sub.SubId, sub.SubName
FROM subject sub
JOIN subjectoffer so ON so.Sub_Id = sub.SubId
WHERE so.T_Id = '$teacherId'";

$subjectsResult = mysqli_query($conn, $subjectsQuery);
$subjects = mysqli_fetch_all($subjectsResult, MYSQLI_ASSOC);

echo json_encode([
    'sessions' => $sessions,
    'sections' => $sections,
    'subjects' => $subjects
]);
?>
