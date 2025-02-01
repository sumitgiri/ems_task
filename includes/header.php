
<!-- <?php
// session_start();
// print_r($_SESSION);
// exit;
?> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Management Portal</title>
    <!-- Add this in your ../includes/header.php file, inside the <head> section -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Task Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- If logged in, show username and role -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> (<?php echo ucfirst($_SESSION['role']); ?>)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../auth/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <!-- If not logged in, show Login link -->
                    <li class="nav-item"><a class="nav-link" href="../auth/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
