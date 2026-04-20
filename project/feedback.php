<?php
session_start();
include('connection.php');




$student_email = $_SESSION['user_email'];
// Fetch Student ID and Email
$sql = "SELECT StuId, StuEmail FROM student WHERE StuEmail = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_email);
$stmt->execute();
$result = $stmt->get_result();

$student_id = "";
$email = "";

if ($row = $result->fetch_assoc()) {
    $student_id = $row['StuId'];
    $email = $row['StuEmail'];
}

// Fetch Department, Session and Section
$sql = "SELECT department.DepName, session.SessionName, section.SectionName 
        FROM student
        INNER JOIN section ON student.SectionId = section.SectionId
        INNER JOIN department ON section.Dep_Id = department.DepId
        INNER JOIN session ON section.Session_Id = session.SessionId
        WHERE student.StuEmail = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_email);
$stmt->execute();
$result = $stmt->get_result();

$sessions = [];
$sections = [];
$department = "";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $department = $row['DepName'];
        $sessions[] = $row['SessionName'];
        $sections[] = $row['SectionName'];
    }
}
?>

<div class="main-content">
    
        <div class="quiz-title">
            <i class="bi bi-list-check"></i>
            <h2 class="dashboard-title">Feedback</h2>
        </div>
    
    <div class="card-register1" id="feedback">
        <h2>Survey - <?php echo htmlspecialchars($department); ?></h2>

        <label for="session">Select Session:</label>
        <select id="session">
            <?php foreach(array_unique($sessions) as $session): ?>
                <option value="<?php echo htmlspecialchars($session); ?>"><?php echo htmlspecialchars($session); ?></option>
            <?php endforeach; ?>
        </select>

        <label for="section">Select Section:</label>
        <select id="section">
            <?php foreach(array_unique($sections) as $section): ?>
                <option value="<?php echo htmlspecialchars($section); ?>"><?php echo htmlspecialchars($section); ?></option>
            <?php endforeach; ?>
        </select>

        <button class="load-btn" onclick="surveySubjects()">Survey For Subjects</button>
    </div>


    

        <div class="subject-container" id="subjectContainer" style="display: none;">
           
            
           
        </div>
        
    
        <div class="survey-container" id="surveyContainer" style="display: none;">
        <h2>Student Survey</h2>

        <form class="survey-form" id="surveyForm">
             <!-- Student ID (Pre-filled) -->
             <label for="student-id">Student ID:</label>
            <input type="text" id="student-id" value="<?php echo htmlspecialchars($student_id); ?>" required readonly>
            <span class="error" id="idError"></span>

            <!-- Email (Pre-filled) -->
            <label for="email">Email:</label>
            <input type="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required readonly>
            <span class="error" id="emailError"></span>
            <p class="fill">Fill Form</p>

            <!-- Dynamic Survey Questions will be inserted here -->
            <div id="surveyQuestions"></div>

            <label for="additional-feedback">Additional Feedback:</label>
            <textarea id="additional-feedback"  name="additional-feedback" rows="4" placeholder="Write your feedback here..."></textarea>

            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>
        
</div>