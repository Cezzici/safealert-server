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
  <title>Bine ai venit – SafeAlert</title>
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      width: 100%;
      background-color: transparent;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      box-sizing: border-box;
    }

    .box {
      background-color: white;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 0 15px rgba(80, 39, 110, 0.1);
      text-align: center;
      max-width: 480px;
      width: 90%;
      animation: fadeIn 0.4s ease-out;
    }

    h1 {
      color: #50276E;
      margin-bottom: 10px;
      font-size: 24px;
    }

    p {
      font-size: 18px;
      color: #333;
      margin: 10px 0;
    }

    strong {
      color: #7B3FA4;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

  <div class="box">
    <h1>Bine ai venit, <?= htmlspecialchars($username) ?>!</h1>
    <p>Rolul tău este: <strong><?= htmlspecialchars($role) ?></strong></p>
    <p>Selectează o secțiune din meniul de sus pentru a începe.</p>
  </div>

</body>
</html>
