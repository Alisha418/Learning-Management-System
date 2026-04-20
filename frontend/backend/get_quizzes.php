<?php
// Database connection
include 'db_connection.php'; // <-- apni connection file ka sahi naam lagana

header('Content-Type: application/json');

// Fetch quizzes from database
$sql = "SELECT q.QuizId, q.QuizTitle, q.TotalMarks, q.TimeLimit, q.CreatedDate, 
               so.OfferId, s.SemName, se.SectionName, sub.SubName 
        FROM quiz q
        JOIN subjectoffer so ON q.Offer_Id = so.OfferId
        JOIN semester s ON so.Sem_Id = s.SemId
        JOIN section se ON so.Section_Id = se.SectionId
        JOIN subject sub ON so.Sub_Id = sub.SubId";

// Query execution
$result = $conn->query($sql);

$quizzes = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Create a unique key for each quiz based on the combination of Semester, Section, and Subject
        $key = strtolower($row['SemName'] . "_" . $row['SectionName'] . "_" . $row['SubName']);
        
        if (!isset($quizzes[$key])) {
            $quizzes[$key] = [];
        }
        
        // Push the quiz data into the quizzes array
        $quizzes[$key][] = [
            'title' => $row['QuizTitle'],
            'marks' => $row['TotalMarks'],
            'timer' => $row['TimeLimit'],
            'semester' => $row['SemName'],
            'section' => $row['SectionName'],
            'subject' => $row['SubName']
        ];
    }
}

// Return the quizzes data as JSON
echo json_encode($quizzes);
?>
