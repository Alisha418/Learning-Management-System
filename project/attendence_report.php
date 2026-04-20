<?php
session_start();
include('connection.php');
 // your database connection file

// Check if the student is logged in
if (!isset($_SESSION['user_email'])) {
    echo "Please login first.";
    exit();
}

// Get student email from session
$student_email = $_SESSION['user_email'];

// Find student ID using email
$stu_query = "SELECT StuId FROM student WHERE StuEmail = '$student_email'";
$stu_result = mysqli_query($conn, $stu_query);

if (mysqli_num_rows($stu_result) > 0) {
    $stu_data = mysqli_fetch_assoc($stu_result);
    $student_id = $stu_data['StuId'];
} else {
    echo "Student not found.";
    exit();
}

// Get the subjects the student is enrolled in
$query = "SELECT subject.SubName, subject.CreditHors, studentenroll.EnrollId
          FROM studentenroll
          INNER JOIN subjectoffer ON studentenroll.Offer_Id = subjectoffer.OfferId
          INNER JOIN subject ON subjectoffer.Sub_Id = subject.SubId
          WHERE studentenroll.Stu_Id = $student_id";

$result = mysqli_query($conn, $query);
?>

<!-- Your HTML Design Starts -->
<div class="main-content">
    <div class="quiz-title">
        <i class="bi bi-file-earmark-text"></i>
        <h2 class="dashboard-title">Attendance Report</h2>
    </div>

    <div class="containers">
        <h2 class="title">Attendance Report</h2>

        <div class="report-container">
            <table id="report-table">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Total Classes</th>
                        <th>Attended</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $subject = $row['SubName'];
                            $credit_hours = $row['CreditHors'];
                            $enroll_id = $row['EnrollId'];

                            // Calculate Total Classes
                            if ($credit_hours == 3) {
                                $total_classes = 32;
                            } else {
                                $total_classes = 16;
                            }

                            // Find attended classes
                            $attendance_query = "SELECT COUNT(*) as attended
                                                 FROM attendance
                                                 WHERE Enroll_Id = $enroll_id AND Status = 'present'";
                            $attendance_result = mysqli_query($conn, $attendance_query);
                            $attendance_data = mysqli_fetch_assoc($attendance_result);
                            $attended_classes = $attendance_data['attended'];

                            // Calculate percentage
                            if ($total_classes > 0) {
                                $percentage = ($attended_classes / $total_classes) * 100;
                            } else {
                                $percentage = 0;
                            }
                    ?>
                    <tr>
                        <td><?php echo $subject; ?></td>
                        <td><?php echo $total_classes; ?></td>
                        <td><?php echo $attended_classes; ?></td>
                        <td><?php echo number_format($percentage, 2); ?>%</td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='4'>No subjects enrolled.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
