<?php
include 'header.php';
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_authority_id']) && !isset($_SESSION['deletion_in_progress'])) {
    $_SESSION['deletion_in_progress'] = true;

    $delete_id = $_POST['delete_authority_id'];

    $check = $conn->prepare("SELECT * FROM authorities WHERE authority_id = ?");
    $check->bind_param("s", $delete_id);
    $check->execute();
    $result_check = $check->get_result();

    if ($result_check && $result_check->num_rows > 0) {
        $delete = $conn->prepare("DELETE FROM authorities WHERE authority_id = ?");
        $delete->bind_param("s", $delete_id);
        if ($delete->execute()) {
            header("Location: view_authorities.php?msg=deleted");
            unset($_SESSION['deletion_in_progress']);
            exit();
        } else {
            $error = "Eroare la ștergerea autorității.";
        }
    } else {
        $error = "Autoritatea nu există.";
    }

    unset($_SESSION['deletion_in_progress']);
}

// Calculăm câte formulare are fiecare autoritate
$form_counts = [];
$sql = "SELECT f.authority_id, COUNT(*) as total FROM forms f GROUP BY f.authority_id";
$q = $conn->query($sql);
while ($row = $q->fetch_assoc()) {
    $form_counts[$row['authority_id']] = $row['total'];
}

$result = $conn->query("SELECT * FROM authorities ORDER BY region ASC, name ASC");
?>

<style>
    .page-container { max-width: 1000px; margin: 0 auto; padding: 40px 20px; }
    .card { background-color: white; border-radius: 16px; padding: 30px 20px; box-shadow: 0 8px 16px rgba(0,0,0,0.08); }
    h2 { text-align: center; margin-bottom: 30px; color: #5e4283; }
    .authority-card { margin-bottom: 20px; padding: 20px; border-left: 5px solid #5e4283; background-color: #fdfdff; border-radius: 8px; transition: box-shadow 0.3s ease; }
    .authority-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.12); }
    .authority-card p { margin: 6px 0; }
    .back-btn, .add-btn { padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; color: white; }
    .back-btn { background-color: #7b2ff2; }
    .back-btn:hover { background-color: #5e4283; }
    .add-btn { background-color: #4CAF50; }
    .add-btn:hover { background-color: #3b9140; }
    .delete-btn { background-color: red; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
    .delete-btn:hover { background-color: darkred; }
</style>

<div class="page-container">
    <div class="card">
        <h2>🏢 Autorități înregistrate în sistem</h2>

        <div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
            <a href="dashboard.php" class="back-btn">⬅️ Înapoi la Dashboard</a>

            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="manage_authorities.php" class="add-btn">➕ Adaugă autoritate</a>
            <?php endif; ?>
        </div>

        <?php
        if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
            echo "<p style='color: green; font-weight: bold; text-align: center;'>Autoritatea a fost ștearsă cu succes!</p>";
        }

        if (isset($error)) {
            echo "<p style='color: red; font-weight: bold; text-align: center;'>$error</p>";
        }
        ?>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($auth = $result->fetch_assoc()): ?>
                <div class="authority-card">
                    <p><strong>ID intern:</strong> <?= htmlspecialchars($auth['authority_id']) ?></p>
                    <p><strong>Nume autoritate:</strong> <?= htmlspecialchars($auth['name']) ?></p>
                    <p><strong>Tip:</strong> <?= htmlspecialchars($auth['type'] ?? '-') ?></p>
                    <p><strong>Regiune:</strong> <?= htmlspecialchars($auth['region'] ?? '-') ?></p>
                    <p><strong>Persoană contact:</strong> <?= htmlspecialchars($auth['contact_person'] ?? '-') ?></p>
                    <p><strong>Date contact:</strong> <?= htmlspecialchars($auth['contact_details'] ?? '-') ?></p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($auth['status'] ?? '-') ?></p>
                    <p><strong>Cazuri alocate:</strong> <?= isset($form_counts[$auth['authority_id']]) ? $form_counts[$auth['authority_id']] : 0 ?></p>

                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <form method="POST" action="view_authorities.php" onsubmit="return confirm('Ești sigur că vrei să ștergi această autoritate?');" style="margin-top: 10px;">
                            <input type="hidden" name="delete_authority_id" value="<?= $auth['authority_id'] ?>">
                            <button type="submit" class="delete-btn" onclick="this.disabled=true; this.form.submit();">🗑️ Șterge autoritate</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center;">Nu există autorități înregistrate în acest moment.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
