<?php
require_once 'header.php';
require_once 'db.php';

if ($_SESSION['role'] != 'admin') {
    header('Location: dashboard.php');
    exit();
}

// Aprobare cont
if (isset($_GET['approve'])) {
    $userId = intval($_GET['approve']);
    $stmt = $conn->prepare("SELECT * FROM pending_users WHERE pending_user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $insert = $conn->prepare("INSERT INTO users (username, password_hash, role, authority_id, email) VALUES (?, ?, ?, ?, ?)");

        if ($insert === false) {
            die("Eroare SQL la inserare: " . $conn->error);
        }

        $insert->bind_param("sssss", $user['username'], $user['password_hash'], $user['role'], $user['authority_id'], $user['email']);
        $insert->execute();

        $delete = $conn->prepare("DELETE FROM pending_users WHERE pending_user_id = ?");
        $delete->bind_param("i", $userId);
        $delete->execute();
    }

    header('Location: manage_pending_users.php');
    exit();
}

// Respingere cont
if (isset($_GET['reject'])) {
    $userId = intval($_GET['reject']);
    $delete = $conn->prepare("DELETE FROM pending_users WHERE pending_user_id = ?");
    $delete->bind_param("i", $userId);
    $delete->execute();

    header('Location: manage_pending_users.php');
    exit();
}

// Selectăm utilizatorii pending
$pending = $conn->query("SELECT * FROM pending_users ORDER BY pending_user_id DESC");
?>

<h2>👥 Conturi în așteptare</h2>

<?php if ($pending && $pending->num_rows > 0): ?>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #5e4283; color: white;">
                <th style="padding: 10px;">Username</th>
                <th style="padding: 10px;">Email</th>
                <th style="padding: 10px;">Rol</th>
                <th style="padding: 10px;">Autoritate</th>
                <th style="padding: 10px;">Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $pending->fetch_assoc()): ?>
                <tr style="border-bottom: 1px solid #ccc;">
                    <td style="padding: 10px;"><?= htmlspecialchars($user['username']) ?></td>
                    <td style="padding: 10px;"><?= htmlspecialchars($user['email']) ?></td>
                    <td style="padding: 10px;"><?= htmlspecialchars($user['role']) ?></td>
                    <td style="padding: 10px;"><?= htmlspecialchars($user['authority_id']) ?></td>
                    <td style="padding: 10px;">
                        <a href="manage_pending_users.php?approve=<?= $user['pending_user_id'] ?>" style="background-color: green; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; margin-right: 10px;">✅ Aproba</a>
                        <a href="manage_pending_users.php?reject=<?= $user['pending_user_id'] ?>" style="background-color: red; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none;" onclick="return confirm('Sigur vrei să respingi acest cont?');">❌ Respingere</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php elseif ($pending && $pending->num_rows == 0): ?>
    <p style="font-weight: bold; color: green;">Nu există conturi în așteptare.</p>
<?php else: ?>
    <p style="color: red; font-weight: bold;">Eroare la interogarea bazei de date.</p>
<?php endif; ?>

<div style="text-align: right; margin-top: 20px;">
    <a href="dashboard.php" style="background-color: #7b2ff2; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: bold;">
        ⬅️ Înapoi la Dashboard
    </a>
</div>

<?php include 'footer.php'; ?>
