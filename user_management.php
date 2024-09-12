<?php
include 'db.php';

// Fetch all users with role names
$sql = "
    SELECT users.id, users.username, users.email, roles.role_name AS role_name 
    FROM users 
    JOIN roles ON users.role_id = roles.id
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">


    <!-- Custom CSS -->
    <style>
        .container {
            margin-top: 20px;
        }

        .btn {
            margin-bottom: 15px;
        }

        .table-container {
            position: relative;
        }

        .add-user-btn {
            position: absolute;
            right: 0;
            top: -60px; /* Adjust based on your preference */
            z-index: 1;
        }

        .btn-danger {
           margin-left:20px;
         
          
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

        .content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease;
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
    margin-top:50px;
}
/* Table styles */
.table {
    margin-top:50px;
    background-color: FloralWhite; /* Background color */
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

/* Optional: Add extra styling for buttons inside the table */
.table .btn {
    margin: 0 5px; /* Margin around buttons */
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

    </style>

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
    <div class="content">
        <div class="container">
            <h2>User Management</h2>
            
            <!-- Add User Button -->
            <div class="table-container">
                <a href="add_user.php" class="btn btn-primary add-user-btn">Add User</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['role_name']; ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                
            </div>
            
        </div>
        
    </div>

    

    <!-- JavaScript to handle sidebar toggle -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleBtn');

        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    </script>

    <!-- Bootstrap JS for functionality -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
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
