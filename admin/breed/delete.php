<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('../../db.php');

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$breed_id = $_GET['id'];

// Get breed name
$breed = executeQuery($pdo, "SELECT * FROM breeds WHERE id = ?", [$breed_id])->fetch();
if (!$breed) {
    die("Breed not found.");
}
$breed_name = $breed['breed_name'];

// Check if any pets use this breed
$petsUsing = executeQuery($pdo, "SELECT COUNT(*) as total FROM pets WHERE breed = ?", [$breed_name])->fetch();

if ($petsUsing['total'] > 0) {
    die(" Cannot delete breed. It is currently used by {$petsUsing['total']} pet(s).");
}

// Delete breed
try {
    executeQuery($pdo, "DELETE FROM breeds WHERE id = ?", [$breed_id]);
    header("Location: index.php");
    exit;
} catch (Exception $e) {
    die("Error deleting breed: " . $e->getMessage());
}
?>
