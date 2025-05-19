<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Autentificare - SafeAlert</title>
  <style>
    body {
      background-color: #f5f3f7;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .login-box {
      background-color: white;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(102, 51, 153, 0.2);
      width: 350px;
      text-align: center;
    }

    h2 {
      color: #50276E;
      margin-bottom: 20px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    input[type="submit"] {
      background-color: #7B3FA4;
      color: white;
      border: none;
      padding: 10px;
      width: 100%;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #63318A;
    }

    .logo {
      width: 60px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <img src="LOGO SAFEALERT.png" alt="SafeAlert Logo" class="logo">
    <h2>SafeAlert Login</h2>
    <form action="login_check.php" method="post">
      <input type="text" name="username" placeholder="Utilizator" required>
      <input type="password" name="password" placeholder="Parolă" required>
      <input type="submit" value="Autentificare">
    </form>
  </div>
</body>
</html>
