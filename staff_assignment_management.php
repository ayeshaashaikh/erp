<?php
require 'db.php'; // Include your database connection

// Handle adding a new assignment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_assignment'])) {
    $courseId = $_POST['course_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $dueDate = $_POST['due_date'];

    // Handle file upload
    $questionPdf = '';
    if (isset($_FILES['question_pdf']) && $_FILES['question_pdf']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['question_pdf']['tmp_name'];
        $fileName = $_FILES['question_pdf']['name'];
        $fileSize = $_FILES['question_pdf']['size'];
        $fileType = $_FILES['question_pdf']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validate file extension
        $allowedExtensions = ['pdf'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadFileDir = './uploads/';
            $destFilePath = $uploadFileDir . $fileName;
            
            if (move_uploaded_file($fileTmpPath, $destFilePath)) {
                $questionPdf = $fileName; // Save the filename in the database
            }
        }
    }

    $addQuery = "INSERT INTO assignments (course_id, title, description, due_date, question_pdf) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($addQuery);
    $stmt->bind_param('issss', $courseId, $title, $description, $dueDate, $questionPdf);
    $stmt->execute();
    $stmt->close();
}

// Handle editing an assignment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_assignment'])) {
    $assignmentId = $_POST['assignment_id'];
    $courseId = $_POST['course_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $dueDate = $_POST['due_date'];

    // Handle file upload
    $questionPdf = $_POST['existing_question_pdf'];
    if (isset($_FILES['question_pdf']) && $_FILES['question_pdf']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['question_pdf']['tmp_name'];
        $fileName = $_FILES['question_pdf']['name'];
        $fileSize = $_FILES['question_pdf']['size'];
        $fileType = $_FILES['question_pdf']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validate file extension
        $allowedExtensions = ['pdf'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadFileDir = './uploads/';
            $destFilePath = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $destFilePath)) {
                $questionPdf = $fileName; // Save the new filename in the database
            }
        }
    }

    $editQuery = "UPDATE assignments SET course_id = ?, title = ?, description = ?, due_date = ?, question_pdf = ? WHERE id = ?";
    $stmt = $conn->prepare($editQuery);
    $stmt->bind_param('issssi', $courseId, $title, $description, $dueDate, $questionPdf, $assignmentId);
    $stmt->execute();
    $stmt->close();
}

// Handle deleting an assignment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_assignment'])) {
    $assignmentId = $_POST['assignment_id'];

    $deleteQuery = "DELETE FROM assignments WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param('i', $assignmentId);
    $stmt->execute();
    $stmt->close();
}

