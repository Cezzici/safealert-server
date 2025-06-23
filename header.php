<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$allowed_pages = ['login.php', 'login_check.php', 'signup.php'];

$current_page = basename($_SERVER['PHP_SELF']);

if (!in_array($current_page, $allowed_pages) && !isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require_once 'db.php';

// Numărăm pending users doar pentru admin
$pendingUsersCount = 0;
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    $pendingUsersCount = $conn->query("SELECT COUNT(*) FROM pending_users")->fetch_row()[0];
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>SafeAlert</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #5e4b8b;
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed; /* Navbar lipit sus */
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }


        header h1 {
            margin: 0;
            font-size: 28px;
            color:white;
        }

        header img {
            height: 50px;
            margin-right: 15px;
        }

        nav a {
            color: white;
            margin-right: 20px;
            text-decoration: none;
            font-weight: bold;
            position: relative;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .notification-badge {
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            position: absolute;
            top: -8px;
            right: -12px;
        }

        .container {
            width: 1200px;
            max-width: 90%;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            margin-top: 100px; /* spațiu cât header-ul fix */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #5e4b8b;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        button, .btn {
            background-color: #7b5eb6;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        button:hover, .btn:hover {
            background-color: #6749a4;
        }

        footer {
            background-color: #5e4b8b;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <header>
        <div style="display: flex; align-items: center;">
            <img src="LOGO SAFEALERT.png" alt="SafeAlert Logo">
            <h1>SafeAlert</h1>
        </div>
        <nav>
            <a href="dashboard.php">Dashboard</a>

            <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'authority') : ?>
                <a href="view_forms.php">Formulare</a>
                <a href="view_alerts.php">Alerte</a>
            <?php endif; ?>

            <a href="view_interventions.php">Intervenții</a>

            <?php if ($_SESSION['role'] == 'admin') : ?>
                <a href="manage_pending_users.php" style="position: relative;">
                    Utilizatori
                    <?php if ($pendingUsersCount > 0): ?>
                        <span class="notification-badge"><?= $pendingUsersCount ?></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>

            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <div class="container">
