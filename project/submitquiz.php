<?php
session_start();
include('connection.php');

// User login check
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

// Get quiz_id and student email
$quizId = $_POST['quiz_id'];
$user_email = $_SESSION['user_email'];

// Fetch the student ID
$query = "SELECT StuId FROM student WHERE StuEmail = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Student not found!'); window.location.href = 'dashboard.php';</script>";
    exit();
}
$stu_id = $result->fetch_assoc()['StuId'];

// 🛑 Check if the student already submitted this quiz
$query = "SELECT * FROM quizattempt WHERE Stu_Id = ? AND Quiz_Id = ?";
$stmt2 = $conn->prepare($query);
$stmt2->bind_param("ii", $stu_id, $quizId);
$stmt2->execute();
$attemptResult = $stmt2->get_result();

if ($attemptResult->num_rows > 0) {
    echo "<script>alert('You have already submitted this quiz!'); window.location.href = 'dashboard.php';</script>";
    exit();
}

// Validate quiz existence
$query = "SELECT * FROM quiz WHERE QuizId = ?";
$stmt3 = $conn->prepare($query);
$stmt3->bind_param("i", $quizId);
$stmt3->execute();
$quizResult = $stmt3->get_result();
if ($quizResult->num_rows == 0) {
    echo "<script>alert('Quiz not found!'); window.location.href = 'dashboard.php';</script>";
    exit();
}

// Fetch quiz questions
$query = "SELECT * FROM quizquestions WHERE Quiz_Id = ?";
$stmt4 = $conn->prepare($query);
$stmt4->bind_param("i", $quizId);
$stmt4->execute();
$questions = $stmt4->get_result();

// Calculate score
$total_correct = 0;
$total_wrong = 0;
$answers = [];

while ($row = $questions->fetch_assoc()) {
    $ques_id = $row['QuesId'];
    $correct_option = $row['CorrectOption'];

    if (isset($_POST["answers"][$ques_id])) {
        $selected_option = $_POST["answers"][$ques_id];
        $answers[] = [
            'ques_id' => $ques_id,
            'selected_option' => $selected_option
        ];

        if ($selected_option === $correct_option) {
            $total_correct++;
        } else {
            $total_wrong++;
        }
    } else {
        $total_wrong++;
    }
}

$total_marks = $questions->num_rows;
$score = ($total_correct / $total_marks) * 100;

// Insert quiz attempt
$end_time = date('Y-m-d H:i:s');

$query = "INSERT INTO quizattempt (Stu_Id, Quiz_Id, StartTime, EndTime, Score, TotalCorrect, TotalWrong)
          VALUES (?, ?, NOW(), ?, ?, ?, ?)";
$stmt5 = $conn->prepare($query);
$stmt5->bind_param("iissii", $stu_id, $quizId, $end_time, $score, $total_correct, $total_wrong);

if (!$stmt5->execute()) {
    echo "<script>alert('Error saving quiz attempt!'); window.location.href = 'Dashboard.php';</script>";
    exit();
}

$attempt_id = $stmt5->insert_id;

// Insert each answer
foreach ($answers as $answer) {
    $ques_id = $answer['ques_id'];
    $selected_option = $answer['selected_option'];

    $query = "INSERT INTO quizanswers (Attempt_Id, Ques_Id, SelectedOption)
              VALUES (?, ?, ?)";
    $stmt6 = $conn->prepare($query);
    $stmt6->bind_param("iis", $attempt_id, $ques_id, $selected_option);
    $stmt6->execute();
}

// ✅ Finally, redirect to result page
header("Location: Result.php?attempt_id=$attempt_id");
exit();
?>