// Fetch assignments from the database
$assignmentQuery = "SELECT * FROM assignments";
$assignmentResult = mysqli_query($conn, $assignmentQuery);
$assignments = mysqli_fetch_all($assignmentResult, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
            transition: all 0.3s ease;
            box-shadow: 3px 0 6px rgba(0, 0, 0, 0.1);
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
            justify-content: flex-start;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            border-radius: 5px;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        .sidebar.active .nav-link i {
            margin-right: 0;
        }
        .sidebar.active .nav-link span {
            display: none;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .sidebar .nav-link:active {
            background-color: #007bff;
        }
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
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        .sidebar.active ~ .toggle-btn {
            left: 70px;
        }
        .container {
            margin-top: 20px;
        }
        .form-control {
            max-width: 500px; /* Adjust the width as needed */
        }
        .btn {
            margin-bottom: 15px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #00a36c;
            border-bottom: 1px solid #ddd;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
        }
        .card-body {
            padding: 15px;
        }
        .table thead th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease;
           background: #3cb37136
        }

        /* Sidebar styles */
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #00A36C;
            padding-top: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.80), 0 6px 20px rgba(0, 0, 0, 0.1);

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
            justify-content: flex-start;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative; /* For positioning the shadow effect */
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .sidebar.active .nav-link i {
            margin-right: 0;
        }

        .sidebar.active .nav-link span {
            display: none;
        }

        .sidebar .nav-link:hover {
            background-color: #00A36C;
            color: white;
            transform: translateY(-10px); /* Bounce effect */
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3); /* Shadow effect */
        }

        .sidebar .nav-link:active {
            background-color: #007bff;
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

        /* Dashboard Styling */
        .card {
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background: #fff;
            transition: all 0.3s ease;
        }

        .card-header {
            background-color: #00a36c;
            color: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            font-size: 1.25rem;
        }

        .card-footer {
            background-color: #f1f1f1;
            border-top: 1px solid rgba(0,0,0,0.1);
        }

        .chart-container {
            position: relative;
            height: 300px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 0.25rem;
        }

        .welcome-msg {
            margin-bottom: 20px;
            text-align:center;
            font-size: 1.5rem;
        }

      
        /* Centering text */
        p {
            text-align: center;
            margin-top: 0;
            margin-bottom: 1rem;
        }

        .nav {
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
            margin-top: 50px;
        }

        /* Hover effects */
        .card:hover {
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
            transform: translateY(-5px);
        }

               /* Hide dropdown by default */
        .sidebar .nav-link {
    color: #fff;
    text-decoration: none;
}

.sidebar .nav-link:hover {
    background-color:#2E8B57	;
}

.nav.flex-column {
    list-style-type: none;
    padding: 0;
}

.nav-item {
    position: relative;
}

/* Style for dropdown menu */
.dropdown-menu {
    display: none;
    background-color: #444;
    padding: 0;
    position: absolute;
    left: 0; /* Align with the left edge of the parent */
    top: 100%; /* Position below the parent */
    width: 100%; /* Ensure dropdown width matches the parent item */
    z-index: 1000; /* Ensure dropdown is above other content */
}

/* Dropdown item styles */
.dropdown-menu .nav-item {
    padding: 0;
}

.dropdown-menu .nav-link {
    padding: 10px;
    display: block;
    color: #fff;
}

.dropdown-menu .nav-link:hover {
    background-color: #555;
}

/* Show dropdown when the show class is added */
.show {
    display: block;
}

    </style>
</head>
<body>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h4 class="text-center text-white">Faculty Panel</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="faculty.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Student_management.php"><i class="fas fa-user-graduate"></i> <span>Student Management</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="staff_course_management.php"><i class="fas fa-book"></i> <span>Course Management</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="staff_enrollment_management.php"><i class="fas fa-users"></i> <span>Enrollment Management</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" id="examAssignmentToggle"><i class="fas fa-edit"></i> <span>Assignment and Exam Management</span></a>
            <ul class="nav flex-column dropdown-menu" id="examAssignmentDropdown">
                <li class="nav-item">
                    <a class="nav-link" href="staff_exams_management.php"><i class="fas fa-file-alt"></i> <span>Exam Management</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="staff_assignment_management.php"><i class="fas fa-tasks"></i> <span>Assignment Management</span></a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="staff_timetable_management.php"><i class="fas fa-calendar-alt"></i> <span>Timetable Management</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="staff_announcement_management.php"><i class="fas fa-bullhorn"></i> <span>Announcement Management</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="staff_feedback.php"><i class="fas fa-comments"></i> <span>Feedback</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="staff_view_library.php"><i class="fas fa-book-open"></i> <span>Library</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
        </li>
    </ul>
</div>



    <!-- Content -->
    <div class="content" id="content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    Assignment Management
                </div>
                <div class="card-body">
                    <!-- Add Assignment Form -->
                    <h5>Add Assignment</h5>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="course_id">Course ID</label>
                            <input type="number" class="form-control" id="course_id" name="course_id" required>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="due_date">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" required>
                        </div>
                        <div class="form-group">
                            <label for="question_pdf">Upload Question PDF (optional)</label>
                            <input type="file" class="form-control-file" id="question_pdf" name="question_pdf" accept=".pdf">
                        </div>
                        <button type="submit" name="add_assignment" class="btn btn-primary">Add Assignment</button>
                    </form>

                   
                
            <!-- Display Assignments Table -->
            <div class="card">
                <div class="card-header">
                    Assignments List
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Course ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Due Date</th>
                                <th>Question PDF</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($assignments as $assignment): ?>
                                <tr>
                                    <td><?php echo $assignment['id']; ?></td>
                                    <td><?php echo $assignment['course_id']; ?></td>
                                    <td><?php echo $assignment['title']; ?></td>
                                    <td><?php echo $assignment['description']; ?></td>
                                    <td><?php echo $assignment['due_date']; ?></td>
                                    <td><?php echo $assignment['question_pdf'] ? '<a href="./uploads/' . $assignment['question_pdf'] . '" target="_blank">View PDF</a>' : 'N/A'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('toggleBtn').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        });
    </script>
</body>
</html>
