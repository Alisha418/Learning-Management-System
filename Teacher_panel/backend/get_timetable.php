<?php
session_start(); // Start session to access session variables

include("db_connection.php");

// Assuming the teacher's ID is stored in the session after login
if (isset($_SESSION['teacher_id'])) {
    $teacher_id = $_SESSION['teacher_id']; // Get teacher ID from session

    // SQL query to get the timetable for the logged-in teacher
    $sql = "SELECT t.Day, t.TimeSlot, s.SubName AS Subject, t.RoomNo
            FROM timetable t
            JOIN subjectoffer so ON t.Offer_Id = so.OfferId
            JOIN subject s ON so.Sub_Id = s.SubId
            WHERE so.T_Id = ?";
    
    // Prepare the statement to prevent SQL injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $teacher_id); // Bind the teacher's ID as an integer
        $stmt->execute();
        $result = $stmt->get_result();

        $timetable = [];

        // Fetch results and store them in an array
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $timetable[] = $row;
            }
        }

        // Return the timetable as a JSON response
        header('Content-Type: application/json');
        echo json_encode($timetable);
        $stmt->close();
    } else {
        // Error with the SQL query
        echo json_encode(["error" => "Failed to fetch timetable."]);
    }
} else {
    // Teacher not logged in
    echo json_encode(["error" => "Teacher not logged in."]);
}

$conn->close();
?>
