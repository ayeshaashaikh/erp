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
   
   <!-- Add Timetable Form -->
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
    </style>
    <div class= "container">
    <form method="POST" action="">
            <div class="form-group">
                <label for="branch">Select Branch:</label>
                <select name="branch_id" id="branch" class="form-control" required>
                    <option value="">Select Branch</option>
                    <?php foreach ($branches as $branch): ?>
                        <option value="<?php echo htmlspecialchars($branch['id']); ?>"><?php echo htmlspecialchars($branch['branch_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="class">Select Class:</label>
                <select name="class_id" id="class" class="form-control" required>
                    <option value="">Select Class</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?php echo htmlspecialchars($class['id']); ?>"><?php echo htmlspecialchars($class['class_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" name="subject" id="subject" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="start_time">Start Time:</label>
                <input type="time" name="start_time" id="start_time" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="end_time">End Time:</label>
                <input type="time" name="end_time" id="end_time" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="day">Day:</label>
                <select name="day" id="day" class="form-control" required>
                    <option value="">Select Day</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                </select>
            </div>

            <button type="submit" name="add_timetable" class="btn btn-primary">Add Timetable</button>
        </form>
                    </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                    </body>
                    </html>