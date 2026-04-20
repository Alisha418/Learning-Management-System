<?php
session_start();
include('connection.php');
 // Database connection

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    echo "Unauthorized Access";
    exit();
}

// Get user email from session
$user_email = $_SESSION['user_email'];

// Fetch student details
$student_query = "SELECT StuId, SectionId FROM student WHERE StuEmail = ?";
$stmt = $conn->prepare($student_query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$student_result = $stmt->get_result();
$student_data = $student_result->fetch_assoc();

$student_id = $student_data['StuId'];
$section_id = $student_data['SectionId'];

// 1. Offer Subjects
$offer_query = "SELECT COUNT(*) AS offer_subjects FROM subjectoffer WHERE Section_Id = ?";
$stmt = $conn->prepare($offer_query);
$stmt->bind_param("i", $section_id);
$stmt->execute();
$offer_result = $stmt->get_result();
$offer_subjects = $offer_result->fetch_assoc()['offer_subjects'];

// 2. Registered Subjects
$register_query = "SELECT COUNT(*) AS registered_subjects FROM studentenroll WHERE Stu_Id = ?";
$stmt = $conn->prepare($register_query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$register_result = $stmt->get_result();
$registered_subjects = $register_result->fetch_assoc()['registered_subjects'];

// 3. Attendance Reports
$attendance_subjects = $registered_subjects; // same as registered subjects

// 4. Attempted Quizzes
$quiz_query = "SELECT COUNT(*) AS attempted_quizzes FROM quizattempt WHERE Stu_Id = ?";
$stmt = $conn->prepare($quiz_query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$quiz_result = $stmt->get_result();
$attempted_quizzes = $quiz_result->fetch_assoc()['attempted_quizzes'];

// 5. View Articles
$article_query = "SELECT COUNT(*) AS total_articles FROM article";
$article_result = mysqli_query($conn, $article_query);
$total_articles = mysqli_fetch_assoc($article_result)['total_articles'];

$enroll_query = "SELECT EnrollId FROM studentenroll WHERE Stu_Id = ? LIMIT 1";
$stmt = $conn->prepare($enroll_query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$enroll_data = $result->fetch_assoc();
$enroll_id = $enroll_data['EnrollId'];

// Step 2: Attendance Data (month wise)
$attendance_data = [];
$months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
foreach ($months as $index => $month) {
    $month_number = $index + 1;
    $attendance_query = "SELECT 
                            (SUM(CASE WHEN Status = 'present' THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS attendance_percentage
                         FROM attendance 
                         WHERE Enroll_Id = ? 
                         AND MONTH(Date) = ?";
    $stmt = $conn->prepare($attendance_query);
    $stmt->bind_param("ii", $enroll_id, $month_number);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $attendance_percentage = $row['attendance_percentage'] ?? 0;
    $attendance_data[] = round($attendance_percentage, 2);
}

// Quiz Performance Report
// Quiz Performance Report
$quiz_data = [];
$quiz_subjects = [];
$quiz_query = "SELECT s.SubName AS SubjectName, 
                     AVG(qa.Score / q.TotalMarks) * 100 AS percentage 
              FROM quizattempt qa
              JOIN quiz q ON qa.Quiz_Id = q.QuizId
              JOIN subjectoffer so ON q.Offer_Id = so.OfferId
              JOIN subject s ON so.Sub_Id = s.SubId
              WHERE qa.Stu_Id = ?
              GROUP BY s.SubName";
$stmt = $conn->prepare($quiz_query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $quiz_subjects[] = $row['SubjectName'];
    $quiz_data[] = round($row['percentage'], 2);
}


// Encode to JSON
$attendance_data_json = json_encode($attendance_data);
$quiz_subjects_json = json_encode($quiz_subjects);
$quiz_data_json = json_encode($quiz_data);
?>

<!-- Main Content Wrapper -->
<div class="main-content">
    <!-- Stats Boxes Container -->
    <div id="content-area">
        <h2 class="dashboard-title">Dashboard Overview</h2>
        <div class="stats-container">

            <!-- Box 1 -->
            <div class="stats-box">
                <div class="stats-content">
                    <i class="bi bi-book stats-icon"></i>
                    <h3>Offer Subjects</h3>
                </div>
                <p class="stats-text"><?php echo $offer_subjects; ?></p>
            </div>

            <!-- Box 2 -->
            <div class="stats-box">
                <div class="stats-content">
                    <i class="bi bi-person stats-icon"></i>
                    <h3>Register Subjects</h3>
                </div>
                <p class="stats-text"><?php echo $registered_subjects; ?></p>
            </div>

            <!-- Box 3 -->
            <div class="stats-box">
                <div class="stats-content">
                    <i class="bi bi-bar-chart stats-icon"></i>
                    <h3>Attendance Reports</h3>
                </div>
                <p class="stats-text"><?php echo $attendance_subjects; ?></p>
            </div>

            <!-- Box 4 -->
            <div class="stats-box">
                <div class="stats-content">
                    <i class="bi bi-graph-up stats-icon"></i>
                    <h3>Attempted Quiz</h3>
                </div>
                <p class="stats-text"><?php echo $attempted_quizzes; ?></p>
            </div>

            <!-- Box 5 -->
            <div class="stats-box">
                <div class="stats-content">
                    <i class="bi bi-newspaper stats-icon"></i>
                    <h3>View Articles</h3>
                </div>
                <p class="stats-text"><?php echo $total_articles; ?></p>
            </div>

        </div>
    </div>



    <div class="graph-container">

<!-- Attendance Report Graph -->
<div class="container">
    <h3 class="text-center" title="Attendance Report">Attendance Report</h3>
    <canvas id="attendanceChart" 
        data-attendance='<?php echo $attendance_data_json; ?>'></canvas>
</div>

<!-- Quiz Performance Chart -->
<div class="container">
    <h3>Quiz Performance Report</h3>
    <canvas id="quizChart" 
        data-subjects='<?php echo $quiz_subjects_json; ?>' 
        data-scores='<?php echo $quiz_data_json; ?>'></canvas>
</div>

</div>
    </div>
</div>
  

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="scripts.js"></script>
<!-- Compare this snippet from project/dash.html: -->
<!-- <div class="main-content">
 -->


    