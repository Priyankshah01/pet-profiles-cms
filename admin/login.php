<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('../includes/connection.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$username || !$password) {
        $error = "Please enter both username and password.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<!-- Show login form -->
<!DOCTYPE html>
<html>
<head><title>Admin Login</title></head>
<body>
    <h2>Login</h2>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label>Username:</label><br />
        <input type="text" name="username" required><br /><br />

        <label>Password:</label><br />
        <input type="password" name="password" required><br /><br />

        <button type="submit">Login</button>
    </form>
</body>
</html>
