<?php
session_start();
include '../config/database.php';

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Update password when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare and execute the update query
    $stmt = $conn->prepare("UPDATE users SET password = ?, last_password_change = NOW() WHERE id = ?");
    $stmt->execute([$new_password, $user_id]);

    // Redirect to dashboard after successful password change
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- Include Bootstrap CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Main Container -->
<div class="container mt-5">

    <!-- Heading Section -->
    <div class="row">
        <div class="col-md-6 mx-auto">
            <h2 class="text-center mb-4">Change Password</h2>
            
            <!-- Password Change Form -->
            <form method="post">
                
                <!-- Password Input -->
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" id="password" required placeholder="Enter new password">
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">Update Password</button>
            </form>
        </div>
    </div>

</div>

<!-- Include Bootstrap JS and Popper.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
