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
  <meta charset="UTF-8" />
  <title>Autentificare | SafeAlert</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
      position: relative;
      z-index: 10;
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
    input[type="password"],
    input[type="email"],
    select {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
      box-sizing: border-box;
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
      margin-bottom: 10px;
    }

    .error {
      background-color: #ffe4e4;
      color: #a00;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 8px;
    }

    #btnSignUp {
      background-color: #7b2ff2;
      margin-top: 10px;
    }

  
    #signupModal {
      display: none;
      position: fixed;
      top: 10%;
      left: 50%;
      transform: translateX(-50%);
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
      max-width: 400px;
      z-index: 1000;
      overflow-y: auto;
      max-height: 80vh;
    }

    #signupModal h2 {
      color: #5e4283;
      margin-top: 0;
    }

    #btnCloseSignup {
      background-color: #ccc;
      color: #333;
      margin-top: 10px;
    }

    @media (max-width: 500px) {
      .login-container, #signupModal {
        padding: 20px;
        width: 90%;
      }
    }
  </style>
</head>
<body>

<div class="login-container">
  <img src="LOGO SAFEALERT.png" alt="SafeAlert Logo" />

  <h2>Autentificare SafeAlert</h2>

  <?php if (isset($_GET['error'])): ?>
    <div class="error"><?= htmlspecialchars($_GET['error']) ?></div>
  <?php endif; ?>

  <form method="post" action="login_check.php">
    <input type="text" name="username" placeholder="Utilizator" required />
    <input type="password" name="password" placeholder="Parolă" required />
    <button type="submit">🔐 Conectează-te</button>
  </form>
  <button onclick="window.location.href='signup.php'" style="background-color: #5e4283; color: white; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
      Înregistrează-te
  </button>
</div>

<script>
  const btnSignUp = document.getElementById('btnSignUp');
  const signupModal = document.getElementById('signupModal');
  const btnCloseSignup = document.getElementById('btnCloseSignup');

  btnSignUp.addEventListener('click', () => {
    signupModal.style.display = 'block';
  });

  btnCloseSignup.addEventListener('click', () => {
    signupModal.style.display = 'none';
  });

  window.addEventListener('click', (e) => {
    if (e.target === signupModal) {
      signupModal.style.display = 'none';
    }
  });
</script>

</body>
</html>
