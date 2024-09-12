<?php
// add_announcement.php

// Include your database connection
include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO announcements (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);

    if ($stmt->execute()) {
        // Redirect to announcement page after success
        header("Location: announcement.php");
        exit();
    } else {
        $error = "Error adding announcement: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Announcement</title>
    <style>
        /* Base Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f4f4f4;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            margin-top: 20px;
        }

        .error {
            color: red;
        }

        .back-btn {
            text-align: center;
            margin-top: 20px;
        }

        .back-btn a {
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }

        .back-btn a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Add New Announcement</h1>

        <!-- Display error message if any -->
        <?php if (isset($error)) { ?>
            <p class="message error"><?php echo $error; ?></p>
        <?php } ?>

        <!-- Announcement Form -->
        <form action="add_announcement.php" method="POST">
            <label for="title">Announcement Title:</label>
            <input type="text" id="title" name="title" placeholder="Enter the announcement title" required>

            <label for="content">Announcement Content:</label>
            <textarea id="content" name="content" rows="6" placeholder="Write the announcement content here..." required></textarea>

            <button type="submit">Add Announcement</button>
        </form>

        <div class="back-btn">
            <a href="announcement.php">← Back to Announcements</a>
        </div>
    </div>

</body>
</html>
