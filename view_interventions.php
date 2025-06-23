<?php
require_once 'header.php';
require_once 'db.php';

$role = $_SESSION['role'];
$authority_id = $_SESSION['authority_id'] ?? null;
$username = $_SESSION['username'];

// Select personalizat pe roluri
if ($role === 'admin') {
    $sql = "
        SELECT i.*, f.code AS form_code 
        FROM interventions i 
        LEFT JOIN forms f ON i.form_id = f.form_id 
        ORDER BY i.created_at DESC
    ";
} elseif ($role === 'authority') {
    $sql = "
        SELECT i.*, f.code AS form_code 
        FROM interventions i 
        LEFT JOIN forms f ON i.form_id = f.form_id 
        WHERE f.authority_id = '$authority_id'
        ORDER BY i.created_at DESC
    ";
} elseif ($role === 'ngo') {
    $sql = "
        SELECT i.*, f.code AS form_code 
        FROM interventions i 
        LEFT JOIN forms f ON i.form_id = f.form_id 
        WHERE i.responsible_person = '$username'
        ORDER BY i.created_at DESC
    ";
} else {
    // Rol necunoscut – protecție
    header('Location: dashboard.php');
    exit();
}

$result = $conn->query($sql);
?>

<div class="card">
  <h2>📋 Intervenții înregistrate</h2>

  <?php if ($result->num_rows > 0): ?>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
      <thead>
        <tr style="background-color: #5e4283; color: white;">
          <th style="padding: 10px;">Formular</th>
          <th style="padding: 10px;">Tip intervenție</th>
          <th style="padding: 10px;">Responsabil</th>
          <th style="padding: 10px;">Status</th>
          <th style="padding: 10px;">Data</th>
          <th style="padding: 10px;">Acțiune</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr style="border-bottom: 1px solid #ccc;">
            <td style="padding: 10px;"><?= htmlspecialchars($row['form_code'] ?? 'Fără cod') ?></td>
            <td style="padding: 10px;"><?= htmlspecialchars($row['intervention_type']) ?></td>
            <td style="padding: 10px;"><?= htmlspecialchars($row['responsible_person']) ?></td>
            <td style="padding: 10px;"><?= htmlspecialchars($row['status']) ?></td>
            <td style="padding: 10px;"><?= htmlspecialchars($row['created_at']) ?></td>
            <td style="padding: 10px;">
              <a href="form_view.php?form_id=<?= $row['form_id'] ?>" style="color: #5e4283; font-weight: bold;">🔍 Vizualizează</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
      <div style="text-align: right; margin-bottom: 20px;">
        <a href="dashboard.php" style="background-color: #7b2ff2; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: bold;">
          ⬅️ Înapoi la Dashboard
        </a>
      </div>
    </table>
  <?php else: ?>
    <p>Nu există intervenții înregistrate.</p>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
