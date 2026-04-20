<?php
include 'db_connection.php';  // Include your database connection

// Get data from frontend (JSON input)
$data = json_decode(file_get_contents("php://input"), true);

// Check if necessary data is available
if (isset($data['title']) && isset($data['marks']) && isset($data['timer']) && isset($data['offerId']) && isset($data['questions'])) {
    $title = mysqli_real_escape_string($conn, $data['title']);
    $marks = mysqli_real_escape_string($conn, $data['marks']);
    $timer = mysqli_real_escape_string($conn, $data['timer']);
    $offerId = mysqli_real_escape_string($conn, $data['offerId']);

    // Step 1: Insert quiz data into the database
    $query = "INSERT INTO quiz (QuizTitle, TotalMarks, TimeLimit, Offer_Id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $title, $marks, $timer, $offerId);

    if (mysqli_stmt_execute($stmt)) {
        $quizId = mysqli_insert_id($conn);  // Get the last inserted QuizId

        // Step 2: Insert questions associated with this quiz
        foreach ($data['questions'] as $question) {
            $questionText = mysqli_real_escape_string($conn, $question['text']);
            $optionA = mysqli_real_escape_string($conn, $question['options']['A']);
            $optionB = mysqli_real_escape_string($conn, $question['options']['B']);
            $optionC = mysqli_real_escape_string($conn, $question['options']['C']);
            $optionD = mysqli_real_escape_string($conn, $question['options']['D']);
            $correctAnswer = mysqli_real_escape_string($conn, $question['correctAnswer']);

            // Step 3: Insert question data
            $questionQuery = "INSERT INTO quizquestions (Quiz_Id, QuestionText, OptionA, OptionB, OptionC, OptionD, CorrectOption) 
                              VALUES (?, ?, ?, ?, ?, ?, ?)";
            $questionStmt = mysqli_prepare($conn, $questionQuery);
            mysqli_stmt_bind_param($questionStmt, "issssss", $quizId, $questionText, $optionA, $optionB, $optionC, $optionD, $correctAnswer);
            mysqli_stmt_execute($questionStmt);
        }

        // Step 4: Return QuizId and success response
        echo json_encode(['status' => 'success', 'quizId' => $quizId]);
    } else {
        // If quiz insertion fails, return error message
        echo json_encode(['status' => 'error', 'message' => 'Failed to save quiz.']);
    }
} else {
    // If required data is not present
    echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
}
?>
