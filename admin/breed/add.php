<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('../../db.php');

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $breed_name = trim($_POST['breed_name']);

    if (empty($breed_name)) {
        $errors[] = "Breed name is required.";
    }

    if (empty($errors)) {
        try {
            // Check if breed already exists
            $existing = executeQuery($pdo, "SELECT id FROM breeds WHERE breed_name = ?", [$breed_name])->fetch();
            if ($existing) {
                $errors[] = "Breed already exists.";
            } else {
                executeQuery($pdo, "INSERT INTO breeds (breed_name) VALUES (?)", [$breed_name]);
                $success = true;
            }
        } catch (Exception $e) {
            $errors[] = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Breed</title>
    <style>
        form { 
            max-width: 400px; 
            margin: auto;
         }
        label {
            display: block;
            margin-top: 15px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
        }
        .success {
             color: green;
             }
        .error { 
            color: red;
         }
    </style>
</head>
<body>
    <h1> Add New Breed</h1>
    <p><a href="index.php"> Back to Breeds</a></p>

    <?php if ($success): ?>
        <p class="success"> Breed added successfully!</p>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label>Breed Name:</label>
        <input type="text" name="breed_name" required>
        <button type="submit" style="margin-top: 15px;">Add Breed</button>
    </form>
</body>
</html>
