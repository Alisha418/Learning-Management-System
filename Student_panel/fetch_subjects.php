<?php
$conn = new mysqli("localhost", "root", "", "edusphere2", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sessionName = $_POST['session'];
$sectionName = $_POST['section'];

// Find SectionId
$sql = "SELECT section.SectionId 
        FROM section 
        INNER JOIN session ON section.Session_Id = session.SessionId
        WHERE section.SectionName = ? AND session.SessionName = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $sectionName, $sessionName);
$stmt->execute();
$result = $stmt->get_result();
$sectionId = 0;

if ($row = $result->fetch_assoc()) {
    $sectionId = $row['SectionId'];
}

// Now fetch subjects
if ($sectionId > 0) {
    echo '<h2>Subjects</h2>';

    $sql = "SELECT subject.SubId, subject.SubName 
            FROM subjectoffer
            INNER JOIN subject ON subjectoffer.Sub_Id = subject.SubId
            WHERE subjectoffer.Section_Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $sectionId);
    $stmt->execute();
    $result = $stmt->get_result();


    while ($row = $result->fetch_assoc()) {
        // Ensure that the subjectId is correctly passed
        $subjectId = htmlspecialchars($row['SubId']);
        $subjectName = htmlspecialchars($row['SubName']);
        echo '<div class="subject-card">';
        echo '<p><strong>Subject ID:</strong> ' . $subjectId . '</p>';
        echo '<p><strong>Name:</strong> ' . $subjectName . '</p>';
        
        echo '<input type="hidden" class="subjectIdField" value="' . $subjectId . '" />';

        echo '<button class="survey-btn" onclick="fillSurvey(' . $subjectId . ')">Survey Fill</button>';
        echo '</div>';
    }
} else {
    echo '<p>No subjects found for the selected section and session.</p>';
}
?>
