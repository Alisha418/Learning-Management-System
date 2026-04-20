<?php
// update_quiz.php

include 'db_connection.php';

// Get the input data
$data = json_decode(file_get_contents("php://input"));

if (isset($data->offerId)) {
    $offerId = $data->offerId;
    $title = $data->title;
    $marks = $data->marks;
    $timer = $data->timer;

    // Step 1: Update the quiz details (quiz table)
    $query = "UPDATE quiz SET QuizTitle = ?, TotalMarks = ?, TimeLimit = ? WHERE Offer_Id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("siis", $title, $marks, $timer, $offerId);
        if ($stmt->execute()) {
            // Step 2: Update the questions (quizquestions table)
            if (isset($data->questions)) {
                // Loop through the questions and update them
                foreach ($data->questions as $question) {
                    // Update or Insert question into the quizquestions table
                    $questionText = $question->text;
                    $optionA = $question->options->A;
                    $optionB = $question->options->B;
                    $optionC = $question->options->C;
                    $optionD = $question->options->D;
                    $correctAnswer = $question->correctAnswer;

                    $query = "UPDATE quizquestions SET QuestionText = ?, OptionA = ?, OptionB = ?, OptionC = ?, OptionD = ?, CorrectOption = ? WHERE Quiz_Id = ?";
                    if ($stmt = $conn->prepare($query)) {
                        $stmt->bind_param("ssssssi", $questionText, $optionA, $optionB, $optionC, $optionD, $correctAnswer, $offerId);
                        $stmt->execute();
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Failed to update question']);
                        exit;
                    }
                }
            }

            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update quiz']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database query preparation failed']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing offerId']);
}

$conn->close();
?>