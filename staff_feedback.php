<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php'; // Ensure db.php connects to the database

// Define the number of feedbacks per page
$feedbackPerPage = 5;

// Get the current page number from the query string, defaulting to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = ($page > 0) ? $page : 1;

// Calculate the starting point for the query
$start = ($page - 1) * $feedbackPerPage;

// Fetch the total number of feedback entries
$totalQuery = "SELECT COUNT(*) as total FROM feedback";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalFeedbacks = $totalRow['total'];

// Fetch feedback data for the current page
$query = "SELECT feedback_text, created_at FROM feedback ORDER BY created_at DESC LIMIT $start, $feedbackPerPage";
$result = $conn->query($query);

// Calculate the total number of pages
$totalPages = ceil($totalFeedbacks / $feedbackPerPage);

// Simple sentiment analysis function (basic implementation)
function getSentimentClass($text) {
    $positiveWords = ['good', 'great', 'excellent', 'positive', 'love', 'happy'];
    $negativeWords = ['bad', 'poor', 'terrible', 'negative', 'hate', 'sad'];
    
    $positiveCount = 0;
    $negativeCount = 0;
    
    foreach ($positiveWords as $word) {
        if (stripos($text, $word) !== false) {
            $positiveCount++;
        }
    }
    
    foreach ($negativeWords as $word) {
        if (stripos($text, $word) !== false) {
            $negativeCount++;
        }
    }
    
    if ($positiveCount > $negativeCount) {
        return 'positive-feedback';
    } elseif ($negativeCount > $positiveCount) {
        return 'negative-feedback';
    } else {
        return 'neutral-feedback'; // Optional: for neutral feedback
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            font-family: 'Arial', sans-serif;
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
            max-width: 900px; /* Set a max-width for larger screens */
            margin-left: auto;
            margin-right: auto; /* Center the container */
        }
        .card {
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
        }
        .card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        .card-body {
            padding: 20px;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: 500;
            color: #333;
        }
        .card-text {
            font-size: 1rem;
            color: #666;
        }
        .card-footer {
            background: #f8f9fa;
            border-top: 1px solid #ddd;
            text-align: right;
            font-size: 0.875rem;
            color: #999;
        }
      
        .pagination {
            justify-content: center;
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
.positive-feedback {
            background-color: #d4edda; /* Light green background */
            border-left: 5px solid #28a745; /* Green border */
        }
        .negative-feedback {
            background-color: #f8d7da; /* Light red background */
            border-left: 5px solid #dc3545; /* Red border */
        }
        .neutral-feedback {
            background-color: #e2e3e5; /* Light gray background */
            border-left: 5px solid #6c757d; /* Gray border */
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


    <div class="container">
        <h1 class="mb-4">View Feedback</h1>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $feedbackText = htmlspecialchars($row['feedback_text']);
                $sentimentClass = getSentimentClass($feedbackText);
                ?>
                <div class="card <?php echo $sentimentClass; ?>">
                    <div class="card-body">
                        <h5 class="card-title">Feedback</h5>
                        <p class="card-text"><?php echo $feedbackText; ?></p>
                    </div>
                    <div class="card-footer">
                        <?php echo $row['created_at']; ?>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No feedback available.</p>";
        }
        ?>
        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo ($page - 1); ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo ($page + 1); ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   
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
