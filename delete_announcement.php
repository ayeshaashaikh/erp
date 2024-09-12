<?php
include 'db.php'; // Include your DB connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the announcement
    $stmt = $conn->prepare("DELETE FROM announcements WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Announcement deleted successfully!";
        // Redirect back to announcement list
        header("Location: announcement.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}
?>
