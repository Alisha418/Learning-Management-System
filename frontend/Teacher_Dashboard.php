<?php include ("backend/fetch_dashboard_stats.php"); 

session_start();
require_once 'backend/db_connection.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: Teacher_Login.html");
    exit();
}

$teacherId = $_SESSION['teacher_id'];

// New: Fetch logged-in teacher's name
$teacherName = "Teacher"; // default name
$query = $conn->prepare("SELECT TName FROM teacher WHERE TeacherId = ?");
$query->bind_param("i", $teacherId);
$query->execute();
$result = $query->get_result();
if ($row = $result->fetch_assoc()) {
    $teacherName = $row['TName'];
}

// Fetch semesters
$semesters = $conn->query("SELECT SemId, SemName FROM semester ORDER BY SemName ASC");

// Fetch sections
$sections = $conn->query("SELECT SectionId, SectionName FROM section ORDER BY SectionName ASC");

// Fetch subjects taught by this teacher
$subjects = $conn->prepare("
    SELECT s.SubId, s.SubName 
    FROM subject s 
    JOIN subjectoffer so ON s.SubId = so.Sub_Id 
    WHERE so.T_Id = ?
    GROUP BY s.SubId, s.SubName
");
$subjects->bind_param("i", $teacherId);
$subjects->execute();
$subjectResult = $subjects->get_result();

// Handle student fetch
$students = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fetch_students'])) {
    $semId = $_POST['studentSemesterSelect'];
    $sectionId = $_POST['studentSectionSelect'];
    $subjectId = $_POST['studentSubjectSelect'];

    if ($semId && $sectionId && $subjectId) {
        $stmt = $conn->prepare("
            SELECT s.StuId, s.StuName, s.StuEmail 
            FROM studentenroll se
            JOIN student s ON se.Stu_Id = s.StuId
            JOIN subjectoffer so ON se.Offer_Id = so.OfferId
            WHERE so.Sub_Id = ? AND so.Section_Id = ? AND so.T_Id = ? AND so.Sem_Id = ?
        ");
        $stmt->bind_param("iiii", $subjectId, $sectionId, $teacherId, $semId);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    } else {
        echo "<script>alert('Please select all fields!');</script>";
    }
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>


    <link rel="stylesheet" href="Teacher_Dashboard.css">

</head>

<body>



    <div class="dashboard">
        <!-- Hamburger Menu Button (Visible on Small Screens) -->
        <button class="hamburger" id="menuToggle">
            <i class="bi bi-list"></i> <!-- Bootstrap Icon for Menu -->
        </button>
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <button class="close-btn" id="closeSidebar">&times;</button> <!-- Close Button (×) -->
            <div class="profile-section text-center">
                <i class="bi bi-person-circle profile-icon"></i>
                <h2 class="text-white"><?php echo htmlspecialchars($teacherName); ?></h2>
            </div>
            <ul>
                <li><a href="#" id="profileBtn"><i class="bi bi-person-fill"></i> Profile</a></li>
                <li><a href="#" id="subjectsBtn"><i class="bi bi-book-fill"></i> My Subjects</a></li>
                <li><a href="#" id="studentsBtn"><i class="bi bi-people-fill"></i> View Students</a></li>
                <li><a href="#" id="quizzesBtn"><i class="bi bi-clipboard"></i> Manage Quizzes</a></li>
                <!-- <li><a href="#" id="leaderboardBtn"><i class="bi bi-trophy-fill"></i> Leaderboard</a></li> -->
                <li><a href="#" id="attendanceBtn"><i class="bi bi-calendar-check"></i> Mark Attendance</a></li>
                <li><a href="#" id="timetableBtn"><i class="bi bi-calendar-event"></i> View Timetable</a></li>
                <li><a href="#" id="reportsBtn"><i class="bi bi-bar-chart-line"></i> Attendance Reports</a></li>
                <li><a href="#" id="feedbackBtn"><i class="bi bi-chat-dots-fill"></i> Student Feedback</a></li>
                <li><a href="#" id="articlesBtn"><i class="bi bi-newspaper"></i> View Articles</a></li>
                <li><a href="http://127.0.0.1:5501/Teacher_Login.html" id="logoutBtn"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </aside>
        <!-- Overlay for Mobile Screens -->
        <div class="overlay" id="overlay"></div>

        <!-- Main Content -->
        <main class="content">
            <section id="dashboardOverview">
                <h2 class="dashboard-title" style="font-weight: bold; color: 2f2f4c;">Dashboard Overview</h2>
                <div class="dashboard-container">

                    <!-- Welcome Section -->
                    <div class="welcome-section">
                        <div class="welcome-text">
                            <h2>Welcome Back, <?php echo htmlspecialchars($teacherName); ?>!</h2>
                            <p>Empower your students with knowledge and track their progress effortlessly. Manage
                                subjects, quizzes, attendance, and reports—all in one place.</p>
                            <button class="get-started-btn">Get Started</button>
                        </div>
                        <div class="welcome-img">
                            <img src="teacher-dashboard-pic.png" alt="Welcome Image">
                        </div>
                    </div>
                </div>
               <!-- Stats Boxes Container -->
<div class="stats-container">
    <!-- Box 1 -->
    <div class="stats-box">
        <div class="stats-content">
            <i class="bi bi-book stats-icon"></i>
            <h3>Total Subjects</h3>
        </div>
        <p class="stats-text"><?php echo $subjectCount; ?></p>
    </div>

    <!-- Box 2 -->
    <div class="stats-box">
        <div class="stats-content">
            <i class="bi bi-person stats-icon"></i>
            <h3>Registered Students</h3>
        </div>
        <p class="stats-text"><?php echo $studentCount; ?></p>
    </div>

    <!-- Box 3 -->
    <div class="stats-box">
        <div class="stats-content">
            <i class="bi bi-bar-chart stats-icon"></i>
            <h3>Attendance Reports</h3>
        </div>
        <p class="stats-text"><?php echo $attendanceCount; ?></p>
    </div>

    <!-- Box 4 -->
    <div class="stats-box">
        <div class="stats-content">
            <i class="bi bi-graph-up stats-icon"></i>
            <h3>Total Quiz</h3>
        </div>
        <p class="stats-text"><?php echo $quizCount; ?></p>
    </div>

    <!-- Box 5 -->
    <div class="stats-box">
        <div class="stats-content">
            <i class="bi bi-newspaper stats-icon"></i>
            <h3>Articles</h3>
        </div>
        <p class="stats-text"><?php echo $articleCount; ?></p>
    </div>

    <!-- Box 6 -->
    <div class="stats-box">
        <div class="stats-content">
            <i class="bi bi-newspaper stats-icon"></i>
            <h3>Feedback</h3>
        </div>
        <p class="stats-text"><?php echo $feedbackCount; ?></p>
    </div>
</div>

            </section>

            <section id="profileSection" class="hidden">
                <div class="profile-container">
                    <!-- Profile Header -->
                    <div class="profile-header">
                        <img src="profilepic.png" alt="Teacher Image">
                        <div>
                            <h2 id="teacherName">Teacher Name</h2>
                            <p id="teacherQualification">Qualification</p>
                        </div>
                    </div>
            
                    <!-- Profile Details -->
                    <div class="profile-details">
                        <p><i class="fas fa-phone-alt"></i> <strong>Mobile No:</strong> <span id="teacherPhone"></span></p>
                        <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <span id="teacherEmail"></span></p>
                        <p><i class="fas fa-map-marker-alt"></i> <strong>Address:</strong> <span id="teacherAddress"></span></p>
                        <p><i class="fas fa-user"></i> <strong>Gender:</strong> <span id="teacherGender"></span></p>
                        <p><i class="fas fa-ring"></i> <strong>Married Status:</strong> <span id="teacherMarried"></span></p>
                        <p><i class="fas fa-money-bill"></i> <strong>Salary:</strong> Rs. <span id="teacherSalary"></span></p>
                    </div>
                </div>
            </section>
            

            <section id="subjectsSection" class="hidden">
                <h2>My Subjects</h2>
            
                <div class="card">
                <label for="semesterSelect"><strong>Select Semester:</strong></label>
                <select id="semesterSelect"></select>

            
                    <label for="sectionSelect"><strong>Select Section:</strong></label>
                    <select id="sectionSelect"></select>
            
                    <button id="fetchSubjectsBtn">OK</button>
                </div>
            
                <div class="card">
                    <h3>Subjects List</h3>
                    <table id="subjectsTable">
                        <thead>
                            <tr>
                                <th>Subject Code</th>
                                <th>Subject Name</th>
                                <th>Credits</th>
                            </tr>
                        </thead>
                        <tbody id="subjectsTableBody">
                            <!-- Data will be inserted dynamically -->
                        </tbody>
                    </table>
                </div>
            </section>
            

            <!-- ENROLLED STUDENTS -->

    <section id="studentsSection" class="hidden">
    <h2>Enrolled Students</h2>

    <!-- Filter Form -->
    <div class="card">
        <form method="POST"  onsubmit="return validateForm()">
            <!-- Semester -->
        <label for="studentSemesterSelect"><strong>Select Semester:</strong></label>
        <select name="studentSemesterSelect" id="studentSemesterSelect">
            <option value="">-- Select Semester --</option>
            <?php while ($row = $semesters->fetch_assoc()): ?>
                <option value="<?= $row['SemId'] ?>"><?= $row['SemName'] ?></option>
            <?php endwhile; ?>
        </select>

             <!-- Section -->
        <label for="studentSectionSelect"><strong>Select Section:</strong></label>
        <select name="studentSectionSelect" id="studentSectionSelect">
            <option value="">-- Select Section --</option>
            <?php while ($row = $sections->fetch_assoc()): ?>
                <option value="<?= $row['SectionId'] ?>"><?= $row['SectionName'] ?></option>
            <?php endwhile; ?>
        </select>

            <!-- Subject -->
        <label for="studentSubjectSelect"><strong>Select Subject:</strong></label>
        <select name="studentSubjectSelect" id="studentSubjectSelect">
            <option value="">-- Select Subject --</option>
            <?php while ($row = $subjectResult->fetch_assoc()): ?>
                <option value="<?= $row['SubId'] ?>"><?= $row['SubName'] ?></option>
            <?php endwhile; ?>
        </select>

            <!-- OK Button -->
            <button type="submit" name="fetch_students">OK</button>
        </form>
    </div>

    <!-- Students Table -->
    <?php if (!empty($students)): ?>
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $stu): ?>
                        <tr>
                            <td><?= $stu['StuId'] ?></td>
                            <td><?= $stu['StuName'] ?></td>
                            <td><?= $stu['StuEmail'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>      
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fetch_students'])): ?>
        <p style="color: red; margin-top: 20px;">No students found for the selected filters.</p>
    <?php endif; ?>
</section>

<!-- JavaScript Alert Validation -->
<script>
function validateForm() {
    const sem = document.getElementById('studentSemesterSelect').value;
    const section = document.getElementById('studentSectionSelect').value;
    const subject = document.getElementById('studentSubjectSelect').value;

    if (!sem || !section || !subject) {
        alert("Please select all fields!");
        return false;
    }
    return true;
}
</script>



            


<section id="quizzesSection" class="hidden">
    <h2>Manage Quizzes</h2>
    <div class="card">
        <label for="quizSemesterSelect"><strong>Select Semester:</strong></label>
        <select id="quizSemesterSelect">
            <!-- Options will be added dynamically -->
        </select>

        <label for="quizSectionSelect"><strong>Select Section:</strong></label>
        <select id="quizSectionSelect">
            <!-- Options will be added dynamically -->
        </select>

        <label for="quizSubjectSelect"><strong>Select Subject:</strong></label>
        <select id="quizSubjectSelect">
            <!-- Options will be added dynamically -->
        </select>

        <button onclick="addQuiz()">Add Quiz</button>
    </div>

    <div id="quizForm" class="card hidden">
        <h3>Add Quiz</h3>

        <label>Enter Quiz Title:</label>
        <input type="text" id="quizTitle" required>
        <p class="error-message" id="quizTitleError"></p>

        <label>Total Marks:</label>
        <input type="number" id="quizMarks" min="1">
        <p class="error-message" id="quizMarksError"></p>

        <label>Quiz Time Limit (Minutes):</label>
        <input type="number" id="quizTimer" min="1" placeholder="Enter time in minutes">
        <p class="error-message" id="quizTimerError"></p>
        

        <div id="questionsContainer"></div>
        <p id="questionError" class="error-message" style="color: red;"></p>
        <button id="addQuestionBtn" onclick="addQuestion()">Add Question</button>
        <button id="saveQuizBtn" onclick="saveQuiz()">OK</button>
    </div>

    <div id="quizList" class="card hidden">
        <h3>Added Quizzes</h3>
        <div id="quizzesContainer"></div>
    </div>

    <!-- Hidden field to store OfferId -->
    <input type="hidden" id="quizOfferId">
</section>


            

<section id="attendanceSection" class="hidden">
    <h2>Mark Attendance</h2>

    <div class="card">
        <!-- Select Section -->
        <label for="attendanceSectionSelect">Select Section:</label>
        <select id="attendanceSectionSelect"></select>

        <!-- Select Subject -->
        <label for="attendanceSubjectSelect">Select Subject:</label>
        <select id="attendanceSubjectSelect"></select>

        <!-- Select Date -->
        <label for="attendanceDate">Select Date:</label>
        <input type="date" id="attendanceDate">

        <button onclick="loadStudents()">OK</button>
    </div>

    <!-- Student Attendance List -->
    <div id="studentsList" class="hidden">
        <h3 style="margin-top: 15px;">Enrolled Students</h3>
        <form id="attendanceForm">
            <table border="1">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Attendance</th>
                    </tr>
                </thead>
                <tbody id="attendanceTableBody"></tbody>
            </table>
            <button type="button" onclick="submitAttendance()">Submit Attendance</button>
        </form>
    </div>

    <!-- Attendance Summary -->
    <div id="attendanceSummary" class="hidden">
        <h3>Attendance Summary</h3>
        <table border="1" >
            <thead>
                <tr>
                    <th>Class</th>
                    <th>Date</th>
                    <th>Present</th>
                    <th>Presence Percentage</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="summaryTableBody"></tbody>
        </table>
    </div>
</section>





            <!-- Teacher Timetable Section -->
            <section id="timetableSection" class="hidden">
                <h2 class="section-title">Teacher Timetable</h2>
                <div class="table-container">
                <table>
  <thead>
    <tr>
      <th>Day</th>
      <th>TimeSlot</th>
      <th>Subject</th>
      <th>RoomNo</th>
    </tr>
  </thead>
  <tbody id="timetableBody">
    <!-- Timetable rows will be inserted here -->
  </tbody>
</table>


 </div>
</section>


<section id="reportsSection" class="hidden">
    <h2>Attendance Reports</h2>

    <div class="card">
        <!-- Filters for Report Generation -->
        <label for="reportSection">Select Section:</label>
        <select id="reportSection">
            <option value="">--Select Section--</option>
        </select>

        <label for="reportSubject">Select Subject:</label>
        <select id="reportSubject">
            <option value="">--Select Subject--</option>
        </select>

        <button id="generateReportBtn">Generate Report</button>
        <button id="downloadReportBtn">Download PDF</button>
    </div>

    <!-- Attendance Chart -->
    <div style="width: 90%; height: 400px; margin: auto;">
        <canvas id="attendanceChart"></canvas>
    </div>
</section>



<section id="feedbackSection" class="hidden">
    <h2>Student Feedback</h2>

    <div class="card">
        <!-- Filters -->
        <label for="feedbackSectionSelect">Select Section:</label>
        <select id="feedbackSectionSelect">
            <!-- Dynamically populated Section options -->
        </select>

        <label for="feedbackSubject">Select Subject:</label>
        <select id="feedbackSubject">
            <!-- Dynamically populated Subject options -->
        </select>

        <button onclick="generateFeedback()">Show Feedback</button>
        <button onclick="downloadFeedbackPDF()">Generate Feedback Report</button>
    </div>

    <!-- Feedback Visualization -->
    <div class="chart-container">
        <!-- This canvas will hold the doughnut chart -->
        <canvas id="feedbackChart" width="400" height="400"></canvas>
        <!-- This paragraph will show overall feedback stats -->
        <p id="overallFeedback"></p>
    </div>
</section>



<section id="articlesSection" class="hidden">
    <h2 style="text-align: center; margin-bottom: 20px; color: #2f2f4c;">View Articles</h2>
    <div class="articles-container">
        <?php include 'backend/fetch_articles.php'; ?> <!-- Correct path according to your folder structure -->
    </div>
</section>


        </main>
    </div>

   

    <?php include("backend/fetch_offer_subjects.php"); ?>
    <script src="Teacher_Dashboard.js"></script>
</body>

</html>
