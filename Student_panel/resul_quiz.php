<?php
session_start();
include('connection.php'); // Include the database connection

// Fetch student details based on the user_email session variable
$user_email = $_SESSION['user_email']; // Use the correct session variable for email

// Fetch student ID and section based on user_email
$student_query = "SELECT StuId, SectionId FROM student WHERE StuEmail = ?";
$stmt = $conn->prepare($student_query);
$stmt->bind_param("s", $user_email);
$stmt->execute();include('project/connection.php');
$student_result = $stmt->get_result();
$student_data = $student_result->fetch_assoc();
$student_id = $student_data['StuId'];
$section_id = $student_data['SectionId'];

// Fetch attempted quizzes for the student
$quiz_query = "
    SELECT q.QuizId, s.SubName AS SubjectName, 
           SUM(CASE WHEN qa.SelectedOption = qq.CorrectOption THEN 1 ELSE 0 END) AS CorrectAnswers,
           COUNT(DISTINCT qq.QuesId) AS TotalQuestions  -- Total number of unique questions in the quiz
    FROM quizattempt qa1
    JOIN quiz q ON qa1.Quiz_Id = q.QuizId
    JOIN subjectoffer so ON q.Offer_Id = so.OfferId
    JOIN subject s ON so.Sub_Id = s.SubId  -- Correct relationship between subject and subjectoffer
    JOIN quizquestions qq ON q.QuizId = qq.Quiz_Id
    JOIN quizanswers qa ON qa.Attempt_Id = qa1.AttemptId
    WHERE qa1.Stu_Id = ? 
    GROUP BY q.QuizId";
    
$stmt = $conn->prepare($quiz_query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$quiz_result = $stmt->get_result();

// Initialize an array to store quiz results
// Initialize an array to store quiz results
$quiz_data = [];

while ($row = $quiz_result->fetch_assoc()) {
    // Make sure to check if the keys exist in the query result
    $correct_answers = isset($row['CorrectAnswers']) ? $row['CorrectAnswers'] : 0;
    $total_questions = isset($row['TotalQuestions']) ? $row['TotalQuestions'] : 0;
    $percentage = $total_questions > 0 ? round(($correct_answers / $total_questions) * 100, 2) : 0;

    $quiz_data[] = [
        'SubjectName' => $row['SubjectName'],
        'CorrectAnswers' => $correct_answers,
        'TotalQuestions' => $total_questions,  // Access the correct key
        'Percentage' => $percentage
    ];
}

?>

<!-- HTML for displaying the quiz results -->
<div class="main-content">
    <div class="content-area">
        <div class="quiz-title">
            <i class="bi bi-lightbulb-fill me-2 fs-4 text-warning"></i>
            <h2 class="dashboard-title">Quiz Results</h2>
        </div>
    </div>

    <div class="main-container">
        <div class="full-cards">
            <!-- Results Section -->
            <div class="result-table-container">
                <table class="result-table">
                    <thead>
                        <tr>
                            <th>Subject Name</th>
                            <th>Correct Answers</th>
                            <th>Total Questions</th> 
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody id="result-body">
                        <?php
                        if (empty($quiz_data)) {
                            echo "<tr><td colspan='4'>No quizzes attempted yet.</td></tr>";
                        } else {
                            foreach ($quiz_data as $quiz) {
                                echo "<tr>
                                        <td>{$quiz['SubjectName']}</td>
                                        <td>{$quiz['CorrectAnswers']}</td>
                                      <td>{$quiz['TotalQuestions']}</td>  
                                        <td>{$quiz['Percentage']}%</td>
                                      </tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
