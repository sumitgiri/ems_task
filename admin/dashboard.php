<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: ../auth/login.php');
    exit();
}

include '../config/database.php';
include '../includes/header.php';

// Check if the success message is set in the session and remove it after displaying
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
} else {
    $success_message = '';
}
?>
<div class="container mt-5">
    <!-- Welcome Section -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h2>Welcome, Admin</h2>
                </div>
                <div class="card-body">
                    <p class="text-center mb-4">Manage users and download task reports from this dashboard.</p>
                    
                    <div class="d-flex justify-content-around">
                        <!-- Create New User Button -->
                        <a href="create_user.php" class="btn btn-success btn-lg">Create New User</a>
                        <!-- Download Task Report Button -->
                        <a href="report.php" class="btn btn-info btn-lg">Download Task Report</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if ($success_message): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '<?php echo $success_message; ?>',
            showConfirmButton: false,
            timer: 1500
        });
    <?php endif; ?>
</script>

<?php include '../includes/footer.php'; ?>
