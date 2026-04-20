<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: studentlogin.php");
    exit();
}

include('connection.php');

$email = $_SESSION['user_email'];

// Fetch logged-in student
$sql = "SELECT 
    student.*, 
    section.SectionName, 
    department.DepName 
FROM student
JOIN section ON student.SectionId = section.SectionId
JOIN department ON section.Dep_Id = department.DepId
WHERE student.StuEmail = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>

<div class="main-content">
  
    <section id="profileSection">
        <div class="profile-container">
            <!-- Profile Header -->
            <div class="profile-header">
                <img src="profilepic.png" alt="Student Image">
                <div>
                    <h2><?php echo htmlspecialchars($student['StuName']); ?></h2>
                    <p>Student</p>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="profile-details">
                <p><i class="fas fa-venus-mars"></i> <strong>Gender:</strong> <?php echo htmlspecialchars($student['StuGender']); ?></p>
                <p><i class="fas fa-phone-alt"></i> <strong>Mobile No:</strong> <?php echo htmlspecialchars($student['StuPhone']); ?></p>
                <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <?php echo htmlspecialchars($student['StuEmail']); ?></p>
                <p><i class="fas fa-map-marker-alt"></i> <strong>Address:</strong> <?php echo htmlspecialchars($student['StuAddress']); ?></p>
                <p><i class="fas fa-layer-group"></i> <strong>Section:</strong> <?php echo htmlspecialchars($student['SectionName']); ?></p>
                <p><i class="fas fa-building"></i> <strong>Department:</strong> <?php echo htmlspecialchars($student['DepName']); ?></p>
            </div>
        </div>
    </section>
</div>
