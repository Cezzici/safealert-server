<?php
require_once 'db.php';

// Selectăm autoritățile
$authorities = $conn->query("SELECT authority_id, name, type FROM authorities WHERE status = 'ACTIV'");

$authority_options = [];
$ngo_options = [];

while ($row = $authorities->fetch_assoc()) {
    if (strtoupper($row['type']) === 'ONG') {
        $ngo_options[] = $row;
    } else {
        $authority_options[] = $row;
    }
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = $_POST['role'] ?? '';
    $authority_id = $_POST['authority_id'] ?? '';
    $email = trim($_POST['email'] ?? '');

    if (empty($username) || empty($password) || empty($confirm_password) || empty($role) || empty($authority_id) || empty($email)) {
        $errors[] = "Toate câmpurile sunt obligatorii.";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Parolele nu coincid.";
    } else {
        // Verificăm separat în users și pending_users
        $stmt1 = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt1->bind_param("s", $username);
        $stmt1->execute();
        $res1 = $stmt1->get_result();

        $stmt2 = $conn->prepare("SELECT * FROM pending_users WHERE username = ?");
        $stmt2->bind_param("s", $username);
        $stmt2->execute();
        $res2 = $stmt2->get_result();

        if ($res1->num_rows > 0 || $res2->num_rows > 0) {
            $errors[] = "Numele de utilizator este deja folosit.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO pending_users (username, password_hash, role, authority_id, email) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $username, $password_hash, $role, $authority_id, $email);
            $stmt->execute();
            $success = "Contul tău a fost trimis pentru aprobare.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Înregistrare SafeAlert</title>
    <style>
        body {
            background: linear-gradient(135deg, #f5f2ff, #e5ddfa);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #5e4283;
        }

        form input, form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        form button {
            background-color: #5e4283;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        form button:hover {
            background-color: #4a3470;
        }

        .error {
            color: red;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .success {
            color: green;
            margin-bottom: 10px;
            font-weight: bold;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #5e4283;
            font-weight: bold;
        }
    </style>
    <script>
        function filterAuthorities() {
            let role = document.getElementById('role').value;
            let allOptions = document.querySelectorAll('#authority_id option');

            allOptions.forEach(option => {
                option.style.display = 'none';
            });

            if (role === 'authority') {
                document.querySelectorAll('.authority-option').forEach(option => {
                    option.style.display = 'block';
                });
            } else if (role === 'ngo') {
                document.querySelectorAll('.ngo-option').forEach(option => {
                    option.style.display = 'block';
                });
            }
        }
    </script>
</head>
<body>

<div class="card">
    <h2>Înregistrare SafeAlert</h2>

    <?php foreach ($errors as $error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endforeach; ?>

    <?php if ($success): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Nume utilizator" required>
        <input type="password" name="password" placeholder="Parolă" required>
        <input type="password" name="confirm_password" placeholder="Confirmă parola" required>

        <select name="role" id="role" required onchange="filterAuthorities()">
            <option value="">Selectează rolul</option>
            <option value="authority">Autoritate</option>
            <option value="ngo">ONG</option>
        </select>

        <input type="email" name="email" placeholder="Email de contact" required>

        <select name="authority_id" id="authority_id" required>
            <option value="">Selectează autoritatea</option>
            <?php foreach ($authority_options as $a): ?>
                <option value="<?= $a['authority_id'] ?>" class="authority-option"><?= htmlspecialchars($a['name']) ?> (<?= htmlspecialchars($a['type']) ?>)</option>
            <?php endforeach; ?>

            <?php foreach ($ngo_options as $a): ?>
                <option value="<?= $a['authority_id'] ?>" class="ngo-option"><?= htmlspecialchars($a['name']) ?> (<?= htmlspecialchars($a['type']) ?>)</option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Înregistrează-te</button>
    </form>

    <a href="login.php">⬅️ Înapoi la Login</a>
</div>

</body>
</html>
