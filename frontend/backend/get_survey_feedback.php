<?php
include 'db_connection.php';

header('Content-Type: application/json'); // Always set JSON header

if (!isset($_GET['subject']) || empty($_GET['subject'])) {
    echo json_encode(['status' => 'error', 'message' => 'Subject ID is missing']);
    exit;
}

$subjectId = mysqli_real_escape_string($conn, $_GET['subject']);  // Secure way to get subject ID

// Step 1: Fetch all the questions related to the selected subject
$sql = "SELECT QuesId, QuesText
        FROM surveyquestions
        WHERE Sub_Id = '$subjectId'";

$result = mysqli_query($conn, $sql);
$questions = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $questions[] = $row;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch survey questions']);
    exit;
}

// Step 2: Fetch all the options related to these questions
$optionsSql = "SELECT OptionId, OptionText, Ques_Id 
               FROM surveyoptions
               WHERE Ques_Id IN (SELECT QuesId FROM surveyquestions WHERE Sub_Id = '$subjectId')";

$optionsResult = mysqli_query($conn, $optionsSql);
$options = [];

if ($optionsResult) {
    while ($row = mysqli_fetch_assoc($optionsResult)) {
        $options[$row['Ques_Id']][] = $row; // Group options by Ques_Id
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch survey options']);
    exit;
}

// Step 3: Fetch all answers submitted by students for this subject
$sqlAnswers = "SELECT sa.Ques_Id, sa.Option_Id, sa.Stu_Id, so.OptionText 
               FROM surveyanswers sa
               INNER JOIN surveyoptions so ON sa.Option_Id = so.OptionId
               WHERE sa.Sub_Id = '$subjectId'";

$answersResult = mysqli_query($conn, $sqlAnswers);
$answers = [];

if ($answersResult) {
    while ($row = mysqli_fetch_assoc($answersResult)) {
        $answers[] = $row;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch survey answers']);
    exit;
}

// Step 4: Calculate the feedback
// Assuming some logic to categorize feedback. You can customize this part as needed.
$positiveFeedback = 0;
$negativeFeedback = 0;

// Example categorization: This part can be modified according to the specific logic you want to apply
$positiveOptions = ['Excellent', 'Good', 'Very Good']; // You can customize this list
$negativeOptions = ['Poor', 'Very Poor', 'Bad'];      // Customize this list as well

foreach ($answers as $answer) {
    $optionText = $answer['OptionText'];

    // Categorize the answers based on predefined lists
    if (in_array($optionText, $positiveOptions)) {
        $positiveFeedback++;
    } elseif (in_array($optionText, $negativeOptions)) {
        $negativeFeedback++;
    }
}

// Step 5: Prepare and send the response
$response = [
    'status' => 'success',
    'feedback' => [
        'positive' => $positiveFeedback,
        'negative' => $negativeFeedback
    ],
    'questions' => $questions,
    'answers' => $answers,
    'options' => $options // Include the options for each question
];

echo json_encode($response);
?>
