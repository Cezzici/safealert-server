<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit();
}
require_once 'db.php';
include 'header.php';

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
    <span style="font-size: 14px;">Autentificat ca: <em><?= htmlspecialchars($username) ?></em> (<?= htmlspecialchars($role) ?>)</span>
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
    $result = $conn->query("SELECT system_user_id, username, role FROM users ORDER BY system_user_id ASC");
    while ($row = $result->fetch_assoc()) {
      echo "<tr><td>" . htmlspecialchars($row['system_user_id']) . "</td><td>" . htmlspecialchars($row['username']) . "</td><td>" . htmlspecialchars($row['role']) . "</td></tr>";
    }
    ?>
  </table>
</main>

</body>
</html>
