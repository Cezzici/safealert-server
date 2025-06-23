<?php
include 'header.php';
require_once 'db.php';

// Procesăm ștergerea
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_authority_id']) && !isset($_SESSION['deletion_in_progress'])) {
    $_SESSION['deletion_in_progress'] = true; // Blochez ștergeri multiple

    $delete_id = $_POST['delete_authority_id']; // Fără intval, ID-ul e string

    $check = $conn->prepare("SELECT * FROM authorities WHERE authority_id = ?");
    $check->bind_param("s", $delete_id); // "s" pentru string
    $check->execute();
    $result_check = $check->get_result();

    if ($result_check && $result_check->num_rows > 0) {
        $delete = $conn->prepare("DELETE FROM authorities WHERE authority_id = ?");
        $delete->bind_param("s", $delete_id); // "s" pentru string
        if ($delete->execute()) {
            header("Location: view_authorities.php?msg=deleted");
            unset($_SESSION['deletion_in_progress']); // Deblochez sesiunea
            exit();
        } else {
            $error = "Eroare la ștergerea autorității.";
        }
    } else {
        $error = "Autoritatea nu există.";
    }

    unset($_SESSION['deletion_in_progress']); // Siguranță extra
}

// Grupăm câte formulare are fiecare autoritate pe baza authority_id
$form_counts = [];
$sql = "
  SELECT f.authority_id, COUNT(*) as total 
  FROM forms f
  GROUP BY f.authority_id
";
$q = $conn->query($sql);
while ($row = $q->fetch_assoc()) {
  $form_counts[$row['authority_id']] = $row['total'];
}

// Preluăm toate autoritățile
$result = $conn->query("SELECT * FROM authorities ORDER BY region ASC, name ASC");
?>

<div class="card">
  <h2>🏢 Autorități înregistrate în sistem</h2>

  <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
    <a href="dashboard.php" style="background-color: #5e4283; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 500;">
      ⬅️ Înapoi la Dashboard
    </a>

    <?php if ($_SESSION['role'] === 'admin'): ?>
      <a href="manage_authorities.php" style="background-color: #4CAF50; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 500;">
        ➕ Adaugă autoritate
      </a>
    <?php endif; ?>
  </div>

  <?php
  if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
      echo "<p style='color: green; font-weight: bold;'>Autoritatea a fost ștearsă cu succes!</p>";
  }

  if (isset($error)) {
      echo "<p style='color: red; font-weight: bold;'>$error</p>";
  }
  ?>

  <?php if ($result && $result->num_rows > 0): ?>
    <?php while ($auth = $result->fetch_assoc()): ?>
      <div style="margin-bottom: 20px; padding: 15px; border-left: 5px solid #5e4283; background-color: #fdfdff; border-radius: 8px;">
        <p><strong>ID intern:</strong> <?= htmlspecialchars($auth['authority_id']) ?></p>
        <p><strong>Nume autoritate:</strong> <?= htmlspecialchars($auth['name']) ?></p>
        <p><strong>Tip:</strong> <?= htmlspecialchars($auth['type'] ?? '-') ?></p>
        <p><strong>Regiune:</strong> <?= htmlspecialchars($auth['region'] ?? '-') ?></p>
        <p><strong>Persoană contact:</strong> <?= htmlspecialchars($auth['contact_person'] ?? '-') ?></p>
        <p><strong>Date contact:</strong> <?= htmlspecialchars($auth['contact_details'] ?? '-') ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($auth['status'] ?? '-') ?></p>
        <p><strong>Cazuri alocate:</strong>
          <?= isset($form_counts[$auth['authority_id']]) ? $form_counts[$auth['authority_id']] : 0 ?>
        </p>

        <?php if ($_SESSION['role'] === 'admin'): ?>
          <form method="POST" action="view_authorities.php" onsubmit="return confirm('Ești sigur că vrei să ștergi această autoritate?');" style="margin-top: 10px;">
              <input type="hidden" name="delete_authority_id" value="<?= $auth['authority_id'] ?>">
              <button type="submit" style="background-color: red; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;" onclick="this.disabled=true; this.form.submit();">
                  🗑️ Șterge autoritate
              </button>
          </form>
        <?php endif; ?>

      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>Nu există autorități înregistrate în acest moment.</p>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
