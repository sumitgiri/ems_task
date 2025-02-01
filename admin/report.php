<?php
session_start();

// Ensure the user is an admin
if ($_SESSION['role'] != 'admin') {
    header('Location: ../auth/login.php');
    exit();
}

// Include the database connection
include '../config/database.php';

// Prepare the SQL statement to get all tasks
$stmt = $conn->prepare("SELECT * FROM tasks");
$stmt->execute();

// Fetch all tasks
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Set the headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="task_report.csv"');

// Open output stream for CSV
$output = fopen('php://output', 'w');

// Add CSV column headers
fputcsv($output, ['Start Time', 'Stop Time', 'Notes', 'Description']);

// Add the tasks to the CSV
foreach ($tasks as $task) {
    fputcsv($output, [$task['start_time'], $task['stop_time'], $task['notes'], $task['description']]);
}

// Close the output stream
fclose($output);

// Exit the script after download
exit();
