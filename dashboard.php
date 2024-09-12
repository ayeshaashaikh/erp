<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
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
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
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

        .header {
            height: 60px;
            background-color: #007bff;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }

        .header .title {
            font-size: 24px;
            font-weight: bold;
        }

        .header .profile {
            display: flex;
            align-items: center;
        }

        .header .profile img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
        }

        .card-footer {
            background-color: #f1f1f1;
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
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <button class="toggle-btn" id="toggleBtn"><i class="fas fa-bars"></i></button>
    <h4 class="text-center text-white">Admin Panel</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-user"></i> <span>User Management</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-book"></i> <span>Course Management</span></a>
        </li>
        <!-- Add more navigation items as needed -->
    </ul>
</div>

<div class="content">
    <div class="header">
        <div class="title">Dashboard</div>
        <div class="profile">
            <img src="https://via.placeholder.com/40" alt="Profile">
            <span>Admin</span>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Total Users</h5>
                    </div>
                    <div class="card-body">
                        <h2 class="text-center">150</h2>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary btn-block">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Courses</h5>
                    </div>
                    <div class="card-body">
                        <h2 class="text-center">75</h2>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary btn-block">View Details</a>
                    </div>
                </div>
            </div>
            <!-- Add more cards as needed -->
        </div>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleBtn');

    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('active');
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
