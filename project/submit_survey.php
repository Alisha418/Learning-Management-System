<?php
session_start();
include('connection.php');

$student_id = $_POST['student_id'];
$subject_id = $_POST['subject_id'];
$feedback = $_POST['feedback'];
$survey_answers = json_decode($_POST['survey_answers'], true); // <<< FIXED (decode JSON to PHP array)

// Step 1: Check if the student has already submitted for this subject
$check_sql = "SELECT * FROM surveysubmit WHERE Stu_Id = ? AND Sub_Id = ?";
$stmt = $conn->prepare($check_sql);
$stmt->bind_param("ii", $student_id, $subject_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'You have already submitted the survey.']);
    exit();
}

// Step 2: Insert into surveysubmit
$insert_submit = "INSERT INTO surveysubmit (Stu_Id, Sub_Id, Email, Comment) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($insert_submit);
$stmt->bind_param("iiss", $student_id, $subject_id, $_SESSION['user_email'], $feedback);

if ($stmt->execute()) {
    $submit_id = $stmt->insert_id; // Get the SurveySubmitId

    // Step 3: Insert each survey answer
    $insert_answer = "INSERT INTO surveyanswers (Submit_Id, Ques_Id, Option_Id, Stu_Id, Sub_Id) VALUES (?, ?, ?, ?, ?)";
    $stmt_ans = $conn->prepare($insert_answer);

    foreach ($survey_answers as $ques_id => $option_id) {
        $stmt_ans->bind_param("iiiii", $submit_id, $ques_id, $option_id, $student_id, $subject_id);
        $stmt_ans->execute();
    }

    echo json_encode(['status' => 'success', 'message' => 'Survey submitted successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error submitting survey.']);
}
?>
