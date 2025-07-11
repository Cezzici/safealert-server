<?php
include 'header.php';
require_once 'db.php';

$form_id = null;

// Căutăm form_id pornind de la alert_id (dacă e cazul)
if (isset($_GET['alert_id']) && is_numeric($_GET['alert_id'])) {
  $alert_id = (int)$_GET['alert_id'];
  $stmt = $conn->prepare("SELECT form_id FROM forms WHERE alert_id = ?");
  $stmt->bind_param("i", $alert_id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $form_id = $row['form_id'];
  }
} elseif (isset($_GET['form_id']) && is_numeric($_GET['form_id'])) {
  $form_id = (int)$_GET['form_id'];
}

if (!$form_id) {
  echo '<div class="card"><p>Formular inexistent sau parametru lipsă.</p></div>';
  include 'footer.php';
  exit();
}

// Preluăm toate intervențiile pentru formularul respectiv
$stmt = $conn->prepare("SELECT * FROM interventions WHERE form_id = ? ORDER BY created_at ASC");
$stmt->bind_param("i", $form_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="card">
  <h2>🚑 Intervenții asociate formularului #<?= htmlspecialchars($form_id) ?></h2>

  <div style="margin-bottom: 20px;">
    <a href="form_view.php?form_id=<?= $form_id ?>" style="margin-right: 12px; text-decoration: none;">🔙 Înapoi la formular</a>
    <a href="view_alerts.php" style="text-decoration: none;">⬅️ Înapoi la Alerte</a>
  </div>

  <?php if ($result->num_rows > 0): ?>
    <?php while ($interv = $result->fetch_assoc()): ?>
      <div style="margin-bottom: 20px; padding: 15px; border-left: 5px solid #5e4283; background-color: #fdfdff; border-radius: 8px;">
        <p><strong>ID intervenție:</strong> <?= htmlspecialchars($interv['intervention_id']) ?></p>
        <p><strong>Tip intervenție:</strong> <?= htmlspecialchars($interv['intervention_type']) ?></p>
        <p><strong>Responsabil:</strong> <?= htmlspecialchars($interv['responsible_person'] ?? '-') ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($interv['status'] ?? '-') ?></p>
        <p><strong>Data intervenției:</strong> <?= htmlspecialchars($interv['created_at']) ?></p>
        <p><strong>Detalii:</strong></p>
        <div style="background-color: #f8f6fb; padding: 10px; border-left: 4px solid #5e4283; border-radius: 6px;">
          <?= nl2br(htmlspecialchars($interv['details'] ?? 'Fara detalii')) ?>
        </div>

        <div style="margin-top: 12px;">
          <a href="delete_intervention.php?id=<?= $interv['intervention_id'] ?>"
             onclick="return confirm('Ești sigur că vrei să ștergi această intervenție?');"
             style="color: red; font-weight: bold;">🗑️ Șterge intervenția</a>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>Nu există intervenții asociate acestui formular.</p>
    <?php if (isset($form_id)): ?>
  <div style="margin-top: 30px; text-align: center;">
    <a href="add_intervention.php?form_id=<?= urlencode($form_id) ?>" 
       style="background-color: #7b2ff2; color: white; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-weight: bold;">
      ➕ Adaugă intervenție pentru acest formular
    </a>
  </div>
<?php endif; ?>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
