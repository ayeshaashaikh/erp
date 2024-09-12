<?php
require 'db.php'; // Include your database connection

// Initialize variables for displaying messages
$successMessage = '';
$errorMessage = '';

// Retrieve existing users for dropdown
$usersQuery = "SELECT id, username FROM users";
$usersResult = $conn->query($usersQuery);

// Define branches
$branches = ['Computer', 'Civil', 'Mechanical', 'Automobile', 'EJ'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $courseName = $conn->real_escape_string($_POST['courseName']);
    $courseCode = $conn->real_escape_string($_POST['courseCode']);
    $description = $conn->real_escape_string($_POST['description']);
    $uploadedBy = $conn->real_escape_string($_POST['uploadedBy']);
    $branch = $conn->real_escape_string($_POST['branch']);
    
    // Check if uploaded_by value exists in the users table
    $checkUserQuery = "SELECT id FROM users WHERE id = $uploadedBy";
    $checkUserResult = $conn->query($checkUserQuery);

    if ($checkUserResult->num_rows == 0) {
        $errorMessage = 'Invalid uploaded_by value. User ID does not exist.';
    } else {
        // Handle image upload
        $courseImage = '';
        if (isset($_FILES['courseImage']) && $_FILES['courseImage']['error'] == UPLOAD_ERR_OK) {
            $imageTmpName = $_FILES['courseImage']['tmp_name'];
            $imageName = basename($_FILES['courseImage']['name']);
            $imagePath = 'images/' . $imageName;

            if (move_uploaded_file($imageTmpName, $imagePath)) {
                $courseImage = $imageName;
            } else {
                $errorMessage = 'Failed to upload image.';
            }
        }

        // Insert course into the database
        if (empty($errorMessage)) {
            $sql = "INSERT INTO courses (course_name, course_code, description, uploaded_by, branch, course_image)
                    VALUES ('$courseName', '$courseCode', '$description', '$uploadedBy', '$branch', '$courseImage')";

            if ($conn->query($sql) === TRUE) {
                $successMessage = 'New course added successfully!';
            } else {
                $errorMessage = 'Error: ' . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Course</h2>
        
        <?php if ($successMessage): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>
        <?php if ($errorMessage): ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
        
        <form action="add_course.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="courseName">Course Name:</label>
                <input type="text" class="form-control" id="courseName" name="courseName" required>
            </div>
            <div class="form-group">
                <label for="courseCode">Course Code:</label>
                <input type="text" class="form-control" id="courseCode" name="courseCode" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="uploadedBy">Uploaded By:</label>
                <select class="form-control" id="uploadedBy" name="uploadedBy" required>
                    <option value="">Select User</option>
                    <?php while ($user = $usersResult->fetch_assoc()): ?>
                        <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="branch">Branch:</label>
                <select class="form-control" id="branch" name="branch" required>
                    <option value="">Select Branch</option>
                    <?php foreach ($branches as $branchOption): ?>
                        <option value="<?php echo $branchOption; ?>"><?php echo $branchOption; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="courseImage">Course Image:</label>
                <input type="file" class="form-control-file" id="courseImage" name="courseImage">
            </div>
            <button type="submit" class="btn btn-primary">Add Course</button>
        </form>
    </div>

    <!-- Bootstrap JS for functionality -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
