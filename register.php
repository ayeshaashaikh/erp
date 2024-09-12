<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            font-family: 'Arial', sans-serif;
            margin: 0;
        }
        /* Navbar */
        .navbar {
            background-color: rgba(255, 255, 255, 0.1) !important; /* Slightly visible, near-transparent background */
            padding: 0.5rem 1rem; /* Compact padding */
            box-shadow: none; /* Remove shadow for a cleaner look */
            z-index: 1000; /* Ensure the navbar stays above other content */
        }
        .navbar-brand img {
            height: 50px; /* Adjust logo size */
        }
        /* Aligning navbar items to the right with space between them */
        .navbar-nav {
            margin-left: auto; /* Push items to the right */
            display: flex; /* Ensure items are aligned in a row */
            margin-top:10px;
        }
        .navbar-nav .nav-item {
            margin-left: 10px; /* Space between items */
        }
        .navbar-nav .nav-link {
            width: 100px; /* Fixed width for each link */
            color: White !important; /* Light color for contrast */
            padding: 0.5rem; /* Adjust padding to control link height */
            border-radius: 20px; /* Slightly rounded corners */
            background: linear-gradient(135deg, #6a11cb, #2575fc);    text-align: center; /* Center text inside the link */
            display: inline-flex; /* Use inline-flex to respect width and align content */
            align-items: center; /* Center items vertically */
            justify-content: center; /* Center items horizontally */
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Slightly visible background on hover */
            color: #fff !important; /* Keep text color light */
        }
        .navbar-toggler {
            border-color: #fff !important; /* Light border color for toggler */
        }
        .navbar-toggler-icon {
            background-image: url('data:image/svg+xml,...'); /* Optional: Custom icon */
        }
        .register-container {
            width: 100%;
            max-width: 500px;
            
            margin:auto;
            margin-top: 110px; /* Adjust the margin to avoid overlap with the fixed navbar */
        }
        .register-card {
    position: relative;
    background: #fff;
    border-radius: 12px; /* Keep the rounded corners */
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 
                0 8px 16px rgba(0, 0, 0, 0.3); /* Deep and layered shadows */
    overflow: hidden;
    padding: 2rem;
    transform: perspective(1500px) scale(1); /* Large perspective for depth without rotation */
    transition: transform 0.4s ease, box-shadow 0.4s ease; /* Smooth transition for interactive effect */
}





        .register-card h2 {
            position: relative;
            z-index: 1;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
            color: #333;
        }
        .register-card .form-group {
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }
        .register-card .form-label {
            font-weight: bold;
            color: #555;
        }
        .register-card .form-control {
            border-radius: 6px;
            box-shadow: none;
            border: 1px solid #ddd;
        }
        .register-card .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 6px;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }
        .register-card .btn-primary:hover {
            background-color: #0056b3;
        }
        .footer-message {
            margin-top: 1.5rem;
            position: relative;
            z-index: 1;
        }
        .footer-message a {
            color: #007bff;
            text-decoration: none;
        }
        .footer-message a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="images/jlogo.png" alt="Logo" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="register-container">
        <div class="register-card">
            <h2>Create Your Account</h2>
            <form action="register_action.php" method="post">
                <div class="form-group">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="role" class="form-label">Role:</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="1">Admin</option>
                        <option value="2">Faculty</option>
                        <option value="3">Student</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
                <div class="footer-message">
                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
