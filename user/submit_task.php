<?php
session_start();
if ($_SESSION['role'] != 'user') {
    header('Location: ../auth/login.php');
    exit();
}
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $notes = $_POST['notes'];
    $start_time = $_POST['start_time'];
    $stop_time = $_POST['stop_time'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO tasks (user_id, description, notes, start_time, stop_time) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $description, $notes, $start_time, $stop_time]);

    header('Location: dashboard.php');
    exit();
}

include '../includes/header.php';
?>
<div class="container mt-4">
    <h2>Submit New Task</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="description">Task Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="notes">Notes</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="start_time">Start Time</label>
            <input type="datetime-local" name="start_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="stop_time">Stop Time</label>
            <input type="datetime-local" name="stop_time" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit Task</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
