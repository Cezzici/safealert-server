<?php
include 'header.php';
require_once 'db.php';

// Preluăm formularele ordonate descrescător după created_at
$result = $conn->query("SELECT * FROM forms ORDER BY created_at DESC");
?>

<div class="card">
  <h2>🗂️ Formulare înregistrate</h2>

  <div style="margin-bottom: 20px;">
    <a href="dashboard.php" style="background-color: #5e4283; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 500;">
      ⬅️ Înapoi la Dashboard
    </a>
  </div>

  <?php if ($result && $result->num_rows > 0): ?>
    <?php while ($form = $result->fetch_assoc()): ?>
      <div style="margin-bottom: 20px; padding: 15px; border-left: 5px solid #5e4283; background-color: #fdfdff; border-radius: 8px;">
        <p><strong>ID formular:</strong> <?= htmlspecialchars($form['form_id']) ?></p>
        <p><strong>Cod intern:</strong> <?= htmlspecialchars($form['code']) ?></p>
        <p><strong>Alertă asociată:</strong> <?= htmlspecialchars($form['alert_id'] ?? '-') ?></p>
        <p><strong>Locație:</strong> <?= htmlspecialchars($form['location']) ?></p>
        <p><strong>Gravitate:</strong> <?= htmlspecialchars($form['severity']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($form['status'] ?? '-') ?></p>
        <p><strong>Data completării:</strong> <?= htmlspecialchars($form['created_at']) ?></p>

        <div style="margin-top: 10px;">
          <a href="form_view.php?form_id=<?= $form['form_id'] ?>" style="margin-right: 15px;">🔍 Vezi formular</a>
          <a href="intervention_view.php?form_id=<?= $form['form_id'] ?>" style="margin-right: 15px;">🚑 Vezi intervenții</a>
          <a href="delete_form.php?form_id=<?= $form['form_id'] ?>"
             onclick="return confirm('Ești sigur că vrei să ștergi acest formular?');"
             style="color: red;">🗑️ Șterge formular</a>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>Nu există formulare înregistrate.</p>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
