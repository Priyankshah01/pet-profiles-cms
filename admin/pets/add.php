<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('../../db.php');

$errors = [];
$success = false;

// Get breeds for dropdown
$breeds = getAllBreeds($pdo);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $breed = trim($_POST['breed']);
    $story = trim($_POST['story']);
    $photo = null;

    // Basic validation
    if (empty($name)) $errors[] = "Pet name is required.";
    if (empty($breed)) $errors[] = "Breed is required.";
    if (empty($story)) $errors[] = "Story is required.";

    // Handle image upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $filename = uniqid() . '.' . $ext;
            $target = "../../uploads/" . $filename;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
                $photo = $filename;
            } else {
                $errors[] = "Failed to upload image.";
            }
        } else {
            $errors[] = "Invalid file type. Allowed: jpg, jpeg, png, gif.";
        }
    }

    // If no errors, insert pet
    if (empty($errors)) {
        try {
            addPet($pdo, $name, $breed, $story, $photo);
            $success = true;
        } catch (Exception $e) {
            $errors[] = "Failed to add pet: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Pet</title>
    <style>
        form { 
            max-width: 600px; 
            margin: auto; }
        label {
             display: block;
              margin-top: 15px; }
        input[type="text"], textarea, select {
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
    <h1> Add New Pet</h1>
    <p><a href="index.php"> Back to Pet List</a></p>

    <?php if ($success): ?>
        <p class="success"> Pet added successfully!</p>
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

    <form method="POST" enctype="multipart/form-data">
        <label>Pet Name:</label>
        <input type="text" name="name" required>

        <label>Breed:</label>
        <select name="breed" required>
            <option value="">-- Select Breed --</option>
            <?php foreach ($breeds as $b): ?>
                <option value="<?= htmlspecialchars($b['breed_name']) ?>">
                    <?= htmlspecialchars($b['breed_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Story:</label>
        <textarea name="story" rows="5" required></textarea>

        <label>Photo (optional):</label>
        <input type="file" name="photo" accept="image/*">

        <button type="submit" style="margin-top: 15px;">Add Pet</button>
    </form>
</body>
</html>
