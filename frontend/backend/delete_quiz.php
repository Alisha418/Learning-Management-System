<?php
// Define the necessary variables
include 'db_connection.php';

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['offerId'])) {
    $offerId = $_GET['offerId'];

    // Prepare the DELETE query to remove the quiz
    $query = "DELETE FROM quiz WHERE Offer_Id = ?"; // Using the correct column name "Offer_Id"

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $offerId);  // "i" indicates an integer parameter
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete quiz']);
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database query preparation failed']);
    }

    // Close the connection to MySQL
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'OfferId parameter missing']);
}
?>