<?php
// download.php
// Start session and include connection
session_start();
include 'connection.php'; // Assuming you have a file connection.php that connects to the DB

// Check if ArticleId is set in the URL
if (!isset($_GET['id'])) {
    echo "Article not found.";
    exit();
}

// Get the article ID from the URL
$articleId = intval($_GET['id']); // Secure type casting

// Fetch the article details from the database
include 'connection.php';  // Assuming you have a file connection.php that connects to the DB
$sql = "SELECT * FROM article WHERE ArticleId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $articleId);
$stmt->execute();
$result = $stmt->get_result();

// Check if the article exists
if ($result->num_rows == 0) {
    echo "Article not found.";
    exit();
}

$article = $result->fetch_assoc();

// Define the file path (assuming PDF files are stored in 'uploads/articles/')
$filePath = 'uploads/articles/' . strtolower(str_replace(' ', '_', $article['ArticleTitle'])) . '.pdf';

// Check if the file exists
if (file_exists($filePath)) {
    // Set headers for download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $article['ArticleTitle'] . '.pdf"');
    readfile($filePath);
    exit();
} else {
    echo "File not found.";
}
?>
