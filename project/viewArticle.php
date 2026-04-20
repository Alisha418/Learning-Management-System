<?php
// Start session and include connection file
session_start();
include 'connection.php'; // Assuming you have a file connection.php that connects to the DB

// Check if ArticleId is passed in the URL
if (!isset($_GET['id'])) {
    echo "Article not found.";
    exit();
}

$articleId = intval($_GET['id']); // Secure type casting

// Fetch article from the database based on ArticleId
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
?>

<!-- HTML structure for the article details -->
 <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
<div class="main-content">
    
        <div class="quiz-title">
            <i class="bi bi-lightbulb-fill me-2 fs-4 text-warning"></i>
            <h2 class="dashboard-title">Article Details</h2>
        </div>
   

    <div class="article-detail-card">
        <h2 class="article-detail-title"><?php echo htmlspecialchars($article['ArticleTitle']); ?></h2>
        <p class="article-detail-content">
            <?php echo nl2br(htmlspecialchars($article['Content'])); ?>
        </p>
    </div>

    <!-- Download Button -->
    <div class="download-btn-container text-center mt-4">
        <a href="path/to/your/article.pdf" download="<?php echo htmlspecialchars($article['ArticleTitle']); ?>.pdf" class="btn btn-primary">
            <i class="fa fa-download me-2"></i> Download Article
        </a>
    </div>
</div>

<?php
// Close the database connection
$conn->close();
?>
