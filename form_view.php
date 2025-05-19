<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
require_once 'db.php';

$alert_id = $_GET['alert_id'] ?? null;
$form_id = $_GET['id'] ?? null;

if ($alert_id) {
  $stmt = $conn->prepare("SELECT * FROM forms WHERE alert_id = ?");
  $stmt->bind_param("i", $alert_id);
} elseif ($form_id) {
  $stmt = $conn->prepare("SELECT * FROM forms WHERE id = ?");
  $stmt->bind_param("i", $form_id);
} else {
  echo "Formular inexistent.";
  exit();
}

$stmt->execute();
$result = $stmt->get_result();
$form = $result->fetch_assoc();

if (!$form) {
  echo "Formularul nu a fost găsit.";
  exit();
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Formular Generat Automat</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #f5f3f7;
      font-family: 'Segoe UI', sans-serif;
    }

    .container {
      max-width: 700px;
      margin: 50px auto;
      background-color: white;
      border-radius: 12px;
      padding: 40px;
      box-shadow: 0 0 15px rgba(80, 39, 110, 0.1);
    }

    h1 {
      color: #50276E;
      font-size: 26px;
      text-align: center;
      margin-bottom: 30px;
    }

    .label {
      font-weight: bold;
      margin-top: 20px;
      margin-bottom: 5px;
      color: #333;
    }

    .field {
      background-color: #f0f0f5;
      padding: 12px;
      border-radius: 8px;
      font-size: 16px;
      color: #222;
      border: 1px solid #ddd;
    }

    .field.large {
      min-height: 100px;
      white-space: pre-wrap;
    }

    textarea.field.large {
      width: 100%;
      resize: vertical;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Formular Generat Automat</h1>

    <div class="label">Cod Formular</div>
    <div class="field"><?= htmlspecialchars($form['code']) ?></div>

    <div class="label">Locație</div>
    <div class="field"><?= htmlspecialchars($form['location']) ?></div>

    <div class="label">Data și ora</div>
    <div class="field"><?= htmlspecialchars($form['timestamp']) ?></div>

    <div class="label">Nivel gravitate</div>
    <div class="field"><?= htmlspecialchars($form['severity']) ?></div>

    <div class="label">Detalii Situație</div>
    <div class="field large"><?= htmlspecialchars($form['details'] ?? '—') ?></div>

    <?php if ($_SESSION['role'] === 'authority'): ?>
    <form action="save_intervention.php" method="post" style="margin-top: 40px;">
      <input type="hidden" name="form_id" value="<?= htmlspecialchars($form['id']) ?>">

      <div class="label">Tip intervenție</div>
      <input type="text" name="intervention_type" class="field" required>

      <div class="label">Persoană responsabilă</div>
      <input type="text" name="responsible_person" class="field">

      <div class="label">Detalii intervenție</div>
      <textarea name="details" rows="4" class="field large"></textarea>

      <div class="label">Status intervenție</div>
      <select name="status" class="field" required>
        <option value="">Selectează status</option>
        <option value="Trimisă">Trimisă</option>
        <option value="În desfășurare">În desfășurare</option>
        <option value="Finalizată">Finalizată</option>
      </select>

      <div style="text-align: center; margin-top: 20px;">
        <button type="submit" style="background-color: #7B3FA4; color: white; border: none; padding: 10px 20px; font-size: 16px; border-radius: 8px; cursor: pointer;">
          Salvează intervenția
        </button>
      </div>
    </form>
    <?php endif; ?>

  </div>

</body>
</html>
