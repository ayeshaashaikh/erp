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
            background-color: #f8f9fa;
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
                /* Hide dropdown by default */
                .sidebar .nav-link {
    color: #fff;
    text-decoration: none;
}

.sidebar .nav-link:hover {
    background-color: #444;
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

/*new*/


    </style>
</head>
<body>
  <!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h4 class="text-center text-white">Admin Panel</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="admin.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="user_management.php"><i class="fas fa-users"></i> <span>User Management</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="course_management.php"><i class="fas fa-book"></i> <span>Course Management</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="enrollment_management.php"><i class="fas fa-user-plus"></i> <span>Enrollment Management</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" id="examAssignmentToggle"><i class="fas fa-edit"></i> <span>Assignment and Exam Management</span></a>
            <ul class="nav flex-column dropdown-menu" id="examAssignmentDropdown">
                <li class="nav-item">
                    <a class="nav-link" href="exams_management.php"><i class="fas fa-file-alt"></i> <span>Exam Management</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="assignment_management.php"><i class="fas fa-tasks"></i> <span>Assignment Management</span></a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="timetable_management.php"><i class="fas fa-calendar-week"></i> <span>Timetable Management</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="announcement.php"><i class="fas fa-bullhorn"></i> <span>Announcement Management</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="manage_books.php"><i class="fas fa-book-open"></i> <span>Library Management</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="view_feedbacks.php"><i class="fas fa-comments"></i> <span>View Feedback</span></a>
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
                <label for="course">Select Course:</label>
                <select name="course_id" id="course" class="form-control" required>
                    <?php
                    // Fetch courses to populate the dropdown
                    $courseQuery = "SELECT * FROM courses";
                    $courseResult = mysqli_query($conn, $courseQuery);
                    $courses = mysqli_fetch_all($courseResult, MYSQLI_ASSOC);
                    foreach ($courses as $course):
                    ?>
                        <option value="<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['course_name']); ?></option>
                    <?php endforeach; ?>
                </select>
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
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toggleLink = document.getElementById("examAssignmentToggle");
            var dropdownMenu = document.getElementById("examAssignmentDropdown");

            toggleLink.addEventListener("click", function (event) {
                event.preventDefault(); // Prevent default link behavior
                dropdownMenu.classList.toggle("show"); // Toggle dropdown visibility
            });

            // Optional: Close dropdown if clicking outside
            document.addEventListener('click', function(event) {
                if (!toggleLink.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.remove("show");
                }
            });
        });
    </script>
</body>
</html>
