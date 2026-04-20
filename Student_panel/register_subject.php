<?php
// register_subject.php
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

    // Step 2: Insert into studentenroll
    $insertStmt = $conn->prepare("INSERT IGNORE INTO studentenroll (Offer_Id, Stu_Id) VALUES (?, ?)");
    $insertStmt->bind_param("ii", $offerId, $stuId);

    if ($insertStmt->execute()) {
        echo "registered";
    } else {
        echo "error_inserting";
    }

    $insertStmt->close();
} else {
    echo "student_not_found";
}

$stmt->close();
$conn->close();
?>
