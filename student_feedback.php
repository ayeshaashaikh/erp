<?php

include 'db.php'; // Ensure db.php connects to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the feedback data
    $feedback = $_POST['feedback'];

   

    // Prepare the SQL query to insert feedback
    $stmt = $conn->prepare("INSERT INTO feedback (feedback_text) VALUES (?)");

    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("s", $feedback);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "<div class='alert alert-success' role='alert'>Feedback submitted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error: " . htmlspecialchars($stmt->error) . "</div>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #925fe259;            font-family: 'Arial', sans-serif;
            margin: 0;
            color: #333;
        }
        .container {
            margin-top: 80px;
            margin-left: 260px; /* Adjust based on your sidebar width */
        }
        .navbar {
            margin-bottom: 20px;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
            transition: width 0.3s;
        }
        .sidebar.active {
            width: 60px;
        }
        .sidebar .nav-link {
            color: #b8c3cc;
            padding: 15px 20px;
            font-size: 16px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }
        .sidebar .nav-link i {
            margin-right: 15px;
        }
        .sidebar.active .nav-link i {
            margin-right: 0;
        }
        .sidebar.active .nav-link span {
            display: none;
        }
        .container {
            padding: 20px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            max-width: 800px; /* Set a max-width for larger screens */
            margin-left: auto;
            margin-right: auto; /* Center the container */
        }
        .form-group label {
            font-weight: bold;
            color: #333;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 15px;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 16px;
            transition: background-color 0.3s, border-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .alert {
            margin-top: 20px;
        }
        @media (max-width: 768px) {
            .container {
                margin-left: 0;
                margin-right: 0;
                padding: 15px;
            }
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
                padding-top: 0;
            }
        }
                  /* Sidebar styles */
.sidebar {
    height: 100vh;
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    background: linear-gradient(to bottom, #6e2d91, #925fe2, #b07ff5);
    padding-top: 20px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.80), 0 6px 20px rgba(0, 0, 0, 0.1);
}

.sidebar .nav-link {
    color: #b8c3cc;
    padding: 15px 20px;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
}

.sidebar .nav-link i {
    margin-right: 10px;
    transition: all 0.3s ease;
}

/* Hover effect for nav links */
.sidebar .nav-link:hover {
    color: #ffffff; /* Change text color on hover */
    background-color: #5a2b77; /* Slightly darker background on hover */
    transform: translateY(-5px); /* Move the link up */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* Add shadow to create 3D effect */
    border-radius: 4px; /* Optional: add rounded corners */
}

.sidebar .nav-link:hover i {
    transform: scale(1.1); /* Slightly increase icon size on hover */
}


        .sidebar.active ~ .content {
            margin-left: 60px;
        }

        /* Sidebar Toggler */
        .toggle-btn {
            position: absolute;
            top: 15px;
            left: 10px;
            background-color: #343a40;
            border: none;
            color: #fff;
            font-size: 20px;
            padding: 5px 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }


        .sidebar.active ~ .toggle-btn {
            left: 70px;
        }
    </style>
</head>
<body>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h4 class="text-center text-white">STUDENT PANEL</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="student.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="lms.php"><i class="fas fa-book-reader"></i> <span>LMS</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="student_assignment.php"><i class="fas fa-tasks"></i> <span>Assignments</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="student_exams.php"><i class="fas fa-pencil-alt"></i> <span>Exams</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="student_timetable.php"><i class="fas fa-calendar"></i> <span>Timetable</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="student_announcements.php"><i class="fas fa-bullhorn"></i> <span>Announcements</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="student_feedback.php"><i class="fas fa-comments"></i> <span>Feedback</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
        </li>
    </ul>
</div>


    <div class="container">
        <h1 class="mb-4">Submit Feedback</h1>
        <form action="student_feedback.php" method="post">
            <div class="form-group">
                <label for="feedback">Your Feedback:</label>
                <textarea id="feedback" name="feedback" class="form-control" rows="5" placeholder="Share your thoughts here..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit Feedback</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
