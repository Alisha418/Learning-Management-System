<?php
session_start();
include('connection.php'); // Assuming you have a DB connection file

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: studentlogin.php");
    exit();
}

$userEmail = $_SESSION['user_email'];  // Get the user email from session

// Query to get student details (department, section, session) based on email
$query = "SELECT st.StuId, s.SectionId, se.SessionId, d.DepName
          FROM student st
          JOIN section s ON st.SectionId = s.SectionId
          JOIN department d ON s.Dep_Id = d.DepId
          JOIN session se ON s.Session_Id = se.SessionId
          WHERE st.StuEmail = '$userEmail'";  // Query uses email to get student details

$result = mysqli_query($conn, $query);
if ($result) {
    $studentDetails = mysqli_fetch_assoc($result);

    $studentId = $studentDetails['StuId'];  // Get the student ID
    $sectionId = $studentDetails['SectionId'];
    $sessionId = $studentDetails['SessionId'];
} else {
    // Handle error if query fails
    echo "Error fetching student details: " . mysqli_error($conn);
    exit();
}

// Query to fetch timetable for the student's section and session
$timetableQuery = "SELECT t.Day, t.TimeSlot, t.RoomNo, so.Sub_Id, sub.SubName
                   FROM timetable t
                   JOIN subjectoffer so ON t.Offer_Id = so.OfferId
                   JOIN subject sub ON so.Sub_Id = sub.SubId
                   JOIN section sec ON so.Section_Id = sec.SectionId
                   WHERE sec.SectionId = $sectionId AND sec.Session_Id = $sessionId  -- Corrected join condition
                   ORDER BY t.Day, t.TimeSlot";

$timetableResult = mysqli_query($conn, $timetableQuery);
?>


<div class="main-content">
    <div class="quiz-title">
        <i class="bi bi-folder2-open"></i>
        <h2 class="dashboard-title">Timetable</h2>
    </div>

    <div class="timetable-container">
        <table class="timetable-table">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Time Slot</th>
                    <th>Subject</th>
                    <th>Room No</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($timetableResult)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Day']); ?></td>
                        <td><?php echo htmlspecialchars($row['TimeSlot']); ?></td>
                        <td><?php echo htmlspecialchars($row['SubName']); ?></td>
                        <td><?php echo htmlspecialchars($row['RoomNo']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
