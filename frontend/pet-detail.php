<?php
require_once 'includes/db.php';
include 'includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pet = getPetById($pdo, $id);
?>

<?php if ($pet): ?>
  <div class="pet-detail">
    <img src="images/<?= htmlspecialchars($pet['photo']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>">
    <h2><?= htmlspecialchars($pet['name']) ?></h2>
    <h4>Breed: <?= htmlspecialchars($pet['breed']) ?></h4>
    <p><?= nl2br(htmlspecialchars($pet['story'])) ?></p>
    <a href="gallery.php">← Back to Gallery</a>
  </div>
<?php else: ?>
  <p>Sorry, pet not found.</p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
