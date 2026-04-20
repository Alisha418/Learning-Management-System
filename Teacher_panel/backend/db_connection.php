
<?php
$host = "localhost";
$username = "root";
$password = ""; // leave empty for XAMPP
$database = "edusphere2";
$port=3307;

$conn = new mysqli($host, $username, $password, $database,$port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
