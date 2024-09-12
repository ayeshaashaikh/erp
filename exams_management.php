<?php
include "db.php";
// Handle adding a new exam
if (isset($_POST['add_exam'])) {
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $exam_date = $_POST['exam_date'];
    $duration = $_POST['duration'];

    $addExamQuery = "INSERT INTO exams (course_id, title, exam_date, duration) VALUES ('$course_id', '$title', '$exam_date', '$duration')";
    mysqli_query($conn, $addExamQuery);
    header("Location: exams_management.php");
}

// Handle deleting an exam
if (isset($_POST['delete_exam'])) {
    $exam_id = $_POST['exam_id'];
    $deleteExamQuery = "DELETE FROM exams WHERE id = '$exam_id'";
    mysqli_query($conn, $deleteExamQuery);
    header("Location: exams_management.php");
}

// Fetch all exams
$examsQuery = "SELECT * FROM exams";
$examsResult = mysqli_query($conn, $examsQuery);
$exams = mysqli_fetch_all($examsResult, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exams Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome for Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
      .content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        /* Sidebar styles */
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
            background-color: #495057;
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
        .nav {
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
            margin-top: 50px;
        }
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
    </style>
</head>
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

    <div class="content">
    <div class="container mt-4">
        <h2>Exams Management</h2>

        <!-- Add Exam Form -->
        <form method="POST" action="">
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
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="exam_date">Exam Date:</label>
                <input type="date" name="exam_date" id="exam_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="duration">Exam Duration:</label>
                <input type="time" name="duration" id="duration" class="form-control" required>
            </div>
            <button type="submit" name="add_exam" class="btn btn-primary">Add Exam</button>
        </form>

        <!-- Exams Table -->
        <h3 class="mt-4">Current Exams</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Course</th>
                    <th>Title</th>
                    <th>Duration</th>
                    <th>Exam Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exams as $exam): ?>
                    <tr>
                        <td><?php echo $exam['id']; ?></td>
                        <td>
                            <?php
                            // Fetch course name
                            $courseQuery = "SELECT course_name FROM courses WHERE id = ?";
                            $stmt = $conn->prepare($courseQuery);
                            $stmt->bind_param('i', $exam['course_id']);
                            $stmt->execute();
                            $courseResult = $stmt->get_result();
                            $course = $courseResult->fetch_assoc();
                            echo htmlspecialchars($course['course_name']);
                            $stmt->close();
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($exam['title']); ?></td>
                        <td><?php echo htmlspecialchars($exam['Duration']); ?></td>
                        <td><?php echo htmlspecialchars($exam['exam_date']); ?></td>
                        <td>
                            <!-- Delete button -->
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="exam_id" value="<?php echo $exam['id']; ?>">
                                <button type="submit" name="delete_exam" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
                </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
