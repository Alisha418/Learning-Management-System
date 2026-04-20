<?php
session_start();
include('connection.php');

// User login check
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}
// Check if quiz_id is provided
if (!isset($_GET['quiz_id'])) {
    echo "Quiz not selected!";
    exit();
}

// Get quiz ID from the query string
$quizId = $_GET['quiz_id'];
//$quizId = intval($_GET['quiz_id']);

// Fetch quiz details
$quizQuery = "SELECT * FROM quiz WHERE QuizId = ?";
$stmt = $conn->prepare($quizQuery);
$stmt->bind_param("i", $quizId);
$stmt->execute();
$quizResult = $stmt->get_result();

if ($quizResult->num_rows == 0) {
    echo "Quiz not found!";
    exit();
}

$quiz = $quizResult->fetch_assoc();

// Fetch quiz questions
$questionQuery = "SELECT * FROM quizquestions WHERE Quiz_Id = ?";
$stmt2 = $conn->prepare($questionQuery);
$stmt2->bind_param("i", $quizId);
$stmt2->execute();
$questionResult = $stmt2->get_result();
?>

<!-- HTML Part starts -->
 
<div class="main-content">
    
        
            <div class="quiz-title">
                <i class="bi bi-lightbulb-fill me-2 fs-4 text-warning"></i>
                <h2 class="dashboard-title"><?php echo htmlspecialchars($quiz['QuizTitle']); ?></h2>
            </div>
    
            <input type="hidden" id="timeLimit" value="<?php echo $quiz['TimeLimit'] * 60; ?>">
            <div class="timer-container" style="font-size: 25px; color: #2f2f4c; font-weight:bold; margin-left: 400px; ">
                <i class="bi bi-clock"></i>
                Time Left: <span id="timer"></span>
     


    </div>
    

    

    <form   action="submitquiz.php" method="POST"  id="quizForm">
    <input type="hidden" name="quiz_id" value="<?php echo $quizId; ?>">

    <?php
    if ($questionResult->num_rows > 0) {
        $questionNumber = 1;
        while ($question = $questionResult->fetch_assoc()) {
            ?>
            <div class="mcq-container">
                <div class="question-container" id="question-<?php echo $questionNumber; ?>">
                    <div class="question-number">
                        <i class="bi bi-question-circle question-icon"></i>
                        <span>Question <?php echo $questionNumber; ?> of <?php echo $questionResult->num_rows; ?></span>
                    </div>
                    <div class="mcq-header">
                        <h2><?php echo htmlspecialchars($question['QuestionText']); ?></h2>
                    </div>
                    <div class="mcq-options">
                        <label class="option">
                            <input type="radio" name="answers[<?php echo $question['QuesId']; ?>]" value="A"> <?php echo htmlspecialchars($question['OptionA']); ?>
                        </label><br>
                        <label class="option">
                            <input type="radio" name="answers[<?php echo $question['QuesId']; ?>]" value="B"> <?php echo htmlspecialchars($question['OptionB']); ?>
                        </label><br>
                        <label class="option">
                            <input type="radio" name="answers[<?php echo $question['QuesId']; ?>]" value="C"> <?php echo htmlspecialchars($question['OptionC']); ?>
                        </label><br>
                        <label class="option">
                            <input type="radio" name="answers[<?php echo $question['QuesId']; ?>]" value="D" ><?php echo htmlspecialchars($question['OptionD']); ?>
                        </label><br>
                    </div>
                </div>
            </div>
            <?php
            $questionNumber++;
        }
    } else {
        echo '<p style="text-align:center; font-size:24px;">No Questions Available!</p>';
    }
    ?>

    <!-- Submit Button -->
    <div class="button-container" style="text-align: center; margin: 20px;">
        <button type="submit" class="btn btn-primary submit-quiz" >Submit Quiz</button>
    </div>
    </form>
    <!-- Quiz Form End -->

</div>

<!-- Optional: Timer JavaScript -->
