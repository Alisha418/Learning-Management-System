<?php
session_start(); // Start the session at the top

include('connection.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize input
    $StuEmail = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT * FROM student WHERE StuEmail = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $StuEmail, $password); // bind parameters
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a matching student is found
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Store details in session
        $_SESSION['user_email'] = $row['StuEmail'];
        $_SESSION['user_name'] = $row['StuName']; // assuming your table has this column

        // Redirect to dashboard (use Dashboard.php to show dynamic name)
        header("Location: Dashboard.php");
        exit();
    } else {
        // Redirect back with error
        header("Location: studentlogin.php?error=Email or Password is incorrect!");
        exit();
    }
}
?>
