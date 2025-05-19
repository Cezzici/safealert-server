<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
require_once 'db.php';

$result = $conn->query("SELECT * FROM forms ORDER BY timestamp DESC");
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Formulare Înregistrate</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      padding: 20px;
      background: #f5f3f7;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
    }
    th {
      background-color: #50276E;
      color: white;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    a.button {
      background-color: #7B3FA4;
      color: white;
      padding: 6px 12px;
      text-decoration: none;
      border-radius: 6px;
    }
  </style>
</head>
<body>

  <h1>Formulare Înregistrate</h1>

  <table>
    <tr>
      <th>ID</th>
      <th>Cod</th>
      <th>Locație</th>
      <th>Gravitate</th>
      <th>Dată</th>
      <th>Afișare</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['code']) ?></td>
      <td><?= htmlspecialchars($row['location']) ?></td>
      <td><?= htmlspecialchars($row['severity']) ?></td>
      <td><?= htmlspecialchars($row['timestamp']) ?></td>
      <td><a class="button" href="form_view.php?id=<?= $row['id'] ?>">Deschide</a></td>
    </tr>
    <?php endwhile; ?>
  </table>

</body>
</html>
