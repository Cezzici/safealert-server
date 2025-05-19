<?php
require_once 'header.php';
require_once 'db.php';

// Grupăm câte formulare are fiecare autoritate (după nume)
$form_counts = [];
$q = $conn->query("SELECT autoritate, COUNT(*) as total FROM forms GROUP BY autoritate");
while ($row = $q->fetch_assoc()) {
  $form_counts[$row['autoritate']] = $row['total'];
}

// Preluăm toate autoritățile
$result = $conn->query("SELECT * FROM authorities ORDER BY region ASC, name ASC");
?>

<div class="card">
  <h2>🏢 Autorități înregistrate în sistem</h2>

  <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
    <a href="dashboard.php" style="background-color: #5e4283; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 500;">
      ⬅️ Înapoi la Dashboard
    </a>

    <?php if ($_SESSION['role'] === 'admin'): ?>
      <a href="manage_authorities.php" style="background-color: #4CAF50; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 500;">
        ➕ Adaugă autoritate
      </a>
    <?php endif; ?>
  </div>

  <?php if ($result && $result->num_rows > 0): ?>
    <?php while ($auth = $result->fetch_assoc()): ?>
      <div style="margin-bottom: 20px; padding: 15px; border-left: 5px solid #5e4283; background-color: #fdfdff; border-radius: 8px;">
        <p><strong>ID intern:</strong> <?= htmlspecialchars($auth['authority_id']) ?></p>
        <p><strong>Nume autoritate:</strong> <?= htmlspecialchars($auth['name']) ?></p>
        <p><strong>Tip:</strong> <?= htmlspecialchars($auth['type'] ?? '-') ?></p>
        <p><strong>Regiune:</strong> <?= htmlspecialchars($auth['region'] ?? '-') ?></p>
        <p><strong>Persoană contact:</strong> <?= htmlspecialchars($auth['contact_person'] ?? '-') ?></p>
        <p><strong>Date contact:</strong> <?= htmlspecialchars($auth['contact_details'] ?? '-') ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($auth['status'] ?? '-') ?></p>
        <p><strong>Cazuri alocate:</strong>
          <?= isset($form_counts[$auth['name']]) ? $form_counts[$auth['name']] : 0 ?>
        </p>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>Nu există autorități înregistrate în acest moment.</p>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
