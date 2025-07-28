<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('../../db.php');

$breeds = getAllBreeds($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Breeds</title>
    <style>
        table { 
            width: 100%;
            border-collapse: collapse; 
        }
        th, td {
             padding: 10px;
             border: 1px solid #ccc;
             }
        .actions a { 
            margin-right: 10px; 
        }
    </style>
</head>
<body>
    <h1> Manage Breeds</h1>
    <p><a href="add.php"> Add New Breed</a>
     <a href="../pets/index.php"> Back to Pets</a></p>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Breed Name</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($breeds) > 0): ?>
                <?php foreach ($breeds as $b): ?>
                    <tr>
                        <td><?= $b['id'] ?></td>
                        <td><?= htmlspecialchars($b['breed_name']) ?></td>
                        <td><?= $b['created_at'] ?></td>
                        <td class="actions">
                            <a href="edit.php?id=<?= $b['id'] ?>"> Edit</a>
                            <a href="delete.php?id=<?= $b['id'] ?>" onclick="return confirm('Delete this breed?')"> Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">No breeds found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
