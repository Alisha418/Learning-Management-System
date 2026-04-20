<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: studentlogin.php");
    exit();
}

$studentName = $_SESSION['user_name']; // Get the name from session
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   

   

</head>
<body>
   


    <!-- Sidebar -->
    

    <button class="toggle-btn" onclick="toggleSidebar()">☰ </button>
    <div class="wrapper">
    <div class="sidebar">
       
        <div class="profile-section text-center">
            <i class="bi bi-person-circle profile-icon"></i>
            <h2 class="text-white"><?php echo htmlspecialchars($studentName); ?></h2>
        </div>
        <ul class="menu list-unstyled">
            <li>
                <a href="#" onclick="loadPage(event, 'dash.php')" id="dashboard-link">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="#" onclick="loadPage(event, 'Profile.php')" id="Profile-link">
                    <i class="bi bi-person-fill"></i> Profile
                </a>
            </li>
            <li class="submenu">
                <a href="#" onclick="return false;"><i class="bi bi-book-fill"></i> Subjects <i class="bi bi-chevron-down submenu-toggle" style="font-size: 14px;"></i></a>
                <ul class="submenu-items list-unstyled">
                    <li><a href="#" onclick="loadPage(event ,'offer_sub.php') " id="offer-subjects-link"><i class="bi bi-folder2-open"></i> Offer Subjects</a></li>
                    <li><a href="#" onclick="loadPage(event,'reg_sub.php')" id="register-subjects-link"><i class="bi bi-check-square"></i> Register Subjects</a></li>
                </ul>
            </li>

            <li class="submenu">
                <a  href="#" onclick="return false;" ><i class="bi bi-calendar-check"></i> Attendance <i class="bi bi-chevron-down submenu-toggle " style="font-size: 14px;"></i></a>
                <ul class="submenu-items list-unstyled">
                    
                    <li><a href="#" onclick="loadPage(event,'attendence_report.php')" id="attendance-report-link"><i class="bi bi-file-earmark-text"></i> View Report</a></li>
                </ul>
            </li>

            <li class="submenu">
                <a  href="#" onclick="return false;" ><i class="bi bi-clipboard"></i> Quiz <i class="bi bi-chevron-down submenu-toggle" style="font-size: 14px;"></i></a>
                <ul class="submenu-items list-unstyled">
                    <li><a href="#" onclick="loadPage(event, 'start_quiz.php')" id="start-quiz-link"><i class="bi bi-play-circle"></i> Start Quiz</a></li>
                    <li><a href="#" onclick="loadPage(event, 'resul_quiz.php')" id="quiz-result-link" ><i class="bi bi-bar-chart-line"></i> View Result</a></li>
                </ul>
            </li>
<!-- Add the Timetable Link -->
<li><a href="#" onclick="loadPage(event , 'timetable.php')" id="timetable-link"><i class="bi bi-calendar-event"></i> Timetable</a></li>
    
    <li>
            <li><a href="#" onclick="loadPage(event , 'article.php')" id="articles-link"><i class="bi bi-newspaper"></i> View Articles</a></li>
            <li >
                <a href="#" onclick="loadPage(event ,'feedback.php')" id="logout-link"><i class="bi bi-list-check"></i> Survey</a>
            </li>
            <!-- Log Out -->
            <li>
    <a href="logout.php">
        <i class="bi bi-box-arrow-right"></i> Log Out
    </a>
</li>

        </ul>
    </div>
      
  
     <!-- Content Area (Dynamic Page Load) -->
  
     <div id="content-area">
       
    </div>

  </div>
    <!-- JavaScript for submenu toggle -->
    <button class="toggle-btn" onclick="toggleSidebar()">☰ </button>
    <script  src="scripts.js" defer></script>
</body>

</html>
