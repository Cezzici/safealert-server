<?php
require_once 'header.php';
require_once 'db.php';

$form = null;
$formId = null;

// Verificăm dacă a fost transmis un id sau alert_id
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $formId = (int)$_GET['id'];
  $stmt = $conn->prepare("SELECT * FROM forms WHERE id = ?");
  $stmt->bind_param("i", $formId);
} elseif (isset($_GET['alert_id']) && is_numeric($_GET['alert_id'])) {
  $alertId = (int)$_GET['alert_id'];
  $stmt = $conn->prepare("SELECT * FROM forms WHERE alert_id = ?");
  $stmt->bind_param("i", $alertId);
} else {
  echo "<div class='card'><p>ID formular invalid.</p></div>";
  include 'footer.php';
  exit();
}

$stmt->execute();
$result = $stmt->get_result();
if ($result && $result->num_rows > 0) {
  $form = $result->fetch_assoc();
  $formId = $form['id'];
} else {
  echo "<div class='card'><p>Formularul nu a fost găsit.</p></div>";
  include 'footer.php';
  exit();
}
?>

<div class="card">
  <h2>📝 Formular detaliat</h2>

  <div style="margin-bottom: 20px;">
    <a href="view_alerts.php" style="display: inline-block; background-color: #5e4283; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 500;">
      ⬅️ Înapoi la Alerte
    </a>
    <a href="add_intervention.php?form_id=<?= $form['id'] ?>">➕ Adaugă intervenție</a>
  </div>

  <p><strong>ID formular:</strong> <?= htmlspecialchars($form['id']) ?></p>
  <p><strong>ID alertă asociată:</strong> <?= htmlspecialchars($form['alert_id']) ?></p>
  <p><strong>Cod intern:</strong> <?= htmlspecialchars($form['code']) ?></p>
  <p><strong>Utilizator:</strong> <?= htmlspecialchars($form['user_id']) ?></p>
  <p><strong>Gravitate:</strong> <?= htmlspecialchars($form['severity']) ?></p>
  <p><strong>Locație:</strong> <?= htmlspecialchars($form['location']) ?></p>
  <p><strong>Autoritate desemnată:</strong> <?= htmlspecialchars($form['autoritate']) ?></p>
  <p><strong>Stare formular:</strong> <?= htmlspecialchars($form['status']) ?></p>
  <p><strong>Mesaj/Detalii:</strong></p>
  <div style="background-color: #f8f6fb; padding: 10px; border-left: 4px solid #5e4283; border-radius: 6px;">
    <?= nl2br(htmlspecialchars($form['details'])) ?>
  </div>
  <p><strong>Data completării:</strong> <?= htmlspecialchars($form['timestamp']) ?></p>

  <?php if (file_exists('export_form_view.php')): ?>
    <div style="margin-top: 20px;">
      <a href="export_form_view.php?id=<?= $form['id'] ?>" target="_blank" style="background-color: #5e4283; color: white; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: bold;">⬇️ Exportă PDF</a>
    </div>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
