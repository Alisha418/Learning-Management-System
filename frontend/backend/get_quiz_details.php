<?php
include 'db_connection.php';

$quizId = $_GET['quizId'];

$quizResult = $conn->query("SELECT * FROM quiz WHERE QuizId = $quizId");
$quiz = $quizResult->fetch_assoc();

$questionsResult = $conn->query("SELECT * FROM quizquestions WHERE Quiz_Id = $quizId");
$questions = [];
while ($row = $questionsResult->fetch_assoc()) {
    $questions[] = $row;
}

echo json_encode([
    'QuizId' => $quiz['QuizId'],
    'QuizTitle' => $quiz['QuizTitle'],
    'TotalMarks' => $quiz['TotalMarks'],
    'TimeLimit' => $quiz['TimeLimit'],
    'CreatedDate' => $quiz['CreatedDate'],
    'Questions' => $questions
]);
?>
