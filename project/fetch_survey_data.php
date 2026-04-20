<?php
session_start();
include('connection.php');

$subject_id = $_POST['subject_id'];

// Fetch survey questions for the selected subject
$sql = "SELECT * FROM surveyquestions WHERE Sub_Id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $subject_id);
$stmt->execute();
$result = $stmt->get_result();

$html = '';

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $question_id = $row['QuesId'];
        $html .= '<div class="questions-card">
                    <div class="questions">
                        <p>' . htmlspecialchars($row['QuesText']) . '</p>
                        <div class="options">';
        
        // Fetch options for each question
        $sql_options = "SELECT * FROM surveyoptions WHERE Ques_Id = ?";
        $stmt_options = $conn->prepare($sql_options);
        $stmt_options->bind_param("i", $question_id);
        $stmt_options->execute();
        $options_result = $stmt_options->get_result();
        
        while ($option = $options_result->fetch_assoc()) {
            $html .= '<label><input type="radio" name="q' . $question_id . '" value="' . htmlspecialchars($option['OptionText']) . '"> ' . htmlspecialchars($option['OptionText']) . '</label><br>';
        }

        $html .= '</div><span class="error" id="q' . $question_id . 'Error"></span></div></div>';
    }
} else {
    $html = 'No survey questions found for this subject.';
}

echo $html;
?>
