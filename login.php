<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            font-family: 'Arial', sans-serif;
        }
        .carousel-item {
         
            align-items: center;
            justify-content: center;
            height: 80vh;
            overflow: hidden;
            
        }
        .card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
            max-width: 500px;
            padding: 2rem;
            margin: auto;
           margin-top:100px;
           
            height:350px;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        }
        .card-title {
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            color: #333;
        }
        .btn-primary {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            border: none;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
        }
        .carousel-control-prev, .carousel-control-next {
            filter: invert(1);
        }
        .carousel-indicators [data-bs-target] {
            background-color: rgba(0, 0, 0, 0.5);
        }
        .carousel-indicators .active {
            background-color: #000;
        }
        /* Navbar */
.navbar {
    background-color: rgba(255, 255, 255, 0.1) !important; /* Slightly visible, near-transparent background */
    padding: 0.5rem 1rem; /* Compact padding */
    box-shadow: none; /* Remove shadow for a cleaner look */
    z-index: 1000; /* Ensure the navbar stays above other content */
    padding-bottom:20px;
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
    </style>
</head>
<body>
     <!-- Navbar -->
     <nav class="navbar navbar-expand-lg navbar-dark">
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
<div class="container mt-5">
    <div id="carouselExampleControls" class="carousel slide">
        <div class="carousel-inner">
            <!-- Student Login Card -->
            <div class="carousel-item active">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Student Login</h5>
                        <form action="login_action.php" method="post">
                            <div class="mb-3">
                                <label for="username_student" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username_student" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_student" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password_student" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Staff Login Card -->
            <div class="carousel-item">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Staff Login</h5>
                        <form action="login_action.php" method="post">
                            <div class="mb-3">
                                <label for="username_staff" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username_staff" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_staff" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password_staff" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Admin Login Card -->
            <div class="carousel-item">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Admin Login</h5>
                        <form action="login_action.php" method="post">
                            <div class="mb-3">
                                <label for="username_admin" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username_admin" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_admin" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password_admin" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
</body>
</html>
