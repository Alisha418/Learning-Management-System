<?php
// unregister_subject.php
include 'connection.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    echo "no_email";
    exit;
}

$email = $_SESSION['user_email'];
$offerId = $_POST['offerId'];

// Step 1: Get student ID
$stmt = $conn->prepare("SELECT StuId FROM student WHERE StuEmail = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stuId = $row['StuId']; // Correct column name

    // Step 2: Delete from studentenroll
    $deleteStmt = $conn->prepare("DELETE FROM studentenroll WHERE Offer_Id = ? AND Stu_Id = ?");
    $deleteStmt->bind_param("ii", $offerId, $stuId);

    if ($deleteStmt->execute()) {
        echo "unregistered";
    } else {
        echo "error_deleting";
    }

    $deleteStmt->close();
} else {
    echo "student_not_found";
}

$stmt->close();
$conn->close();
?>
