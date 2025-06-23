<?php
include 'header.php';
require 'db.php';

// Verificăm dacă utilizatorul este admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['restore_authorities'])) {
    // Restaurăm autoritățile
    $authorities = [
        ['AUT-20250520-001', 'Sectia 1 de politie', 'Poliție', 'București', 'sectia1@politie.ro, 021-1234567', 'Agent Ion Popescu', 'ACTIV'],
        ['AUT-20250520-002', 'Poliția Timișoara', 'Poliție', 'Timișoara', 'timisoara@politie.ro, 0256-765432', 'Agent Maria Ionescu', 'ACTIV'],
        ['AUT-20250520-003', 'Poliția Iași', 'Poliție', 'Iași', 'iasi@politie.ro, 0232-987654', 'Agent Andrei Georgescu', 'ACTIV'],
        ['AUT-20250520-004', 'Centrul de Asistență pentru Victime', 'ONG', 'București', 'contact@victime.ro, 021-998877', 'Doamna Elena Vasilescu', 'ACTIV'],
        ['AUT-20250520-005', 'Asociația Sprijin Femei', 'ONG', 'Timișoara', 'office@sprijinfemei.ro, 0256-112233', 'Domnul Mihai Popa', 'ACTIV'],
        ['AUT-20250520-006', 'Serviciul Social Iași', 'Serviciu Social', 'Iași', 'social@iasi.ro, 0232-445566', 'Doamna Ana Marinescu', 'ACTIV'],
        ['AUT-20250520-007', 'Rețeaua pentru prevenirea și combaterea violenței împotriva femeilor', 'structură informală', 'București', 'vif@gmail.com', 'Cristian Popescu', 'activ'],
    ];

    foreach ($authorities as $auth) {
        $stmt = $conn->prepare("INSERT INTO authorities (authority_id, name, type, region, contact_details, contact_person, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $auth[0], $auth[1], $auth[2], $auth[3], $auth[4], $auth[5], $auth[6]);
        $stmt->execute();
    }

    $success = "✔️ Autoritățile au fost restaurate cu succes!";
}

if (isset($_POST['fix_cases'])) {
    // Reasociem cazurile
    $authority_map = [
        'București' => 'AUT-20250520-001',
        'Timișoara' => 'AUT-20250520-002',
        'Iași' => 'AUT-20250520-003'
    ];

    $sql = "SELECT form_id, location FROM forms WHERE authority_id IS NULL";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($form = $result->fetch_assoc()) {
            $form_id = $form['form_id'];
            $location = $form['location'];

            if (isset($authority_map[$location])) {
                $authority_id = $authority_map[$location];

                $update = $conn->prepare("UPDATE forms SET authority_id = ? WHERE form_id = ?");
                $update->bind_param("si", $authority_id, $form_id);
                $update->execute();
            }
        }
    }

    $sql = "SELECT alert_id, location FROM alerts WHERE authority_id IS NULL";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($alert = $result->fetch_assoc()) {
            $alert_id = $alert['alert_id'];
            $location = $alert['location'];

            if (isset($authority_map[$location])) {
                $authority_id = $authority_map[$location];

                $update = $conn->prepare("UPDATE alerts SET authority_id = ? WHERE alert_id = ?");
                $update->bind_param("si", $authority_id, $alert_id);
                $update->execute();
            }
        }
    }

    $success = "✔️ Cazurile au fost reasociate cu succes!";
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Restaurare date - Admin</title>
</head>
<body>
    <div class="card">
        <h2>🔧 Restaurare rapidă date</h2>

        <?php if (isset($success)) echo "<p style='color: green; font-weight: bold;'>$success</p>"; ?>

        <form method="POST">
            <button type="submit" name="restore_authorities" style="background-color: green; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; margin-bottom: 10px;">Restaurare autorități</button>
        </form>

        <form method="POST">
            <button type="submit" name="fix_cases" style="background-color: blue; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer;">Reasociere cazuri</button>
        </form>

        <br><a href="dashboard.php">⬅️ Înapoi la Dashboard</a>
    </div>
</body>
</html>
