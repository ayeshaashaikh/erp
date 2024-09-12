<?php
require 'db.php'; // Include your database connection

// Fetch branches from the database for the filter
$branchQuery = "SELECT DISTINCT branch FROM courses"; // Adjust the query based on your table name and structure
$branchResult = mysqli_query($conn, $branchQuery);
$branches = mysqli_fetch_all($branchResult, MYSQLI_ASSOC);

// Handle filtering
$branchFilter = isset($_GET['branch']) ? $_GET['branch'] : '';

// Fetch courses based on the filter
$courseQuery = "SELECT * FROM courses";
if ($branchFilter) {
    $courseQuery .= " WHERE branch = '".mysqli_real_escape_string($conn, $branchFilter)."'";
}
$courseResult = mysqli_query($conn, $courseQuery);
$courses = mysqli_fetch_all($courseResult, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
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
            padding-bottom:310px;
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

        /* Card Grid Styling */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .course-card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            background-color: #fff;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 250px;
            width: 250px;
        }

        .course-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .course-card:hover img {
            transform: scale(1.05);
        }

        .course-card-content {
            padding: 15px;
            text-align: center;
            flex-grow: 1;
            overflow: hidden;
        }

        .course-card h3 {
            margin: 10px 0;
            font-size: 1.1rem;
        }

        .course-card p {
            font-size: 0.9rem;
            color: #666;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .course-card-actions {
            padding: 10px 15px;
            background: #f8f9fa;
            text-align: center;
            border-top: 1px solid #ddd;
        }

        .course-card-actions a {
            text-decoration: none;
            color: #007bff;
            margin: 0 10px;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .course-card-actions a:hover {
            color: #0056b3;
        }

        .add-course-btn {
    background-color: #ffffff; /* White background */
    color: #17a2b8; /* Text color */
    border: 2px solid #17a2b8; /* Border color matching text color */
    padding: 10px 20px; /* Padding around the text */
    border-radius: 8px; /* Rounded corners */
    font-size: 16px; /* Font size */
    font-weight: bold; /* Bold text */
    text-transform: uppercase; /* Uppercase text */
    cursor: pointer; /* Pointer cursor on hover */
    transition: all 0.3s ease; /* Smooth transition for hover effects */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow for 3D effect */
    margin-bottom:15px;
}

.add-course-btn:hover {
    background-color: #f8f9fa; /* Slightly darker background on hover */
    color: #17a2b8; /* Keep text color same on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Deeper shadow on hover */
    transform: translateY(-2px); /* Lift effect on hover */
}

.add-course-btn:active {
    background-color: #e2e6ea; /* Darker background on click */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Lighter shadow on click */
    transform: translateY(0); /* Remove lift effect on click */
}

        
        /* Filter Form Styling */
        .filter-form {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    margin-bottom: 20px;
    background-color: #ffffff; /* White background */
    border-radius: 8px; /* Rounded corners */
    padding: 10px; /* Padding around the form elements */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* 3D shadow effect */
    transition: all 0.3s ease; /* Smooth transition for hover effects */
}

.filter-form:hover {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Deeper shadow on hover */
}

.filter-form select {
    margin-left: 10px;
    background-color: #ffffff; /* White background */
    color: #17a2b8; /* Text color */
    border: 2px solid #17a2b8; /* Border color matching text color */
    border-radius: 8px; /* Rounded corners */
    padding: 8px 12px; /* Padding inside the dropdown */
    font-size: 16px; /* Font size */
    font-weight: bold; /* Bold text */
    cursor: pointer; /* Pointer cursor */
    transition: all 0.3s ease; /* Smooth transition for hover effects */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* 3D shadow effect */
}

.filter-form select:hover {
    background-color: #f8f9fa; /* Slightly darker background on hover */
    border-color: #17a2b8; /* Keep border color same on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Deeper shadow on hover */
}

.filter-form select:focus {
    outline: none; /* Remove default outline */
    border-color: #007bff; /* Change border color on focus */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Glow effect on focus */
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
.container h2 {
    text-align: center;
    margin-bottom: 20px; /* Optional: Adjust as needed */
}
.content {
    background-color: #925fe259;
    padding: 20px;
    margin-left: 250px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding-bottom: 314px;
}
.card-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* Ensure 3 cards per row */
    gap: 15px;
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



    <!-- Content -->
    <div class="content">
        <div class="container">
            <h2>VIEW COURSES</h2>

            

            <!-- Add Course Button -->
            <div class="table-container mb-4">
             
                <form method="GET" action="">
                    <label for="branch">Filter by Branch:</label>
                    <select name="branch" id="branch" class="form-control" onchange="this.form.submit()">
                        <option value="">All Branches</option>
                        <?php foreach ($branches as $branch): ?>
                            <option value="<?php echo htmlspecialchars($branch['branch']); ?>" <?php echo ($branchFilter === $branch['branch']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($branch['branch']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>

            <!-- Course Cards -->
            <div class="card-grid">
                <?php if ($courses): ?>
                    <?php foreach ($courses as $course): ?>
                        <div class="course-card">
                        <img src="images/<?php echo htmlspecialchars($course['course_image']); ?>" alt="<?php echo htmlspecialchars($course['course_name']); ?>">

                            <div class="course-card-content">
                                <h3><?php echo htmlspecialchars($course['course_name']); ?></h3>
                                <p><?php echo htmlspecialchars($course['description']); ?></p>
                            </div>
                            <div class="course-card-actions">
                                <a href="#">Enroll</a>
                               
                                </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No courses found.</p>
                <?php endif; ?>
            </div>
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
