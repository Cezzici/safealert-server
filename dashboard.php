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
  <title>SafeAlert Dashboard</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #005bbb;
      color: white;
    }

    header {
      background-color: #003f88;
      padding: 20px;
      text-align: center;
      font-size: 28px;
      font-weight: bold;
    }

    .user-info {
      text-align: center;
      font-size: 16px;
      margin-top: -10px;
      margin-bottom: 10px;
    }

    nav {
      display: flex;
      background-color: #002855;
    }

    nav button {
      flex: 1;
      padding: 15px;
      font-size: 16px;
      background: none;
      border: none;
      color: white;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    nav button:hover,
    nav button.active {
      background-color: #004a9f;
    }

    #content {
      height: calc(100vh - 140px); /* header + user-info + nav */
      background-color: #f5f3f7;
    }

    iframe {
      width: 100%;
      height: 100%;
      border: none;
      background-color: transparent;
      display: block;
    }
  </style>
</head>
<body>

  <header>SafeAlert – Dashboard Central</header>

  <div class="user-info">
    Autentificat ca: <strong><?= htmlspecialchars($username) ?></strong> (<?= htmlspecialchars($role) ?>)
    | <a href="logout.php" style="color: #ffcccb; text-decoration: underline;">Logout</a>
  </div>

  <nav>
    <?php if ($role === 'admin'): ?>
      <button onclick="loadPage('view_all_forms.php', this)">Formulare Înregistrate</button>
      <button onclick="loadPage('view_authorities.php', this)">Lista Autorități</button>
      <button onclick="loadPage('intervention_view.php', this)">Intervenții</button>
      <button onclick="loadPage('view_interventions.php', this)">Lista Intervenții</button>
    <?php elseif ($role === 'authority'): ?>
      <button onclick="loadPage('view_alerts.php', this)">Alerte</button>
      <button onclick="loadPage('view_interventions.php', this)">Intervenții</button>
    <?php elseif ($role === 'ngo'): ?>
      <button onclick="loadPage('view_all_forms.php', this)">Formulare Înregistrate</button>
    <?php endif; ?>
  </nav>

  <div id="content">
    <iframe id="frame" src="welcome.php"></iframe>
  </div>

  <script>
    function loadPage(page, btn) {
      document.getElementById('frame').src = page;
      document.querySelectorAll('nav button').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
    }
  </script>

</body>
</html>
