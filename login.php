<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit();
}

$login_error = isset($_GET['error']) ? true : false;
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>SafeAlert - Autentificare</title>
  <link rel="icon" href="LOGO SAFEALERT.png">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f2f0f7;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .login-box {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      padding: 40px;
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    .login-box img {
      height: 60px;
      margin-bottom: 20px;
    }

    .login-box h2 {
      margin-bottom: 25px;
      color: #5e4283;
    }

    .login-box input[type="text"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 15px;
    }

    .login-box input[type="submit"] {
      background-color: #5e4283;
      color: white;
      border: none;
      padding: 12px;
      width: 100%;
      font-weight: bold;
      font-size: 15px;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 10px;
    }

    .login-box input[type="submit"]:hover {
      background-color: #4a3570;
    }

    .error-msg {
      background-color: #ffe6e6;
      color: #b30000;
      border-left: 4px solid #b30000;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 6px;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <img src="LOGO SAFEALERT.png" alt="SafeAlert Logo" style="height: 110px; margin-bottom: 25px;">
    <h2>Autentificare</h2>

    <?php if ($login_error): ?>
      <div class="error-msg">Date de autentificare incorecte. Încearcă din nou.</div>
    <?php endif; ?>

    <form method="post" action="login_check.php">
      <input type="text" name="username" placeholder="Utilizator" required>
      <input type="password" name="password" placeholder="Parolă" required>
      <input type="submit" value="Conectează-te">
    </form>
  </div>
</body>
</html>
