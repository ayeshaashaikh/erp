<?php
require 'db.php'; // Include your database connection

// Fetch courses from the database
$courseQuery = "SELECT * FROM courses";
$courseResult = mysqli_query($conn, $courseQuery);
$courses = mysqli_fetch_all($courseResult, MYSQLI_ASSOC);

// Fetch students from the database
$studentQuery = "SELECT * FROM users WHERE role_id = 3"; // Assuming role_id 3 is for students
$studentResult = mysqli_query($conn, $studentQuery);
$students = mysqli_fetch_all($studentResult, MYSQLI_ASSOC);

// Handle enrollment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enroll'])) {
    $courseId = $_POST['course_id'];
    $studentId = $_POST['student_id'];

    $enrollQuery = "INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)";
    $stmt = $conn->prepare($enrollQuery);
    $stmt->bind_param('ii', $studentId, $courseId);
    $stmt->execute();
    $stmt->close();
}

// Handle unenrollment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['unenroll'])) {
    $enrollmentId = $_POST['enrollment_id'];

    $unenrollQuery = "DELETE FROM enrollments WHERE id = ?";
    $stmt = $conn->prepare($unenrollQuery);
    $stmt->bind_param('i', $enrollmentId);
    $stmt->execute();
    $stmt->close();
}

// Fetch enrollments
$enrollmentQuery = "SELECT enrollments.id, users.username, courses.course_name 
                    FROM enrollments 
                    JOIN users ON enrollments.student_id = users.id 
                    JOIN courses ON enrollments.course_id = courses.id";
$enrollmentResult = mysqli_query($conn, $enrollmentQuery);
$enrollments = mysqli_fetch_all($enrollmentResult, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
     /* Custom CSS */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.content {
    margin-left: 250px;
    padding: 20px;
    transition: all 0.3s ease;
    background: beige;
    padding-bottom: 320px;
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
    margin-top: 50px;
}

.h2 {
    text-align: center;
}

/* New styles */
.btn-primary {
    background-color: beige;
    border: 1px solid #ccc;
    color: #333;
    font-size: 16px;
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #f0e6d6;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    transform: translateY(-2px);
}

.btn-primary:active {
    background-color: #e0d3b8;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    transform: translateY(1px);
}

.form-control {
    max-width: 300px; /* Adjust the width here */
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
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

/* Table styles */
.table {
    background-color: #ffffff; /* White background for table */
    border-radius: 8px; /* Rounded corners */
    overflow: hidden; /* Ensure no overflow of content */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08); /* 3D shadow effect */
}

.table thead th {
    background-color: #f7f7f7; /* Slightly darker background for headers */
    font-weight: bold;
    border-bottom: 2px solid #ddd; /* Slight border for header cells */
}

.table tbody tr {
    transition: background-color 0.3s; /* Smooth transition on hover */
}

.table tbody tr:hover {
    background-color: #f1f1f1; /* Light gray background on hover */
}

.table tbody td {
    border-bottom: 1px solid #ddd; /* Subtle border for table cells */
}

.table tbody td:last-child {
    border-right: none; /* Remove border from the last cell in each row */
}

.table td, .table th {
    padding: 12px 15px; /* Padding for table cells */
    vertical-align: middle; /* Center alignment */
}

/* Button styles */
.btn-primary {
    background-color: #ffffff; /* White background */
    border: 1px solid #ccc; /* Light gray border */
    color: #333; /* Dark text color */
    font-size: 16px;
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* 3D shadow effect */
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #f0f0f0; /* Slightly gray background on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    transform: translateY(-2px);
}

.btn-primary:active {
    background-color: #e0e0e0; /* Slightly darker gray background on active */
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    transform: translateY(1px);
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


    <div class="content">
        <div class="container">
            <h2>Enrollment Management</h2>

            <!-- Enrollment Form -->
            <form method="POST" action="">
                <div class="form-group">
                    <label for="course">Select Course:</label>
                    <select name="course_id" id="course" class="form-control" required>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['course_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="student">Select Student:</label>
                    <select name="student_id" id="student" class="form-control" required>
                        <?php foreach ($students as $student): ?>
                            <option value="<?php echo $student['id']; ?>"><?php echo htmlspecialchars($student['username']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="enroll" class="btn btn-primary">Enroll Student</button>
            </form>

            <!-- Enrollments Table -->
            <h3 class="mt-4">Current Enrollments</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enrollments as $enrollment): ?>
                        <tr>
                            <td><?php echo $enrollment['id']; ?></td>
                            <td><?php echo htmlspecialchars($enrollment['username']); ?></td>
                            <td><?php echo htmlspecialchars($enrollment['course_name']); ?></td>
                            <td>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="enrollment_id" value="<?php echo $enrollment['id']; ?>">
                                    <button type="submit" name="unenroll" class="btn btn-danger">Unenroll</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
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
