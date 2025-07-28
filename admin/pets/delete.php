<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('../../db.php');

// Check if ID is passed
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$petId = $_GET['id'];

// Fetch the pet to check if it exists and get the photo filename
$pet = getPetById($pdo, $petId);

if (!$pet) {
    die("Pet not found.");
}

// Delete photo file if it exists
if (!empty($pet['photo']) && file_exists("../../uploads/" . $pet['photo'])) {
    unlink("../../uploads/" . $pet['photo']);
}

// Delete pet from database
try {
    deletePet($pdo, $petId);
    header("Location: index.php");
    exit;
} catch (Exception $e) {
    die("Error deleting pet: " . $e->getMessage());
}
?>
