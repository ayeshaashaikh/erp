<?php
require 'db.php'; // Include your database connection

// Check if the course ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: course_management.php"); // Redirect if no valid ID is provided
    exit();
}

$courseId = intval($_GET['id']);

// Fetch course details based on the provided ID
$courseQuery = "SELECT * FROM courses WHERE id = ?";
$stmt = $conn->prepare($courseQuery);
$stmt->bind_param("i", $courseId);
$stmt->execute();
$courseResult = $stmt->get_result();
$course = $courseResult->fetch_assoc();

if (!$course) {
    header("Location: course_management.php"); // Redirect if course not found
    exit();
}

// Handle form submission for updating the course
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $branch = $_POST['branch'];
    $image = $_FILES['image']['name'];
    
    // Upload image if a new image is provided
    if ($image) {
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageDestination = 'images/' . $image;
        move_uploaded_file($imageTmpName, $imageDestination);
    } else {
        $image = $course['course_image']; // Keep the old image if no new image is provided
    }

    // Update the course in the database
    $updateQuery = "UPDATE courses SET course_name = ?, description = ?, branch = ?, course_image = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssi", $title, $description, $branch, $image, $courseId);
    $stmt->execute();

    header("Location: course_management.php"); // Redirect to course management page after update
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        /* Include sidebar and content styling here as in the previous code */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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
            transform: translateY(-10px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
        }

        .sidebar .nav-link:active {
            background-color: #007bff;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .sidebar.active ~ .content {
            margin-left: 60px;
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
        }

        .sidebar.active ~ .toggle-btn {
            left: 70px;
        }
        .nav {
   
   display: flex;
   -ms-flex-wrap: wrap;
   flex-wrap: wrap;
   padding-left: 0;
   margin-bottom: 0;
   list-style: none;
   margin-top:50px;
}
    </style>
</head>
<body>
<div class="sidebar" id="sidebar">
        <!-- Sidebar Toggle Button -->
        <button class="toggle-btn" id="toggleBtn"><i class="fas fa-bars"></i></button>
        <h4 class="text-center text-white">Admin Panel</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="user_management.php"><i class="fas fa-user"></i> <span>User Management</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="course_management.php"><i class="fas fa-book"></i> <span>Course Management</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="enrollment_management.php"><i class="fas fa-users"></i> <span>Enrollment Management</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="assignment_exam_management.php"><i class="fas fa-edit"></i> <span>Assignment and Exam Management</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="attendance_management.php"><i class="fas fa-calendar-check"></i> <span>Attendance Management</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="timetable_management.php"><i class="fas fa-calendar-alt"></i> <span>Timetable Management</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="financial_management.php"><i class="fas fa-money-bill-wave"></i> <span>Financial Management</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reports.php"><i class="fas fa-chart-line"></i> <span>Reports</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="library_management.php"><i class="fas fa-book-open"></i> <span>Library Management</span></a>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container">
            <h2>Edit Course</h2>
            
            <!-- Course Edit Form -->
            <form method="POST" action="edit_course.php?id=<?php echo htmlspecialchars($course['id']); ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Course Title:</label>
                    <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($course['course_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required><?php echo htmlspecialchars($course['description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="branch">Branch:</label>
                    <input type="text" name="branch" id="branch" class="form-control" value="<?php echo htmlspecialchars($course['branch']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="image">Course Image:</label>
                    <input type="file" name="image" id="image" class="form-control-file">
                    <small class="form-text text-muted">Leave blank if you don't want to change the image.</small>
                </div>
                <button type="submit" class="btn btn-primary">Update Course</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom JS -->
    <script>
        document.getElementById('toggleBtn').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.querySelector('.content').classList.toggle('active');
            document.querySelector('.toggle-btn').classList.toggle('active');
        });
    </script>
</body>
</html>
