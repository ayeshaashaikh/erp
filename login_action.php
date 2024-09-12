<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password, role_id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $db_username, $hashed_password, $role_id);

    if ($stmt->num_rows == 1) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $db_username; // Store username in session
            $_SESSION['role_id'] = $role_id;

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
            echo "Invalid credentials.";
        }
    } else {
        echo "Invalid credentials.";
    }

    $stmt->close();
    $conn->close();
}
?>
