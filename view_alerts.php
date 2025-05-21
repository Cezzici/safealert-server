<?php
require_once 'header.php';
require_once 'db.php';

// Preluăm alertele împreună cu numele din app_users (dacă există)
$sql = "SELECT a.*, u.name AS victim_name 
        FROM alerts a 
        LEFT JOIN app_users u ON a.user_id = u.uuid 
        ORDER BY a.created_at DESC";  // timestamp -> created_at
$result = $conn->query($sql);
?>

<div class="card">
  <h2>📨 Alerte primite</h2>

  <div style="margin-bottom: 20px;">
    <a href="dashboard.php" style="display: inline-block; background-color: #5e4283; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 500;">
      ⬅️ Înapoi la Dashboard
    </a>
  </div>

  <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div style="margin-bottom: 20px; padding: 15px; border-left: 5px solid #5e4283; background-color: #fdfdff; border-radius: 8px;">
        <p><strong>ID alertă:</strong> <?= htmlspecialchars($row['alert_id']) ?></p>
        <p><strong>Utilizator:</strong> <?= htmlspecialchars($row['victim_name'] ?? $row['user_id']) ?></p>
        <p><strong>Gravitate:</strong> <span style="color: <?= $row['severity'] >= 4 ? 'red' : '#5e4283' ?>;"><strong><?= $row['severity'] ?></strong></span></p>
        <p><strong>Data:</strong> <?= htmlspecialchars($row['created_at']) ?></p>
        <p><strong>Coordonate GPS:</strong> <?= htmlspecialchars($row['latitude']) ?>, <?= htmlspecialchars($row['longitude']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($row['status']) ?></p>
        <div style="margin-top: 10px;">
          <a href="form_view.php?alert_id=<?= $row['alert_id'] ?>">🔍 Vezi formular</a>
          &nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="intervention_view.php?alert_id=<?= $row['alert_id'] ?>">🚑 Vezi intervenție</a>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>Nu există alerte înregistrate.</p>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
