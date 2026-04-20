<?php
include 'db_connection.php';

$query = "SELECT * FROM article ORDER BY ArticleId DESC"; 
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '
        <div class="article-card">
            <img src="' . htmlspecialchars($row['Image']) . '" alt="Article Image">
            <div class="article-content">
                <h3>' . htmlspecialchars($row['ArticleTitle']) . '</h3>
                <p>' . htmlspecialchars(substr($row['Content'], 0, 100)) . '...</p>
                <a href="backend/read_article.php?id=' . $row['ArticleId'] . '" class="read-more">Read More →</a>
            </div>
        </div>
        ';
    }
} else {
    echo "<p style='text-align:center;'>No articles found.</p>";
}
?>
