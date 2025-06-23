<?php
include 'header.php';
require_once 'db.php';

if (!in_array($_SESSION['role'], ['admin', 'authority'])) {
  echo '<div class="card"><p>Acces interzis.</p></div>';
  include 'footer.php';
  exit();
}

$form_id = isset($_GET['form_id']) ? (int)$_GET['form_id'] : 0;

if ($form_id <= 0) {
  echo '<div class="card"><p>Formular inexistent.</p></div>';
  include 'footer.php';
  exit();
}

// Dacă se trimite formularul POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $type = trim($_POST['intervention_type']);
  $responsible = trim($_POST['responsible_person']);
  $details = trim($_POST['details']);
  $status = trim($_POST['status']);

  $stmt = $conn->prepare("
    INSERT INTO interventions (form_id, intervention_type, responsible_person, details, status, created_at)
    VALUES (?, ?, ?, ?, ?, NOW())
  ");

  if (!$stmt) {
    die("Eroare la prepare(): " . $conn->error);
  }

  $stmt->bind_param("issss", $form_id, $type, $responsible, $details, $status);
  $stmt->execute();

  header("Location: intervention_view.php?form_id=$form_id");
  exit();
}
?>

<div class="card">
  <h2>➕ Adaugă intervenție</h2>
  <form method="post">
    <label>Tip intervenție:</label><br>
    <input type="text" name="intervention_type" required style="width:100%; padding:8px; margin-bottom:10px;"><br>

    <label>Persoană responsabilă:</label><br>
    <input type="text" name="responsible_person" required style="width:100%; padding:8px; margin-bottom:10px;"><br>

    <label>Status intervenție:</label><br>
    <input type="text" name="status" value="În desfășurare" required style="width:100%; padding:8px; margin-bottom:10px;"><br>

    <label>Detalii:</label><br>
    <textarea name="details" rows="4" style="width:100%; padding:8px; margin-bottom:10px;"></textarea><br>

    <input type="submit" value="Salvează intervenția" style="background-color:#5e4283; color:white; padding:10px 20px; border:none; border-radius:6px; font-weight:bold;">
  </form>

  <div style="margin-top: 20px;">
    <a href="intervention_view.php?form_id=<?= $form_id ?>" style="text-decoration:none;">⬅️ Înapoi la intervenții</a>
  </div>
</div>

<?php include 'footer.php'; ?>
