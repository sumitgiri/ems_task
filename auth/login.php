<?php
session_start();

// Check if the user is already logged in, and redirect them to the appropriate dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: ../" . ($_SESSION['role'] == 'admin' ? 'admin/dashboard.php' : 'user/dashboard.php'));
    exit();
}

include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['last_login'] = $user['last_login'];
        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
        
        // Update last login
        $stmt = $conn->prepare("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$user['id']]);

        header("Location: ../" . ($user['role'] == 'admin' ? 'admin/dashboard.php' : 'user/dashboard.php'));
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}

include '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            font-family: Arial, sans-serif;
        }
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-header h2 {
            color: #333;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="login-container">
        <div class="login-header">
            <h2>Login</h2>
        </div>

        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="Enter your password">
            </div>

            <button type="submit" class="btn btn-primary btn-block">Login</button>

            <?php if (isset($error)) { echo "<div class='error-message'>$error</div>"; } ?>
        </form>
    </div>
</div>

<!-- Add Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php include '../includes/footer.php'; ?>
