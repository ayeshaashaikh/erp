<?php
require 'db.php'; // Include your database connection

// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    $courseId = mysqli_real_escape_string($conn, $_GET['id']);

    // Prepare the delete query
    $deleteQuery = "DELETE FROM courses WHERE id = $courseId";
    if (mysqli_query($conn, $deleteQuery)) {
        // Redirect to course management page after successful deletion
        header("Location: course_management.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
