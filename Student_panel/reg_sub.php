<?php
session_start(); // Start the session

// Check if user is logged in
if (isset($_SESSION['user_email'])) {
    include('connection.php');// Database connection

    $email = $_SESSION['user_email'];

    // Get student ID using email
    $stmt = $conn->prepare("SELECT StuId FROM student WHERE StuEmail = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $student_id = $row['StuId'];
        $_SESSION['StuId'] = $student_id; // Store in session

        // Date 4 weeks ago
        $four_weeks_ago = date('Y-m-d', strtotime('-4 weeks'));

        // Fetch registered subjects
        $sql = "
            SELECT 
                s.SubId,
                s.SubName, 
                s.CreditHors, 
                t.TName AS Teacher, 
                sem.SemName AS Semester,
                se.EnrollId
            FROM 
                studentenroll se
            JOIN subjectoffer so ON se.Offer_Id = so.OfferId
            JOIN subject s ON so.Sub_Id = s.SubId
            JOIN teacher t ON so.T_Id = t.TeacherId
            JOIN semester sem ON so.Sem_Id = sem.SemId
            WHERE 
                se.Stu_Id = ?
        ";
        $stmt2 = $conn->prepare($sql);
        $stmt2->bind_param("i", $student_id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
?>

<!-- Start HTML Content -->
<div class="main-content">
    <div class="content-area">
        <div class="dashboard-header">
            <div class="quiz-title">
                <i class="bi bi-check-square"></i>
                <h2 class="dashboard-title">Registered Subjects</h2>
            </div>
        </div>
    </div>

    <div class="container-course">
        <h2>Current Courses</h2>
        <div class="divider"></div>
        <div class="course-grid">

<?php
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
                $subId = $row['SubId'];
                $subName = $row['SubName'];
                $creditHours = $row['CreditHors'];
                $teacher = $row['Teacher'];
                $semester = $row['Semester'];
                $enrollId = $row['EnrollId'];

                // Total classes calculation
                $total_classes = ($creditHours == 3) ? 32 : 16;

                // Total attended classes
                $attendance_sql = "SELECT COUNT(*) AS attended FROM attendance WHERE Enroll_Id = ? AND Status = 'present'";
                $stmt3 = $conn->prepare($attendance_sql);
                $stmt3->bind_param("i", $enrollId);
                $stmt3->execute();
                $attendance_result = $stmt3->get_result();
                $attended = ($attendance_result->num_rows > 0) ? $attendance_result->fetch_assoc()['attended'] : 0;

                // Attendance percentage
                $attendance_percentage = ($total_classes > 0) ? round(($attended / $total_classes) * 100) : 0;

                // Running total classes (last 4 weeks)
                $running_total_classes_sql = "SELECT COUNT(*) AS total FROM attendance WHERE Enroll_Id = ? AND Date >= ?";
                $stmt4 = $conn->prepare($running_total_classes_sql);
                $stmt4->bind_param("is", $enrollId, $four_weeks_ago);
                $stmt4->execute();
                $running_total_result = $stmt4->get_result();
                $running_total_classes = ($running_total_result->num_rows > 0) ? $running_total_result->fetch_assoc()['total'] : 0;

                // Running attended classes (last 4 weeks)
                $running_attended_classes_sql = "SELECT COUNT(*) AS attended FROM attendance WHERE Enroll_Id = ? AND Status = 'present' AND Date >= ?";
                $stmt5 = $conn->prepare($running_attended_classes_sql);
                $stmt5->bind_param("is", $enrollId, $four_weeks_ago);
                $stmt5->execute();
                $running_attended_result = $stmt5->get_result();
                $running_attended_classes = ($running_attended_result->num_rows > 0) ? $running_attended_result->fetch_assoc()['attended'] : 0;

                // Running attendance percentage
                $running_attendance_percentage = ($running_total_classes > 0) ? round(($running_attended_classes / $running_total_classes) * 100) : 0;
?>

<!-- Dynamic Course Box -->
<div class="course-card">
    <p><strong>Subject Name:</strong> <?php echo htmlspecialchars($subName); ?></p>
    <p><strong>Total Attendance (%):</strong> <?php echo $attendance_percentage; ?>% (<?php echo $attended; ?>/<?php echo $total_classes; ?>)</p>
    <p><strong>Running Attendance (last 4 weeks):</strong> <?php echo $running_attendance_percentage; ?>%</p>
    <p><strong>Teacher:</strong> <?php echo htmlspecialchars($teacher); ?></p>
    <p><strong>Semester:</strong> <?php echo htmlspecialchars($semester); ?></p>
</div>

<?php
            }
        } else {
            echo "<p>No registered courses found.</p>";
        }
?>

        </div> <!-- course-grid -->
    </div> <!-- container-course -->
</div> <!-- main-content -->

<?php
    } else {
        echo "Student ID not found.";
    }
} else {
    echo "No session found for user email.";
}
?>
