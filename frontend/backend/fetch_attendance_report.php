<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

include 'db_connection.php';

// Read the input JSON
$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['section']) || !isset($input['subject'])) {
    echo json_encode(['status' => 'error', 'message' => 'Section and Subject are required']);
    exit();
}

$section = $conn->real_escape_string($input['section']);
$subject = $conn->real_escape_string($input['subject']);

// Fetch total attendance records and present days
$sql = "
    SELECT ar.Date, ar.Status 
    FROM attendance ar
    JOIN studentenroll se ON ar.Enroll_Id = se.EnrollId
    JOIN subjectoffer so ON se.Offer_Id = so.OfferId
    WHERE so.Section_Id = '$section' AND so.Sub_Id = '$subject'
    ORDER BY ar.Date ASC
";

$result = $conn->query($sql);

$totalDays = 0;
$presentDays = 0;

$records = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $totalDays++; // Increment total days

        if ($row['Status'] == 'present') {
            $presentDays++; // Increment present days
        }

        // You can also store the date and attendance status here if needed for the frontend
        $records[] = ['date' => $row['Date'], 'status' => $row['Status']];
    }

    // Calculate the presence percentage
    $presencePercentage = ($totalDays > 0) ? ($presentDays / $totalDays) * 100 : 0;

    // Send response with both attendance data and percentage
    $response = [
        'totalDays' => $totalDays,
        'presentDays' => $presentDays,
        'presencePercentage' => round($presencePercentage, 2), // Round the percentage to 2 decimal places
        'records' => $records
    ];

    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No attendance records found']);
}

$conn->close();
?>
