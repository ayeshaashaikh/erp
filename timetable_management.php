<?php
require 'db.php'; // Include your database connection

// Handle adding a new timetable
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_timetable'])) {
        $branchId = $_POST['branch_id'];
        $classId = $_POST['class_id'];
        $startTime = $_POST['start_time'];
        $endTime = $_POST['end_time'];
        $day = $_POST['day'];
        $subject = isset($_POST['subject']) ? $_POST['subject'] : ''; // Handle missing subject

        // Ensure all required fields are set
        if (!empty($branchId) && !empty($classId) && !empty($startTime) && !empty($endTime) && !empty($day) && !empty($subject)) {
            $addQuery = "INSERT INTO timetable (branch_id, class_id, start_time, end_time, day, subject) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($addQuery);
            $stmt->bind_param('iissss', $branchId, $classId, $startTime, $endTime, $day, $subject);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "All fields are required.";
        }
    }

    if (isset($_POST['delete_timetable'])) {
        $timetableId = $_POST['timetable_id'];
        $deleteQuery = "DELETE FROM timetable WHERE id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param('i', $timetableId);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch branches and classes for the dropdowns
$branchQuery = "SELECT * FROM branches";
$branchResult = mysqli_query($conn, $branchQuery);
$branches = mysqli_fetch_all($branchResult, MYSQLI_ASSOC);

$classQuery = "SELECT * FROM classes";
$classResult = mysqli_query($conn, $classQuery);
$classes = mysqli_fetch_all($classResult, MYSQLI_ASSOC);

// Fetch timetables from the database
$timetableQuery = "SELECT t.id, b.branch_name, c.class_name, t.start_time, t.end_time, t.day, t.subject 
                   FROM timetable t
                   JOIN branches b ON t.branch_id = b.id
                   JOIN classes c ON t.class_id = c.id";
$timetableResult = mysqli_query($conn, $timetableQuery);
$timetables = mysqli_fetch_all($timetableResult, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetable Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        .container {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease;
        }
        .btn {
            margin-bottom: 15px;
        }
        .form-control {
            max-width: 500px;
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

        .metric-card:hover {
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
            transform: translateY(-5px);
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
        .container {
    margin-left: 250px;
    padding: 20px;
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease;
}

.container:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.container h2 {
    
    padding-bottom: 10px;
    margin-bottom: 20px;
    color: #333;
    font-weight: 600;
}
.table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    background: #ffffff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.table thead th {
    background: #007bff;
    color: #ffffff;
    text-align: left;
    padding: 12px;
    font-weight: 600;
    border-bottom: 1px solid #0056b3;
}

.table tbody tr {
    border-bottom: 1px solid #e2e6ea;
}

.table tbody tr:nth-child(even) {
    background: #f8f9fa;
}

.table tbody td {
    padding: 12px;
    color: #333;
    transition: background 0.3s ease;
}

.table tbody td:hover {
    background: #f1f1f1;
}

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

    <div class="container">
        <h2>Timetable Management</h2>

        <a href="add_timetable.php" class="btn btn-primary add-user-btn">Add Timetable</a>


        <!-- Timetables Table -->
        <h3 class="mt-4">Current Timetables</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Branch</th>
                    <th>Class</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Day</th>
                    <th>Subject</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($timetables as $timetable): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($timetable['id']); ?></td>
                        <td><?php echo htmlspecialchars($timetable['branch_name']); ?></td>
                        <td><?php echo htmlspecialchars($timetable['class_name']); ?></td>
                        <td><?php echo htmlspecialchars($timetable['start_time']); ?></td>
                        <td><?php echo htmlspecialchars($timetable['end_time']); ?></td>
                        <td><?php echo htmlspecialchars($timetable['day']); ?></td>
                        <td><?php echo htmlspecialchars($timetable['subject']); ?></td>
                        <td>
                            <!-- Delete button -->
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="timetable_id" value="<?php echo htmlspecialchars($timetable['id']); ?>">
                                <button type="submit" name="delete_timetable" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
