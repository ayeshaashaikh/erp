<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Panel</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@300..700&display=swap" rel="stylesheet">

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
        }

        /* Sidebar styles */
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

        /* Content section styles */
        /* Content section styles */
.welcome-box {
    background: url('images/welcome.jpg') no-repeat center center; /* Ensure background is centered and covers the entire box */
    background-size: cover; /* Cover the entire box */
    padding: 90px;
    border-radius: 10px; /* Adjust the border-radius to a smaller value for a more rectangular look */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.38), 0 6px 20px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin-top: 30px;
    transition: transform 0.3s;
    box-sizing: border-box; /* Include padding and border in the element's total width and height */
    width: 100%; /* Ensure the box takes the full width of its container */
    max-width: 960px; /* Set a max-width to prevent the box from becoming too wide */
    margin-left: auto; /* Center the box horizontally */
    margin-right: auto; /* Center the box horizontally */

}

.welcome-box:hover {
    transform: scale(1.03); /* Slightly scale up on hover */
}

.welcome-box h1 {
    font-size: 36px;
    color: WHITE;
    margin-bottom: 10px; /* Add some space below the heading */
    text-align:start;
    font-family: "Signika Negative", sans-serif;
  font-optical-sizing: auto;
  font-weight: <weight>;
  font-style: normal;

}

.welcome-box p {
    font-size: 36px;
    color: WHITE;
    margin: 0; /* Remove default margin */
    text-align:start;
    font-family: "Signika Negative", sans-serif;
  font-optical-sizing: auto;
  font-weight: <weight>;
  font-style: normal;
}


        /* New styles */
        p {
            text-align: center;
            margin-top: 0;
            margin-bottom: 1rem;
        }
      
        /* Dropdown and nav */
        .nav.flex-column {
            list-style-type: none;
            padding: 0;
         
    list-style-type: none;
    padding: 0;
    margin-top: 50px;

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
            left: 0;
            top: 100%;
            width: 100%;
            z-index: 1000;
        }

        .dropdown-menu .nav-link {
            padding: 10px;
            display: block;
            color: #fff;
        }

        .dropdown-menu .nav-link:hover {
            background-color: #555;
        }

        .show {
            display: block;
        }
        .content{
            background:#925fe259;
            padding-bottom:700px;
        }
        /* Styles for the quote box */
/* Add keyframe animation for sliding from left */
@keyframes slideFromLeft {
    0% {
        transform: translateY(-100%); /* Start off-screen from the left */
        opacity: 0;
    }
    100% {
        transform: translateY(0); /* End at the center */
        opacity: 1;
    }
}

/* Styles for the quote box */
.quote-box {
    background-color: #ffffff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.38), 0 6px 20px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin-top: 80px;
    box-sizing: border-box;
    width: 100%;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
    background: #d4c3f2;
    color: white;
    height: 300px;

    /* Apply the slide animation */
    animation: slideFromLeft 1s ease-out forwards;
}


.quote-box p {
    font-size: 26px;
    color: White;
    font-weight:bold;
    font-b
    margin: 0; /* Remove default margin */
    text-align:start;
    font-family: "Signika Negative", sans-serif;
  font-optical-sizing: auto;
  font-weight: <weight>;
  font-style: normal;
  margin-top:40px;
  margin-left:20px;
  text-align:center;
  text-shadow: 0 0 3px black, 0 0 5px black;
}

    </style>
</head>
<body>

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
            <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
        </li>
    </ul>
</div>


    <!-- Content -->
    <div class="content">
        <div class="welcome-box">
            <h1>Welcome Back, <?php echo htmlspecialchars($username); ?>!</h1>
          
        </div>
      
    </div>

</body>
</html>