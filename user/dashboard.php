<?php
session_start();
include '../config/database.php';

// Redirect to login page if user is not logged in or has an invalid role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$check_stmt = $conn->prepare("SELECT last_password_change FROM users WHERE id = ?");
$check_stmt->execute([$user_id]);
$user = $check_stmt->fetch(PDO::FETCH_ASSOC);

$last_password_change = strtotime($user['last_password_change']);
$days_since_change = (time() - $last_password_change) / (60 * 60 * 24);

// Redirect to change password page if more than 30 days since the last password change
if ($days_since_change > 30) {
    header("Location: change_password.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_time = $_POST['start_time'];
    $stop_time = $_POST['stop_time'];
    $notes = $_POST['notes'];
    $description = $_POST['description'];

    // Insert task data into the database
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, start_time, stop_time, notes, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $start_time, $stop_time, $notes, $description]);

    // Trigger SweetAlert after task submission
    $success_message = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Include Bootstrap CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include SweetAlert2 CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .alert {
            border-radius: 5px;
            font-weight: bold;
        }
        h2 {
            color: #007bff;
            text-align: center;
            font-weight: 600;
        }
    </style>
</head>
<body>

<!-- Main Container -->
<div class="container">

    <!-- Dashboard Heading -->
    <h2>Submit New Task</h2>

    <!-- Task Submission Form -->
    <form method="post">
        
        <!-- Start Time Input -->
        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="datetime-local" name="start_time" class="form-control" id="start_time" required>
        </div>

        <!-- Stop Time Input -->
        <div class="mb-3">
            <label for="stop_time" class="form-label">Stop Time</label>
            <input type="datetime-local" name="stop_time" class="form-control" id="stop_time" required>
        </div>

        <!-- Notes Input -->
        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" class="form-control" id="notes" required placeholder="Add any additional notes"></textarea>
        </div>

        <!-- Description Input -->
        <div class="mb-3">
            <label for="description" class="form-label">Task Description</label>
            <textarea name="description" class="form-control" id="description" required placeholder="Describe the task"></textarea>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100">Submit Task</button>
    </form>

    <!-- Logout Button -->
    <a href="../auth/logout.php" class="btn btn-danger mt-3 w-100">Logout</a>

</div>

<!-- Include SweetAlert2 JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.js"></script>

<script>
    // Prevent future time selection
    document.addEventListener('DOMContentLoaded', function() {
        // Get the current date and time
        var now = new Date();
        
        // Format the date and time to match the datetime-local input format (YYYY-MM-DDTHH:MM)
        var formattedDate = now.toISOString().slice(0, 16);

        // Set the max attribute for both start_time and stop_time fields
        document.getElementById('start_time').setAttribute('max', formattedDate);
        document.getElementById('stop_time').setAttribute('max', formattedDate);
    });

    <?php if (isset($success_message) && $success_message): ?>
        Swal.fire({
            icon: 'success',
            title: 'Task Submitted Successfully!',
            text: 'Your task has been submitted.',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>
</script>

<!-- Include Bootstrap JS and Popper.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
