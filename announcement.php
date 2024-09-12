<?php
include 'db.php'; // Include your DB connection

// Fetch announcements
$sql = "SELECT id, title, content, date FROM announcements ORDER BY date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
     <!-- Bootstrap CSS -->
     <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome for Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">


    <style>
        /* Base styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f0f2f5;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 36px;
            margin-bottom: 30px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .announcement {
            background-color: #f9f9f9;
            border-left: 5px solid #007bff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            transition: transform 0.2s ease;
        }

        .announcement:hover {
            transform: scale(1.02);
            background-color: #f1f4f8;
        }

        .announcement h2 {
            font-size: 24px;
            color: #007bff;
            margin-bottom: 10px;
        }

        .announcement p {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
        }

        .announcement .date {
            color: #999;
            font-size: 14px;
            margin-top: 10px;
            font-style: italic;
        }

        .delete-btn {
            display: inline-block;
            background-color: #ff4d4d;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        .delete-btn:hover {
            background-color: #e60000;
        }

        .add-btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 16px;
            position: fixed;
            top: 30px;
            right: 30px;
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.4);
            transition: background-color 0.3s, transform 0.2s ease;
        }

        .add-btn:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        .no-announcements {
            text-align: center;
            color: #999;
            font-size: 18px;
            font-style: italic;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 28px;
            }

            .announcement h2 {
                font-size: 20px;
            }

            .announcement p {
                font-size: 14px;
            }

            .add-btn {
                padding: 10px 16px;
                font-size: 14px;
            }
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

<a href="add_announcement.php" class="add-btn">+ Add Announcement</a>

<h1><i class="material-icons">campaign</i> Latest Announcements</h1>

<div class="container">

    <?php if ($result->num_rows > 0) { ?>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="announcement">
                <h2><?php echo $row['title']; ?></h2>
                <p><?php echo $row['content']; ?></p>
                <p class="date">Posted on: <?php echo date('F j, Y', strtotime($row['date'])); ?></p>
                <a href="delete_announcement.php?id=<?php echo $row['id']; ?>" class="delete-btn">Delete</a>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p class="no-announcements">No announcements available at the moment.</p>
    <?php } ?>

</div>
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
