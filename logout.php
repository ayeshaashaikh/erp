<?php
// Start the session
session_start();

// Destroy all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: index.php"); // Change 'index.php' to your login page URL
exit();
?>
