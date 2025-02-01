<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: ../auth/login.php');
    exit();
}
include '../config/database.php';

function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
    return substr(str_shuffle($characters), 0, $length);
}

$generated_password = generateRandomPassword();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$first_name, $last_name, $email, $phone, $password, $role]);

    $_SESSION['success_message'] = "User created successfully!";
    header("Location: dashboard.php?success=true");
    exit();
}

include '../includes/header.php';
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4 text-primary">Create New User</h2>
            <form method="POST" class="shadow p-4 bg-white rounded">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" value="<?php echo $generated_password; ?>" readonly required>
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword"><i class="fas fa-eye"></i></button>
                        <button type="button" class="btn btn-outline-secondary" id="copyPassword"><i class="fas fa-copy"></i></button>
                        <button type="button" class="btn btn-outline-secondary" id="regeneratePassword"><i class="fas fa-sync"></i></button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });

    document.getElementById('copyPassword').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        passwordField.select();
        document.execCommand('copy');
        Swal.fire({
            icon: 'success',
            title: 'Copied!',
            text: 'Password copied to clipboard',
            showConfirmButton: false,
            timer: 1500,
            position: 'top'
        });
    });

    document.getElementById('regeneratePassword').addEventListener('click', function () {
        fetch(window.location.href)
            .then(response => response.text())
            .then(data => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, 'text/html');
                const newPassword = doc.getElementById('password').value;
                document.getElementById('password').value = newPassword;
                Swal.fire({
                    icon: 'success',
                    title: 'Regenerated!',
                    text: 'Password has been regenerated',
                    showConfirmButton: false,
                    timer: 1500,
                    position: 'top'
                });
            });
    });

    <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '<?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>',
            showConfirmButton: false,
            timer: 1500
        });
    <?php endif; ?>
</script>
<?php include '../includes/footer.php'; ?>
