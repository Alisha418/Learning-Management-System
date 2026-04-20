<?php
session_start();
include('connection.php');// apna database connection yahan include karo

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user_email'];

// Student ki details nikalna
$studentQuery = "SELECT * FROM student WHERE StuEmail = ?";
$stmt = $conn->prepare($studentQuery);
$stmt->bind_param("s", $email);
$stmt->execute();
$studentResult = $stmt->get_result();

if ($studentResult->num_rows == 0) {
    echo "Student not found!";
    exit();
}

$student = $studentResult->fetch_assoc();
$stuId = $student['StuId'];

// Enrolled offers nikalna
$enrollQuery = "
    SELECT subject.SubName, quiz.*
    FROM studentenroll
    JOIN subjectoffer ON studentenroll.Offer_Id = subjectoffer.OfferId
    JOIN subject ON subjectoffer.Sub_Id = subject.SubId
    JOIN quiz ON subjectoffer.OfferId = quiz.Offer_Id
    WHERE studentenroll.Stu_Id = ?
";
$stmt2 = $conn->prepare($enrollQuery);
$stmt2->bind_param("i", $stuId);
$stmt2->execute();
$quizResult = $stmt2->get_result();
?>

<!-- HTML part -->
<div class="main-content">
    <div class="content-area">
        <div class="dashboard-header">
            <div class="quiz-title">
                <i class="bi bi-lightbulb-fill me-2 fs-4 text-warning"></i>
                <h2 class="dashboard-title">Quiz</h2>
            </div>
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" id="searchBox" placeholder="Search bar design guide">
            </div>
        </div>

        <p id="noResultsMessage" style="text-align: center; font-size: 24px; display: none;">
            Results are not matched!
        </p>

        <div class="card-container" id="quizContainer">
            <?php
            if ($quizResult->num_rows > 0) {
                while ($quiz = $quizResult->fetch_assoc()) {
                    ?>
                    <div class="card" data-subject="<?php echo htmlspecialchars($quiz['SubName']); ?>">
                        <div class="card-header">
                            <img src="img.jpg" alt="Subject Image" class="card-image">
                        </div>
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($quiz['QuizTitle']); ?></h3>
                            <p><i class="bi bi-book" style="margin-right: 4px;"></i><strong>Subject:</strong> <?php echo htmlspecialchars($quiz['SubName']); ?></p>
                            <p><i class="bi bi-award" style="margin-right: 4px;"></i><strong>Marks:</strong> <?php echo htmlspecialchars($quiz['TotalMarks']); ?></p>
                            <p><i class="bi bi-question-circle" style="margin-right: 4px;"></i><strong>Total Questions:</strong> 
                                <?php
                                // Count number of questions
                                $quesQuery = "SELECT COUNT(*) as total FROM quizquestions WHERE Quiz_Id = ?";
                                $stmt3 = $conn->prepare($quesQuery);
                                $stmt3->bind_param("i", $quiz['QuizId']);
                                $stmt3->execute();
                                $quesResult = $stmt3->get_result();
                                $quesCount = $quesResult->fetch_assoc()['total'];
                                echo $quesCount;
                                ?>
                            </p>
                            <p><i class="bi bi-clock" style="margin-right: 4px;"></i><strong>Time Limit:</strong> <?php echo htmlspecialchars($quiz['TimeLimit']); ?> minutes</p>
                            <div class="footer">
                                <span class="questions"><i class="bi bi-card-checklist" style="margin-right: 4px;"></i><?php echo $quesCount; ?> Questions</span>
                            </div>
                            <button class="start-btn" onclick="loadQuiz(<?php echo $quiz['QuizId']; ?>)">Start Test</button>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p style="text-align:center; font-size:24px;">No Quizzes Available!</p>';
            }
            ?>
        </div>
    </div>
</div>


