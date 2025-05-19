<?php
require_once 'header.php';
require_once 'db.php';

$result = $conn->query("SELECT * FROM interventions ORDER BY timestamp DESC");
?>

<div class="card">
  <h2>📋 Toate intervențiile înregistrate</h2>

  <div style="margin-bottom: 20px;">
    <a href="dashboard.php" style="display: inline-block; background-color: #5e4283; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 500;">
      ⬅️ Înapoi la Dashboard
    </a>
  </div>

  <?php if ($result && $result->num_rows > 0): ?>
    <?php while ($interv = $result->fetch_assoc()): ?>
      <div style="margin-bottom: 20px; padding: 15px; border-left: 5px solid #5e4283; background-color: #fdfdff; border-radius: 8px;">
        <p><strong>ID intervenție:</strong> <?= htmlspecialchars($interv['id']) ?></p>
        <p><strong>Formular asociat:</strong>
          <a href="form_view.php?id=<?= $interv['form_id'] ?>">#<?= $interv['form_id'] ?></a>
        </p>
        <p><strong>Tip intervenție:</strong> <?= htmlspecialchars($interv['intervention_type']) ?></p>
        <p><strong>Responsabil:</strong> <?= htmlspecialchars($interv['responsible_person'] ?? '-') ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($interv['status'] ?? '-') ?></p>
        <p><strong>Dată intervenție:</strong> <?= htmlspecialchars($interv['timestamp']) ?></p>
        <p><strong>Detalii:</strong></p>
        <div style="background-color: #f8f6fb; padding: 10px; border-left: 4px solid #5e4283; border-radius: 6px;">
          <?= nl2br(htmlspecialchars($interv['details'] ?? 'Fara detalii')) ?>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>Nu există intervenții înregistrate.</p>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
