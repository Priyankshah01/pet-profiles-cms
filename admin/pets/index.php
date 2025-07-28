<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../../db.php');

// Fetch all pets using helper function
$pets = getAllPets($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Pets</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        img {
            height: 60px;
            object-fit: cover;
        }
        .actions a {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h1> Pet Management</h1>

    <p><a href="add.php"> Add New Pet</a></p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Breed</th>
                <th>Story</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($pets) > 0): ?>
            <?php foreach ($pets as $pet): ?>
                <tr>
                    <td><?= htmlspecialchars($pet['id']) ?></td>
                    <td>
                        <?php if (!empty($pet['photo'])): ?>
                            <img src="../../uploads/<?= htmlspecialchars($pet['photo']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>">
                        <?php else: ?>
                            <em>No image</em>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($pet['name']) ?></td>
                    <td><?= htmlspecialchars($pet['breed']) ?></td>
                    <td><?= htmlspecialchars($pet['story']) ?></td>
                    <td><?= $pet['created_at'] ?></td>
                    <td class="actions">
                        <a href="edit.php?id=<?= $pet['id'] ?>"> Edit</a>
                        <a href="delete.php?id=<?= $pet['id'] ?>" onclick="return confirm('Are you sure you want to delete this pet?')"> Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7">No pets found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
