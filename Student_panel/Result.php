<?php
include('connection.php');

$attempt_id = $_GET['attempt_id']; // Get attempt ID from URL

// Check if attempt_id is set and valid
if (!isset($attempt_id) || !is_numeric($attempt_id)) {
    echo "Invalid attempt ID!";
    exit();
}

// 1. Fetch attempt details using prepared statement
$query = "SELECT * FROM quizattempt WHERE AttemptId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $attempt_id);
$stmt->execute();
$result = $stmt->get_result();
$attempt = $result->fetch_assoc();

// Check if attempt exists
if (!$attempt) {
    echo "No attempt found!";
    exit();
}

$score = $attempt['Score'];
$total_correct = $attempt['TotalCorrect'];
$total_wrong = $attempt['TotalWrong'];

// 2. Fetch quiz details using prepared statement
$quiz_id = $attempt['Quiz_Id'];
$query = "SELECT * FROM quiz WHERE QuizId = ?";
$stmt2 = $conn->prepare($query);
$stmt2->bind_param("i", $quiz_id);
$stmt2->execute();
$quiz_result = $stmt2->get_result();
$quiz = $quiz_result->fetch_assoc();

// Check if quiz exists
if (!$quiz) {
    echo "Quiz not found!";
    exit();
}

// 3. Fetch total number of questions dynamically
$query = "SELECT COUNT(*) as total_questions FROM quizquestions WHERE Quiz_Id = ?";
$stmt3 = $conn->prepare($query);
$stmt3->bind_param("i", $quiz_id);
$stmt3->execute();
$question_result = $stmt3->get_result();
$question_row = $question_result->fetch_assoc();
$total_questions = $question_row['total_questions'];

// 4. Fetch the answers for each question for this attempt
$query = "SELECT qq.QuestionText, qa.SelectedOption, qq.CorrectOption
          FROM quizquestions qq
          JOIN quizanswers qa ON qq.QuesId = qa.Ques_Id
          WHERE qa.Attempt_Id = ?";
$stmt4 = $conn->prepare($query);
$stmt4->bind_param("i", $attempt_id);
$stmt4->execute();
$answers_result = $stmt4->get_result();

// 5. Display Results
?>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
<div class="main-content">
    <div class="content-area">
        <div class="dashboard-header">
            <div class="quiz-title">
                <i class="bi bi-lightbulb-fill me-2 fs-4 text-warning"></i>
                <h2 class="dashboard-title">Quiz</h2>
            </div>
        </div>
    </div>
    <div class="container_1">
        <div class="result-card">
            <h2>Quiz Results</h2>
            <div class="result-section">
                <h5>Total Questions:</h5>
                <span class="value"><?php echo $total_questions; ?></span>
            </div>
            <div class="result-section">
                <h5>Right Answers:</h5>
                <span class="value"><?php echo $total_correct; ?></span>
            </div>
            <div class="result-section">
                <h5>Wrong Answers:</h5>
                <span class="value"><?php echo $total_wrong; ?></span>
            </div>
            <div class="result-section">
                <h5>Score:</h5>
                <span class="value"><?php echo $score . '%'; ?></span>
            </div>

            <div class="back-button">
    <button onclick="loadQuizList()" class="btn btn-primary">Back to Quiz List</button>
</div>
        </div>
    </div>
</div>
