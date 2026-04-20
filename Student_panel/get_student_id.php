<?php
session_start(); // Ensure session is started to access session variables

function get_student_id() {
    if (isset($_SESSION['user_email'])) {
        // Connect to the database
        $conn = new mysqli("localhost", "root", "", "edusphere2", 3307);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $user_email = $_SESSION['user_email'];

        // Get StuId using email
        $sql = "SELECT StuId FROM student WHERE StuEmail = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user_email); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['StuId'];
        } else {
            echo "Student not found!";
            exit;
        }
    } else {
        echo "User email is not set in the session.";
        exit;
    }
}
?>
