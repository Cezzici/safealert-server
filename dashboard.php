<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Dashboard | SafeAlert</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      background: linear-gradient(135deg, #f5f2ff, #e5ddfa);
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      color: #333;
    }

    header {
      background-color: #5e4283;
      color: white;
      padding: 20px;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    header h1 {
      margin: 0;
      font-size: 2em;
    }

    .logout {
      text-align: right;
      padding: 10px 20px;
      background-color: #eee;
      font-size: 0.9em;
    }

    .logout span {
      margin-right: 10px;
    }

    .logout a {
      color: #5e4283;
      font-weight: bold;
      text-decoration: none;
    }

    .dashboard-container {
      max-width: 1200px;
      margin: 40px auto;
      padding: 0 20px;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
    }

    .card {
      background-color: white;
      border-radius: 16px;
      padding: 30px 20px;
      text-align: center;
      box-shadow: 0 8px 16px rgba(0,0,0,0.08);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 20px rgba(0,0,0,0.12);
    }

    .card a {
      text-decoration: none;
      font-size: 1.2em;
      color: #5e4283;
      font-weight: 600;
      display: block;
    }

    .card a::after {
      content: ' →';
      transition: 0.2s ease;
    }

    .card:hover a::after {
      margin-left: 5px;
    }

    footer {
      margin-top: 60px;
      text-align: center;
      color: #777;
      font-size: 0.9em;
      padding-bottom: 40px;
    }
  </style>
</head>
<body>

<header>
  <h1>📊 Panou de control SafeAlert</h1>
</header>

<div class="logout">
  <span>👤 Autentificat ca: <strong><?= htmlspecialchars($username) ?></strong> (<?= htmlspecialchars($role) ?>)</span>
  <a href="logout.php">Logout</a>
</div>

<div class="dashboard-container">
  <div class="grid">
    <div class="card">
      <a href="view_alerts.php">🚨 Vizualizează alertele</a>
    </div>
    <div class="card">
      <a href="view_forms.php">📄 Vizualizează formularele</a>
    </div>
    <div class="card">
      <a href="view_interventions.php">🛠️ Vizualizează intervențiile</a>
    </div>
    <div class="card">
      <a href="view_authorities.php">🏛️ Autorități și ONG-uri</a>
    </div>
  </div>
</div>

<footer>
  &copy; <?= date('Y') ?> SafeAlert • Toate drepturile rezervate
</footer>

</body>
</html>
