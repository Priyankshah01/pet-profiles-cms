<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('../../db.php');

// Redirect if ID is not provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$petId = $_GET['id'];
$pet = getPetById($pdo, $petId);
$breeds = getAllBreeds($pdo);
$errors = [];
$success = false;

if (!$pet) {
    die("Pet not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $breed = trim($_POST['breed']);
    $story = trim($_POST['story']);
    $photo = $pet['photo']; // Keep existing photo unless updated

    // Validation
    if (empty($name)) $errors[] = "Pet name is required.";
    if (empty($breed)) $errors[] = "Breed is required.";
    if (empty($story)) $errors[] = "Story is required.";

    // Handle new photo upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $filename = uniqid() . '.' . $ext;
            $target = "../../uploads/" . $filename;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
                // Delete old photo if exists
                if (!empty($pet['photo']) && file_exists("../../uploads/" . $pet['photo'])) {
                    unlink("../../uploads/" . $pet['photo']);
                }
                $photo = $filename;
            } else {
                $errors[] = "Failed to upload image.";
            }
        } else {
            $errors[] = "Invalid file type. Allowed: jpg, jpeg, png, gif.";
        }
    }

    // Update pet if no errors
    if (empty($errors)) {
        try {
            updatePet($pdo, $petId, $name, $breed, $story, $photo);
            $success = true;
            $pet = getPetById($pdo, $petId); // Refresh data
        } catch (Exception $e) {
            $errors[] = "Failed to update pet: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Pet</title>
    <style>
        form {
            max-width: 600px;
            margin: auto;
         }
        label {
            display: block;
            margin-top: 15px;
         }
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
        img { 
            max-height: 100px;
            margin-top: 10px; 
        }
    </style>
</head>
<body>
    <h1> Edit Pet</h1>
    <p><a href="index.php"> Back to Pet List</a></p>

    <?php if ($success): ?>
        <p class="success"> Pet updated successfully!</p>
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
        <input type="text" name="name" value="<?= htmlspecialchars($pet['name']) ?>" required>

        <label>Breed:</label>
        <select name="breed" required>
            <option value="">-- Select Breed --</option>
            <?php foreach ($breeds as $b): ?>
                <option value="<?= htmlspecialchars($b['breed_name']) ?>"
                    <?= $pet['breed'] == $b['breed_name'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($b['breed_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Story:</label>
        <textarea name="story" rows="5" required><?= htmlspecialchars($pet['story']) ?></textarea>

        <label>Current Photo:</label>
        <?php if (!empty($pet['photo'])): ?>
            <img src="../../uploads/<?= htmlspecialchars($pet['photo']) ?>" alt="Current Photo">
        <?php else: ?>
            <em>No image</em>
        <?php endif; ?>

        <label>New Photo (optional):</label>
        <input type="file" name="photo" accept="image/*">

        <button type="submit" style="margin-top: 15px;">Update Pet</button>
    </form>
</body>
</html>
