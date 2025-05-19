<?php
require_once 'header.php';
require_once 'db.php';

$result = $conn->query("SELECT * FROM forms ORDER BY timestamp DESC");
?>

<div class="card">
  <h2>🗂️ Formulare înregistrate</h2>

  <div style="margin-top: 10px;">
    <a href="form_view.php?id=<?= $form['id'] ?>">🔍 Vezi formular</a>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="intervention_view.php?form_id=<?= $form['id'] ?>">🚑 Vezi intervenții</a>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="delete_form.php?id=<?= $form['id'] ?>" onclick="return confirm('Ești sigur că vrei să ștergi acest formular?');" style="color: red;">🗑️ Șterge</a>
  </div>

  <?php if ($result && $result->num_rows > 0): ?>
    <?php while ($form = $result->fetch_assoc()): ?>
      <div style="margin-bottom: 20px; padding: 15px; border-left: 5px solid #5e4283; background-color: #fdfdff; border-radius: 8px;">
        <p><strong>ID formular:</strong> <?= htmlspecialchars($form['id']) ?></p>
        <p><strong>Cod intern:</strong> <?= htmlspecialchars($form['code']) ?></p>
        <p><strong>Alertă asociată:</strong> <?= htmlspecialchars($form['alert_id'] ?? '-') ?></p>
        <p><strong>Locație:</strong> <?= htmlspecialchars($form['location']) ?></p>
        <p><strong>Gravitate:</strong> <?= htmlspecialchars($form['severity']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($form['status'] ?? '-') ?></p>
        <p><strong>Data completării:</strong> <?= htmlspecialchars($form['timestamp']) ?></p>
        <div style="margin-top: 10px;">
          <a href="form_view.php?id=<?= $form['id'] ?>">🔍 Vezi formular</a>
          &nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="intervention_view.php?form_id=<?= $form['id'] ?>">🚑 Vezi intervenții</a>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>Nu există formulare înregistrate.</p>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
