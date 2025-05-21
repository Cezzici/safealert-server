<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

require_once 'db.php';

$username = $_SESSION['username'];
$role = $_SESSION['role'];
$authority_id = $_SESSION['authority_id'] ?? null;

// Redirect pentru authority/ngo
if ($role === 'authority') {
  header("Location: view_alerts.php");
  exit();
}
if ($role === 'ngo') {
  header("Location: view_forms.php");
  exit();
}

// Statistici doar pentru admin
if ($role === 'admin') {
  $stats = [];

  $stats['total_alerts'] = $conn->query("SELECT COUNT(*) FROM alerts")->fetch_row()[0];
  $stats['total_forms'] = $conn->query("SELECT COUNT(*) FROM forms")->fetch_row()[0];
  $stats['total_interventions'] = $conn->query("SELECT COUNT(*) FROM interventions")->fetch_row()[0];

  $stats['interventions_finalized'] = $conn->query("SELECT COUNT(*) FROM interventions WHERE status = 'finalizată'")->fetch_row()[0];
  $stats['interventions_open'] = $conn->query("SELECT COUNT(*) FROM interventions WHERE status = 'în desfășurare'")->fetch_row()[0];

  $stats['authorities'] = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'authority'")->fetch_row()[0];
  $stats['ngos'] = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'ngo'")->fetch_row()[0];
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Dashboard SafeAlert</title>
  <link rel="icon" type="image/png" href="LOGO SAFEALERT.PNG">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      background: linear-gradient(135deg, #f5f2ff, #e5ddfa);
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 40px;
    }

    h1 {
      text-align: center;
      margin-bottom: 40px;
      color: #5e4283;
    }

    .logout {
      text-align: right;
      margin-bottom: 20px;
    }

    .logout a {
      color: #5e4283;
      font-weight: bold;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 30px;
      max-width: 1000px;
      margin: 0 auto;
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

    .stats {
      max-width: 1000px;
      margin: 0 auto 40px auto;
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .stat-box {
      flex: 1;
      min-width: 200px;
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.07);
    }

    .stat-box h3 {
      color: #5e4283;
      margin: 0 0 10px;
    }

    .stat-box p {
      font-size: 1.4em;
      margin: 0;
    }
  </style>
</head>
<body>

<div class="logout">
  Autentificat ca: <?= htmlspecialchars($username) ?> (<?= htmlspecialchars($role) ?>) |
  <a href="logout.php">Logout</a>
</div>

<h1>📊 Panou de control SafeAlert</h1>


<?php if ($role === 'admin'): ?>
  <div class="stats">
    <div class="stat-box">
      <h3>📍 Total alerte</h3>
      <p><?= $stats['total_alerts'] ?></p>
    </div>
    <div class="stat-box">
      <h3>📄 Formulare</h3>
      <p><?= $stats['total_forms'] ?></p>
    </div>
    <div class="stat-box">
      <h3>🛠️ Intervenții</h3>
      <p><?= $stats['total_interventions'] ?></p>
      <p style="font-size: 0.9em; color: #555;">
        ✅ Finalizate: <?= $stats['interventions_finalized'] ?><br>
        🔄 În desfășurare: <?= $stats['interventions_open'] ?>
      </p>
    </div>
    <div class="stat-box">
      <h3>🏛️ Utilizatori</h3>
      <p style="font-size: 1.2em;">
        Autorități: <strong><?= $stats['authorities'] ?></strong><br>
        ONG-uri: <strong><?= $stats['ngos'] ?></strong>
      </p>
    </div>
  </div>
<?php endif; ?>

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

</body>
</html>
