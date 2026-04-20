<?php
include 'db_connection.php'; // Your database connection file

if (isset($_GET['offerId'])) {
    $offerId = $_GET['offerId'];

    // Fetch quiz basic info
    $quizQuery = "SELECT QuizTitle, TotalMarks, TimeLimit FROM quiz WHERE Offer_Id = ?";
    $stmtQuiz = $conn->prepare($quizQuery);
    $stmtQuiz->bind_param("i", $offerId);
    $stmtQuiz->execute();
    $resultQuiz = $stmtQuiz->get_result();

    if ($resultQuiz->num_rows > 0) {
        $quiz = $resultQuiz->fetch_assoc();

        // Fetch questions
        $questionQuery = "SELECT QuesId, QuestionText, OptionA, OptionB, OptionC, OptionD, CorrectOption FROM quizquestions WHERE Quiz_Id = (SELECT QuizId FROM quiz WHERE Offer_Id = ?)";
        $stmtQuestions = $conn->prepare($questionQuery);
        $stmtQuestions->bind_param("i", $offerId);
        $stmtQuestions->execute();
        $resultQuestions = $stmtQuestions->get_result();

        $questions = [];
        while ($row = $resultQuestions->fetch_assoc()) {
            $questions[] = $row;
        }

        echo json_encode([
            "quiz" => [
                "title" => $quiz['QuizTitle'],
                "marks" => $quiz['TotalMarks'],
                "timer" => $quiz['TimeLimit']
            ],
            "questions" => $questions
        ]);
    } else {
        echo json_encode(["error" => "Quiz not found"]);
    }
} else {
    echo json_encode(["error" => "Invalid Request"]);
}
?>
