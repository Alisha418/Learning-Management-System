<?php
// Include the database connection
include('db_connection.php');

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $article_id = $_GET['id'];

    // Prepare the SQL query to get the article by ID
    $query = "SELECT * FROM article WHERE ArticleId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the article exists
    if ($result->num_rows > 0) {
        // Fetch the article data
        $article = $result->fetch_assoc();
    } else {
        echo "Article not found.";
        exit;
    }
} else {
    echo "Invalid article ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $article['ArticleTitle']; ?></title>
</head>
<body>
    <div class="article-container">
        <h1><?php echo $article['ArticleTitle']; ?></h1>
        <!-- Display image from database path -->
        <img src="<?php echo $article['Image']; ?>" alt="Article Image" style="width: 100%; max-width: 600px;">
        <div class="article-content">
            <p><?php echo nl2br($article['Content']); ?></p>
        </div>
    </div>
    <!-- Back link to articles list -->
    <a href="http://localhost/FRONTEND/Teacher_Dashboard.php#articlesSection">Back to Articles</a>

    
</body>
</html>
