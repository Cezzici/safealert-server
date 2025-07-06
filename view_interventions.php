<?php
require_once 'header.php';
require_once 'db.php';

$role = $_SESSION['role'];
$authority_id = $_SESSION['authority_id'] ?? null;
$username = $_SESSION['username'];

$stmt = null;

if ($role === 'admin') {
    $sql = "
        SELECT i.*, f.code AS form_code 
        FROM interventions i 
        LEFT JOIN forms f ON i.form_id = f.form_id 
        ORDER BY i.created_at DESC
    ";
    $stmt = $conn->prepare($sql);
} elseif ($role === 'authority') {
    $sql = "
        SELECT i.*, f.code AS form_code 
        FROM interventions i 
        LEFT JOIN forms f ON i.form_id = f.form_id 
        WHERE f.authority_id = ?
        ORDER BY i.created_at DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $authority_id);
} elseif ($role === 'ngo') {
    $sql = "
        SELECT i.*, f.code AS form_code 
        FROM interventions i 
        LEFT JOIN forms f ON i.form_id = f.form_id 
        WHERE i.responsible_person = ?
        ORDER BY i.created_at DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
} else {
    header('Location: dashboard.php');
    exit();
}

$stmt->execute();
$result = $stmt->get_result();
?>

<style>
    .page-container { max-width: 1000px; margin: 0 auto; padding: 40px 20px; }
    .card { background-color: white; border-radius: 16px; padding: 30px 20px; box-shadow: 0 8px 16px rgba(0,0,0,0.08); }
    h2 { text-align: center; margin-bottom: 30px; color: #5e4283; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
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
        <h2>📋 Intervenții înregistrate</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Formular</th>
                        <th>Tip intervenție</th>
                        <th>Responsabil</th>
                        <th>Status</th>
                        <th>Data</th>
                        <th>Acțiune</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['form_code'] ?? 'Fără cod') ?></td>
                            <td><?= htmlspecialchars($row['intervention_type']) ?></td>
                            <td><?= htmlspecialchars($row['responsible_person']) ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td>
                                <a href="form_view.php?form_id=<?= $row['form_id'] ?>" class="action-link">🔍 Vizualizează</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; margin-top: 20px;">Nu există intervenții înregistrate.</p>
        <?php endif; ?>

        <div style="text-align: right; margin-top: 30px;">
            <a href="dashboard.php" class="back-btn">⬅️ Înapoi la Dashboard</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
