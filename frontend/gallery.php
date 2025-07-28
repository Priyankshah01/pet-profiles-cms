<?php
require_once 'includes/db.php';
include 'includes/header.php';

$pets = getAllPets($pdo); // Fetch all pets
?>

<div class="gallery">
  <?php foreach ($pets as $pet): ?>
    <div class="pet-card">
      <img src="images/<?= htmlspecialchars($pet['photo']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>">
      <h3><?= htmlspecialchars($pet['name']) ?></h3>
      <p><?= htmlspecialchars($pet['breed']) ?></p>
      <a href="pet-detail.php?id=<?= $pet['id'] ?>">Read Story</a>
    </div>
  <?php endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>
