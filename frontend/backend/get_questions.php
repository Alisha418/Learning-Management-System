<?php
include 'db_connection.php';

$quizId = $_GET['quiz_id'];
$stmt = $conn->prepare("SELECT QuesId, QuestionText, OptionA, OptionB, OptionC, OptionD FROM quizquestions WHERE Quiz_Id = ?");
$stmt->bind_param("i", $quizId);
$stmt->execute();

$result = $stmt->get_result();
$questions = [];

while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}

echo json_encode($questions);
?>
