<?php
session_start();  // Start the session

// Destroy all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect the user to the front page
header("Location: frontpage.html");
exit();
?>
