<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$username = $_SESSION['username'] ?? '';
$role = $_SESSION['role'] ?? '';
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeAlert</title>
    <style>
        .navbar {
            background-color: #5e4283;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
            font-weight: bold;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .navbar .menu {
            display: flex;
            align-items: center;
        }

        .badge {
            background-color: red;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            margin-left: 5px;
        }

        .badge-orange {
            background-color: orange;
        }

        .mark-read {
            color: #ffb400;
            margin-left: 10px;
            font-weight: bold;
        }

        .mark-read:hover {
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="menu">
        <a href="dashboard.php">Dashboard</a>
        <?php if ($role === 'admin' || $role === 'authority'): ?>
            <a href="view_alerts.php">Alerte <span id="alertBadge" class="badge">0</span></a>
            <a href="view_forms.php">Formulare</a>
        <?php endif; ?>

        <a href="view_interventions.php">Intervenții</a>

        <?php if ($role === 'admin'): ?>
            <a href="view_authorities.php">Autorități</a>
            <a href="manage_pending_users.php">Conturi <span id="pendingBadge" class="badge badge-orange">0</span></a>
            <a href="mark_notifications_read.php" class="mark-read">🔄 Marchează ca citite</a>
        <?php endif; ?>
    </div>

    <div>
        Autentificat ca: <?= htmlspecialchars($username) ?> |
        <a href="logout.php" style="color: white; font-weight: bold;">Logout</a>
    </div>
</div>

<script>
    function updateNotifications() {
        fetch('check_new_alerts.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('pendingBadge').innerText = data.pending;
                document.getElementById('alertBadge').innerText = data.alerts;
            });
    }

    setInterval(updateNotifications, 5000);
    updateNotifications();
</script>
