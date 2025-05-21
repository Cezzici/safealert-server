<?php
require_once 'header.php';
require_once 'db.php';

$form_id = $_GET['form_id'] ?? null;
$alert_id = $_GET['alert_id'] ?? null;

if ($form_id !== null) {
    $sql = "SELECT * FROM forms WHERE form_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $form_id);
} elseif ($alert_id !== null) {
    $sql = "SELECT * FROM forms WHERE alert_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $alert_id);
} else {
    echo "<p>Lipsă parametru: alert_id sau form_id.</p>";
    include 'footer.php';
    exit();
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>Formularul nu a fost găsit.</p>";
    include 'footer.php';
    exit();
}

$form = $result->fetch_assoc();

// Preluăm numele utilizatorului
$user_id = $form['user_id'];
$userName = "Necunoscut";

if ($user_id) {
    $userStmt = $conn->prepare("SELECT name FROM app_users WHERE user_id = ?");
    $userStmt->bind_param("i", $user_id);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    if ($userRow = $userResult->fetch_assoc()) {
        $userName = $userRow['name'];
    }
    $userStmt->close();
}
?>

<div class="card">
  <h2>📝 Formular detaliat</h2>
  <div style="margin-bottom: 20px;">
    <a href="view_alerts.php" style="display: inline-block; background-color: #5e4283; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 500;">
      ⬅️ Înapoi la Alerte
    </a>
  </div>

  <p><strong>ID formular:</strong> <?= htmlspecialchars($form['form_id']) ?></p>
  <p><strong>ID alertă asociată:</strong> <?= htmlspecialchars($form['alert_id']) ?></p>
  <p><strong>Utilizator:</strong> <?= htmlspecialchars($userName) ?></p>
  <p><strong>Gravitate:</strong> <?= htmlspecialchars($form['severity']) ?></p>
  <p><strong>Locație:</strong> <?= htmlspecialchars($form['location']) ?></p>
  <p><strong>Autoritate desemnată:</strong> <?= htmlspecialchars($form['authority_id']) ?></p>
  <p><strong>Stare formular:</strong> <?= htmlspecialchars($form['status']) ?></p>
  <p><strong>Mesaj/Detalii:</strong></p>
  <blockquote style="background: #f5f5f5; padding: 10px; border-radius: 4px;">
    <?= nl2br(htmlspecialchars($form['details'])) ?>
  </blockquote>
  <p><strong>Data completării:</strong> <?= htmlspecialchars($form['created_at']) ?></p>

  <div style="margin-top: 20px;">
    <a href="export_form_view.php?form_id=<?= htmlspecialchars($form['form_id']) ?>" style="background-color: #5e4283; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 500;">
      ⬇️ Exportă PDF formular
    </a>
  </div>
</div>

<hr style="margin: 30px 0;">
<h3 style="margin-top: 40px; font-size: 1.4em;">🛠️ Intervenție asociată</h3>

<?php
$interventionSql = "SELECT * FROM interventions WHERE form_id = ?";
$interventionStmt = $conn->prepare($interventionSql);
$interventionStmt->bind_param("i", $form['form_id']);
$interventionStmt->execute();
$interventionResult = $interventionStmt->get_result();
$interventionData = $interventionResult->fetch_assoc();
$interventionStmt->close();
?>

<div style="background-color: #f9f9ff; padding: 20px; border-radius: 12px; box-shadow: 0 0 10px rgba(94,66,131,0.1); margin-bottom: 40px;">
  <form method="post" action="save_intervention.php" style="margin-top: 10px;">
    <input type="hidden" name="form_id" value="<?= $form['form_id'] ?>">
    <?php if ($interventionData): ?>
      <input type="hidden" name="intervention_id" value="<?= $interventionData['intervention_id'] ?>">
    <?php endif; ?>

    <label><strong>Tip intervenție:</strong></label><br>
    <input type="text" name="intervention_type" value="<?= htmlspecialchars($interventionData['intervention_type'] ?? '') ?>" required style="width: 100%; padding: 8px; margin-bottom: 15px;"><br>

    <label><strong>Responsabil:</strong></label><br>
    <input type="text" name="responsible_person" value="<?= htmlspecialchars($interventionData['responsible_person'] ?? '') ?>" required style="width: 100%; padding: 8px; margin-bottom: 15px;"><br>

    <label><strong>Detalii:</strong></label><br>
    <textarea name="details" rows="4" required style="width: 100%; padding: 8px; margin-bottom: 15px;"><?= htmlspecialchars($interventionData['details'] ?? '') ?></textarea><br>

    <label><strong>Status:</strong></label><br>
    <select name="status" required style="width: 100%; padding: 8px; margin-bottom: 20px;">
      <option value="în desfășurare" <?= (isset($interventionData['status']) && $interventionData['status'] === 'în desfășurare') ? 'selected' : '' ?>>În desfășurare</option>
      <option value="finalizată" <?= (isset($interventionData['status']) && $interventionData['status'] === 'finalizată') ? 'selected' : '' ?>>Finalizată</option>
    </select>

    <button type="submit" style="background-color: #5e4283; color: white; padding: 10px 24px; border: none; border-radius: 8px; font-weight: 600;">💾 Salvează intervenția</button>
  </form>

  <?php if ($interventionData): ?>
    <div style="margin-top: 20px;">
      <a href="export_intervention_view.php?intervention_id=<?= $interventionData['intervention_id'] ?>" style="background-color: #5e4283; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 500;">
        ⬇️ Exportă PDF intervenție
      </a>
    </div>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

