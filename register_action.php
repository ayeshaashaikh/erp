<?php
include 'db.php'; // Ensure db.php connects to the database
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing the password securely
    $email = $_POST['email'];
    $role_id = (int) $_POST['role']; // Casting role to an integer for safety

    // Prepare the SQL query with placeholders to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, role_id) VALUES (?, ?, ?, ?)");

    // Bind the actual values to the placeholders
    $stmt->bind_param("sssi", $username, $password, $email, $role_id);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Determine the redirection URL based on role_id
        if ($role_id == 1) {
            header("Location: admin.php");
        } elseif ($role_id == 2) {
            header("Location: faculty.php");
        } elseif ($role_id == 3) {
            header("Location: student.php");
        } else {
            echo "Invalid role selected.";
        }
        exit(); // Ensure no further code is executed after redirection
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
