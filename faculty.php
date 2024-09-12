<?php include "db.php";
// Initialize an empty array to store counts
$counts = [];

// Get user count
$result = $conn->query('SELECT COUNT(*) AS userCount FROM users');
$row = $result->fetch_assoc();
$counts['users'] = $row['userCount'];

// Get course count
$result = $conn->query('SELECT COUNT(*) AS courseCount FROM courses');
$row = $result->fetch_assoc();
$counts['courses'] = $row['courseCount'];

// Get enrollment count
$result = $conn->query('SELECT COUNT(*) AS enrollmentCount FROM enrollments');
$row = $result->fetch_assoc();
$counts['enrollments'] = $row['enrollmentCount'];

// Get assignment count
$result = $conn->query('SELECT COUNT(*) AS assignmentCount FROM assignments');
$row = $result->fetch_assoc();
$counts['assignments'] = $row['assignmentCount'];?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS for Sidebar and Dashboard -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease;
           background: #3cb37136;
           padding-bottom:500px;
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
            background-color: #007bff;
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

        .dashboard-metric {
            margin-bottom: 20px;
        }

        .metric-card {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 15px;
            color: #333;
            transition: all 0.3s ease;
        }

        .metric-card h2 {
            margin: 0;
            font-size: 2rem;
        }

        .metric-card h5 {
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        /* Colorful Card Variants */
        .metric-card.users {
            background: linear-gradient(145deg, #d1ecf1, #bee5eb);
            color: #0c5460;
        }

        .metric-card.courses {
            background: #20b2aa7a;
            color: #155724;
        }

        .metric-card.enrollments {
            background: linear-gradient(145deg, #fff3cd, #ffeeba);
            color: #856404;
        }

        .metric-card.assignments {
            background: linear-gradient(145deg, #f8d7da, #f5c6cb);
            color: #721c24;
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


/*new*/

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
    <!-- Content -->
    <div class="content">
       
        <h2 class="welcome-msg">Welcome to the Faculty Dashboard</h2>
        <p>Select a module from the sidebar to manage.</p>

        <div class="row">
            <!-- Dashboard Metrics -->
            <div class="col-md-3">
                <div class="card metric-card users">
                    <div class="card-header">Users</div>
                    <div class="card-body">
                        <h2 id="userCount"><?php echo $counts['users']; ?></h2>
                        <h5>Total Users</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card metric-card courses">
                    <div class="card-header">Courses</div>
                    <div class="card-body">
                        <h2 id="courseCount"><?php echo $counts['courses']; ?></h2>
                        <h5>Total Courses</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card metric-card enrollments">
                    <div class="card-header">Enrollments</div>
                    <div class="card-body">
                        <h2 id="enrollmentCount"><?php echo $counts['enrollments']; ?></h2>
                        <h5>Total Enrollments</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card metric-card assignments">
                    <div class="card-header">Assignments</div>
                    <div class="card-body">
                        <h2 id="assignmentCount"><?php echo $counts['assignments']; ?></h2>
                        <h5>Total Assignments</h5>
                    </div>
                </div>
            </div>
            </div>

    

    <!-- JavaScript for Sidebar Toggle -->
    <script>
        document.getElementById('toggleBtn').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.querySelector('.content').classList.toggle('active');
        });
    </script>

    <!-- Bootstrap and Chart.js Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

    <!-- Initialize Charts -->
    <script>
        var ctx1 = document.getElementById('enrollmentChart').getContext('2d');
        var enrollmentChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                datasets: [{
                    label: 'Enrollments',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctx2 = document.getElementById('courseChart').getContext('2d');
        var courseChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Math', 'Science', 'History', 'Art', 'Music'],
                datasets: [{
                    label: 'Course Popularity',
                    data: [30, 20, 15, 25, 10],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
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
     <script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('counts.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('userCount').textContent = data.users;
                document.getElementById('courseCount').textContent = data.courses;
                document.getElementById('enrollmentCount').textContent = data.enrollments;
                document.getElementById('assignmentCount').textContent = data.assignments;
            })
            .catch(error => console.error('Error fetching counts:', error));
    });
</script>
</body>
</html>
