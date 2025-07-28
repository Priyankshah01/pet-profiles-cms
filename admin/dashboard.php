<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('../includes/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></h1>
    <ul>
        <li><a href="pets/index.php">Manage Pets</a></li>
        <li><a href="breed/index.php">Manage Breeds</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>
