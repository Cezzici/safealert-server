<?php
require_once 'header.php';
require_once 'db.php';

$role = $_SESSION['role'] ?? '';
$authority_id = $_SESSION['authority_id'] ?? null;

$sql = "
    SELECT a.*, u.name AS user_name, au.name AS authority_name 
    FROM alerts a
    LEFT JOIN app_users u ON a.user_id = u.uuid
    LEFT JOIN authorities au ON a.authority_id = au.authority_id
";

// Filtru doar pentru authority/ngo
if ($role === 'authority' || $role === 'ngo') {
    $sql .= " WHERE a.authority_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $authority_id);
} else {
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<div class="card">
  <h2>🚨 Alerte înregistrate</h2>

  <?php if ($result->num_rows > 0): ?>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
      <thead>
        <tr style="background-color: #5e4283; color: white;">
          <th style="padding: 10px;">Utilizator</th>
          <th style="padding: 10px;">Gravitate</th>
          <th style="padding: 10px;">Locație</th>
          <th style="padding: 10px;">Autoritate</th>
          <th style="padding: 10px;">Dată</th>
          <th style="padding: 10px;">Status</th>
          <th style="padding: 10px;">Acțiune</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr style="border-bottom: 1px solid #ccc;">
            <td style="padding: 10px;"><?= htmlspecialchars($row['user_name'] ?? 'Necunoscut') ?></td>
            <td style="padding: 10px; color: <?= $row['severity'] >= 4 ? 'red' : '#333' ?>;"><strong><?= htmlspecialchars($row['severity']) ?></strong></td>
            <td style="padding: 10px;"><?= htmlspecialchars($row['location']) ?></td>
            <td style="padding: 10px;"><?= htmlspecialchars($row['authority_name'] ?? 'N/A') ?></td>
            <td style="padding: 10px;"><?= htmlspecialchars($row['created_at']) ?></td>
            <td style="padding: 10px;"><?= htmlspecialchars($row['status']) ?></td>
            <td style="padding: 10px;">
              <a href="form_view.php?alert_id=<?= $row['alert_id'] ?>" style="color: #5e4283;">🔍 Formular</a>
              |
              <a href="intervention_view.php?alert_id=<?= $row['alert_id'] ?>" style="color: #5e4283;">🛠️ Intervenție</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Nu există alerte pentru această autoritate.</p>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
