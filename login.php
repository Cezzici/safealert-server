<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Autentificare | SafeAlert</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      background: linear-gradient(to bottom right, #f5f2ff, #e5ddfa);
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-container {
      background-color: white;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      max-width: 400px;
      width: 90%;
      text-align: center;
    }

    .login-container img {
      width: 90px;
      margin-bottom: 20px;
    }

    h2 {
      margin-bottom: 30px;
      color: #5e4283;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
    }

    button {
      width: 100%;
      background-color: #5e4283;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
    }

    .error {
      background-color: #ffe4e4;
      color: #a00;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 8px;
    }

    @media (max-width: 500px) {
      .login-container {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

<div class="login-container">
  <img src="LOGO SAFEALERT.png" alt="SafeAlert Logo">

  <h2>Autentificare SafeAlert</h2>

  <?php if (isset($_GET['error'])): ?>
    <div class="error"><?= htmlspecialchars($_GET['error']) ?></div>
  <?php endif; ?>

  <form method="post" action="login_check.php">
    <input type="text" name="username" placeholder="Utilizator" required>
    <input type="password" name="password" placeholder="Parolă" required>
    <button type="submit">🔐 Conectează-te</button>
  </form>
</div>

</body>
</html>
