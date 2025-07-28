<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('../../db.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$breed_id = $_GET['id'];
$breed = executeQuery($pdo, "SELECT * FROM breeds WHERE id = ?", [$breed_id])->fetch();

if (!$breed) {
    die("Breed not found.");
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $breed_name = trim($_POST['breed_name']);

    if (empty($breed_name)) {
        $errors[] = "Breed name is required.";
    }

    if (empty($errors)) {
        try {
            // Check for duplicate breed
            $duplicate = executeQuery($pdo, "SELECT id FROM breeds WHERE breed_name = ? AND id != ?", [$breed_name, $breed_id])->fetch();
            if ($duplicate) {
                $errors[] = "Another breed with this name already exists.";
            } else {
                executeQuery($pdo, "UPDATE breeds SET breed_name = ? WHERE id = ?", [$breed_name, $breed_id]);
                $success = true;
                // Refresh data
                $breed = executeQuery($pdo, "SELECT * FROM breeds WHERE id = ?", [$breed_id])->fetch();
            }
        } catch (Exception $e) {
            $errors[] = "Update failed: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Breed</title>
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
    <h1> Edit Breed</h1>
    <p><a href="index.php"> Back to Breeds</a></p>

    <?php if ($success): ?>
        <p class="success"> Breed updated successfully!</p>
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
        <input type="text" name="breed_name" value="<?= htmlspecialchars($breed['breed_name']) ?>" required>
        <button type="submit" style="margin-top: 15px;">Update Breed</button>
    </form>
</body>
</html>
