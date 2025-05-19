<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
require_once 'db.php';
$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Lista Intervenții – SafeAlert</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background-color: #f5f3f7;
    }

    header {
      background-color: #50276E;
      color: white;
      padding: 20px;
    }

    main {
      padding: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 0 10px rgba(80, 39, 110, 0.1);
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #7B3FA4;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>

<header>
  <strong>Lista Intervenții – SafeAlert</strong><br>
  Autentificat ca: <em><?= htmlspecialchars($username) ?></em> (<?= htmlspecialchars($role) ?>)
</header>

<main>
<?php
$query = "SELECT * FROM interventions ORDER BY timestamp DESC";
$result = $conn->query($query);

if (!$result) {
  echo "<p style='color:red;'>Eroare MySQL: " . $conn->error . "</p>";
  exit();
}

if ($result->num_rows > 0): ?>
  <table>
    <tr>
      <th>ID</th>
      <th>Formular ID</th>
      <th>Tip intervenție</th>
      <th>Responsabil</th>
      <th>Status</th>
      <th>Data</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['form_id'] ?></td>
        <td><?= htmlspecialchars($row['intervention_type']) ?></td>
        <td><?= htmlspecialchars($row['responsible_person']) ?></td>
        <td><?= htmlspecialchars($row['status']) ?></td>
        <td><?= $row['timestamp'] ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
<?php else: ?>
  <p>Nu există intervenții înregistrate.</p>
<?php endif; ?>
</main>

</body>
</html>
