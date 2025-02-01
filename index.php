<?php 
session_start();

// Check if the user is already logged in as admin
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    header('Location: admin/dashboard.php');
    exit();
}

include 'includes/header.php'; 
?>
<div class="container text-center mt-5">
    <h1 class="display-4">Welcome to Task Management Portal</h1>
    <p class="lead">A simple task management system for admins and employees.</p>
    <a href="auth/login.php" class="btn btn-primary btn-lg">Login</a>
</div>
<?php include 'includes/footer.php'; ?>
