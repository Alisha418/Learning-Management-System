<?php
// Start session and include connection file
session_start();
include('connection.php');
 // Assuming you have a file connection.php that connects to the DB

// Fetch all articles from the database
$sql = "SELECT * FROM article";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

?>

<div class="main-content">

   
        <div class="quiz-title">
            <i class="bi bi-lightbulb-fill me-2 fs-4 text-warning"></i>
            <h2 class="dashboard-title">Articles</h2>
        </div>
  

    <div class="articles-container">
        
        <?php
        // Check if there are any articles
        if ($result->num_rows > 0) {
            while ($article = $result->fetch_assoc()) {
                // Fetching article details
                $articleId = $article['ArticleId'];
                $articleTitle = $article['ArticleTitle'];
                $articleContent = substr($article['Content'], 0, 100) . '...'; // Displaying only part of the content
                $articleImage = $article['Image']; // Assuming the image URL is stored in the 'Image' column

                // Displaying each article dynamically
                echo '
                <div class="article-card">
                    <h3 class="article-title">' . htmlspecialchars($articleTitle) . '</h3>
                    <p class="article-snippet">' . htmlspecialchars($articleContent) . '</p>
                    <a href="viewArticle.php?id=' . $articleId . '" class="read-more-btn">Read More</a>
                </div>';
            }
        } else {
            echo '<p>No articles available.</p>';
        }
        ?>

    </div>

</div>

<?php
// Close the database connection
$conn->close();
?>
