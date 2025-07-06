<?php
include 'header.php';
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
    $sql .= " WHERE a.authority_id = ? ORDER BY a.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $authority_id);
} else {
    $sql .= " ORDER BY a.created_at DESC";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<style>
    .page-container { max-width: 1000px; margin: 0 auto; padding: 40px 20px; }
    .card { background-color: white; border-radius: 16px; padding: 30px 20px; box-shadow: 0 8px 16px rgba(0,0,0,0.08); }
    h2 { text-align: center; margin-bottom: 30px; color: #5e4283; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th { background-color: #5e4283; color: white; padding: 12px; font-size: 0.95em; }
    td { padding: 12px; text-align: center; border-bottom: 1px solid #ccc; }
    tr:hover { background-color: #f9f9f9; }
    a.action-link { color: #5e4283; text-decoration: none; font-weight: bold; }
    a.action-link:hover { text-decoration: underline; }
    .back-btn { background-color: #7b2ff2; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; }
    .back-btn:hover { background-color: #5e4283; }
</style>

<div class="page-container">
    <div class="card">
        <h2>🚨 Alerte înregistrate</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Utilizator</th>
                        <th>Gravitate</th>
                        <th>Locație</th>
                        <th>Autoritate</th>
                        <th>Dată</th>
                        <th>Status</th>
                        <th>Acțiune</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['user_name'] ?? 'Necunoscut') ?></td>
                            <td style="color: <?= $row['severity'] >= 4 ? 'red' : '#333' ?>;">
                                <strong><?= htmlspecialchars($row['severity']) ?></strong>
                            </td>
                            <td><?= htmlspecialchars($row['location']) ?></td>
                            <td><?= htmlspecialchars($row['authority_name'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td>
                                <a href="form_view.php?alert_id=<?= $row['alert_id'] ?>" class="action-link">🔍 Formular</a> |
                                <a href="intervention_view.php?alert_id=<?= $row['alert_id'] ?>" class="action-link">🛠️ Intervenție</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; margin-top: 20px;">Nu există alerte pentru această autoritate.</p>
        <?php endif; ?>

        <div style="text-align: right; margin-top: 30px;">
            <a href="dashboard.php" class="back-btn">⬅️ Înapoi la Dashboard</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
