<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
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
  <title>Autorități – SafeAlert</title>
  <style>
    body { font-family: 'Segoe UI', sans-serif; margin: 0; background-color: #f5f3f7; }
    header { background-color: #50276E; color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
    header div { display: flex; flex-direction: column; }
    header a { color: #ccf; text-decoration: underline; margin-left: 20px; font-size: 14px; }
    header a:last-child { color: #f99; }
    main { padding: 30px; }
    table { width: 100%; border-collapse: collapse; background-color: white; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
    th { background-color: #7B3FA4; color: white; }
    tr:nth-child(even) { background-color: #f2f2f2; }
  </style>
</head>
<body>

<header>
  <div>
    <strong>Lista Autorități – SafeAlert</strong>
    <span>Autentificat ca: <em><?= htmlspecialchars($username) ?></em> (<?= $role ?>)</span>
  </div>
  <div>
    <a href="dashboard.php">Dashboard</a>
    <a href="logout.php">Logout</a>
  </div>
</header>

<main>
  <?php
  $result = $conn->query("SELECT * FROM authorities ORDER BY name ASC");
  if ($result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Nume</th><th>Detalii contact</th></tr>";
    while ($row = $result->fetch_assoc()) {
      echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['contact_details']}</td></tr>";
    }
    echo "</table>";
  } else {
    echo "<p>Nu există autorități înregistrate.</p>";
  }
  ?>
</main>

</body>
</html>
