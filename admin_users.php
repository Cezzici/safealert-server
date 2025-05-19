<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit();
}
require_once 'db.php';

// Adăugare utilizator nou
$mesaj = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];
  $role = $_POST['role'];

  $hashed = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $conn->prepare("INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $username, $hashed, $role);
  if ($stmt->execute()) {
    $mesaj = "✅ Utilizatorul <strong>$username</strong> a fost adăugat.";
  } else {
    $mesaj = "❌ Eroare: " . $stmt->error;
  }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Administrare Utilizatori – SafeAlert</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background-color: #f5f3f7;
    }

    header {
      background-color: #50276E;
      color: white;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header div {
      display: flex;
      flex-direction: column;
    }

    header a {
      color: #ccf;
      text-decoration: underline;
      margin-left: 20px;
      font-size: 14px;
    }

    header a:last-child {
      color: #f99;
    }

    main {
      padding: 30px;
      max-width: 900px;
      margin: auto;
    }

    .form-box {
      background-color: white;
      border-radius: 10px;
      padding: 30px;
      margin-bottom: 30px;
      box-shadow: 0 0 10px rgba(80, 39, 110, 0.1);
    }

    h2 {
      color: #50276E;
      margin-top: 0;
    }

    label {
      display: block;
      margin-top: 15px;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="password"],
    select {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    input[type="submit"] {
      background-color: #7B3FA4;
      color: white;
      border: none;
      padding: 12px 20px;
      margin-top: 20px;
      border-radius: 6px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #63318A;
    }

    .message {
      font-weight: bold;
      margin-bottom: 20px;
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: left;
    }

    th {
      background-color: #7B3FA4;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>

<?php
$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>
<header>
  <div>
    <strong style="font-size: 20px;">Administrare Utilizatori – SafeAlert</strong>
    <span style="font-size: 14px;">Autentificat ca: <em><?= htmlspecialchars($username) ?></em> (<?= $role ?>)</span>
  </div>
  <div>
    <a href="dashboard.php">Dashboard</a>
    <a href="logout.php">Logout</a>
  </div>
</header>

<main>
  <div class="form-box">
    <h2>Adaugă utilizator nou</h2>

    <?php if ($mesaj): ?>
      <p class="message"><?= $mesaj ?></p>
    <?php endif; ?>

    <form method="post">
      <label>Username</label>
      <input type="text" name="username" required>

      <label>Parolă</label>
      <input type="password" name="password" required>

      <label>Rol</label>
      <select name="role" required>
        <option value="admin">admin</option>
        <option value="authority">authority</option>
        <option value="ngo">ngo</option>
      </select>

      <input type="submit" value="Adaugă utilizator">
    </form>
  </div>

  <h2>Utilizatori existenți</h2>
  <table>
    <tr><th>ID</th><th>Username</th><th>Rol</th></tr>
    <?php
    $result = $conn->query("SELECT id, username, role FROM users ORDER BY id ASC");
    while ($row = $result->fetch_assoc()) {
      echo "<tr><td>{$row['id']}</td><td>{$row['username']}</td><td>{$row['role']}</td></tr>";
    }
    ?>
  </table>
</main>

</body>
</html>
