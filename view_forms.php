<?php
require_once 'header.php';
require_once 'db.php';

if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'authority') {
    header('Location: dashboard.php');
    exit();
}

$role = $_SESSION['role'];
$authority_id = $_SESSION['authority_id'];

if ($role === 'admin') {
    $result = $conn->query("
        SELECT f.*, a.name AS authority_name, u.name AS user_name
        FROM forms f
        LEFT JOIN app_users u ON f.user_id = u.user_id
        LEFT JOIN authorities a ON f.authority_id = a.authority_id
        ORDER BY f.created_at DESC
    ");
} else {
    $stmt = $conn->prepare("
        SELECT f.*, a.name AS authority_name, u.name AS user_name
        FROM forms f
        LEFT JOIN app_users u ON f.user_id = u.user_id
        LEFT JOIN authorities a ON f.authority_id = a.authority_id
        WHERE f.authority_id = ?
        ORDER BY f.created_at DESC
    ");
    $stmt->bind_param("s", $authority_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<div class="card">
  <h2>📄 Formulare înregistrate</h2>

  <?php if ($result && $result->num_rows > 0): ?>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
      <thead>
        <tr style="background-color: #5e4283; color: white;">
          <th style="padding: 10px;">Cod</th>
          <th style="padding: 10px;">Utilizator</th>
          <th style="padding: 10px;">Locație</th>
          <th style="padding: 10px;">Stare</th>
          <th style="padding: 10px;">Dată</th>
          <th style="padding: 10px;">Acțiune</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr style="border-bottom: 1px solid #ccc;">
            <td style="padding: 10px;"><?= htmlspecialchars($row['code']) ?></td>
            <td style="padding: 10px;"><?= htmlspecialchars($row['user_name'] ?? 'Necunoscut') ?></td>
            <td style="padding: 10px;"><?= htmlspecialchars($row['location']) ?></td>
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
    <p>Nu există formulare înregistrate.</p>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
