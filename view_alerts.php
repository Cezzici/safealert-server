<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
require_once 'db.php';

$result = $conn->query("SELECT * FROM alerts ORDER BY timestamp DESC");
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Alerte primite</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #f5f3f7;
    }

    h1 {
      color: #50276E;
      text-align: center;
      margin-bottom: 30px;
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
      padding: 14px;
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

    a.button {
      background-color: #7B3FA4;
      color: white;
      padding: 8px 14px;
      border: none;
      border-radius: 6px;
      text-decoration: none;
      font-size: 14px;
    }

    a.button:hover {
      background-color: #632f94;
    }

    .no-form {
      color: gray;
      font-style: italic;
    }
  </style>
</head>
<body>

  <h1>Alerte primite</h1>

  <table>
    <tr>
      <th>ID</th>
      <th>User</th>
      <th>Severitate</th>
      <th>Data</th>
      <th>Acțiune</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['user_id']) ?></td>
        <td><?= htmlspecialchars($row['severity']) ?></td>
        <td><?= htmlspecialchars($row['timestamp']) ?></td>
        <td>
          <?php
          $alertId = $row['id'];
          $stmtForm = $conn->prepare("SELECT id FROM forms WHERE alert_id = ?");
          $stmtForm->bind_param("i", $alertId);
          $stmtForm->execute();
          $resultForm = $stmtForm->get_result();
          $form = $resultForm->fetch_assoc();
          if ($form):
          ?>
            <a class="button" href="form_view.php?alert_id=<?= $alertId ?>">Deschide</a>
          <?php else: ?>
            <span class="no-form">Fără formular</span>
          <?php endif;
          $stmtForm->close();
          ?>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>

</body>
</html>
