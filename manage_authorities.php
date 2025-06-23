<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'db.php';
include 'header.php';

// Verificăm dacă utilizatorul este logat și este admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Adăugare autoritate
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    // Caut cel mai mare ID existent
$result = $conn->query("SELECT authority_id FROM authorities ORDER BY authority_id DESC LIMIT 1");

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $last_id = $row['authority_id'];

    // Extragem numărul final
    $last_number = intval(substr($last_id, -3));
    $new_number = str_pad($last_number + 1, 3, '0', STR_PAD_LEFT);
} else {
    // Dacă nu există nicio autoritate, începem de la 001
    $new_number = '001';
}

$authority_id = 'AUT-' . date('Ymd') . '-' . $new_number;

    $name = $_POST['name'];
    $type = $_POST['type'];
    $region = $_POST['region'];
    $contact_person = $_POST['contact_person'];
    $contact_details = $_POST['contact_details'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO authorities (authority_id, name, type, region, contact_person, contact_details, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $authority_id, $name, $type, $region, $contact_person, $contact_details, $status);

    if ($stmt->execute()) {
        header("Location: view_authorities.php?msg=added");
        exit();
    } else {
        $error = "Eroare la adăugarea autorității.";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Adaugă Autoritate</title>
    <style>
        .form-container {
            max-width: 500px;
            margin: 40px auto;
            background-color: #fdfdff;
            padding: 20px;
            border-radius: 10px;
            border-left: 5px solid #5e4283;
            font-family: 'Segoe UI', sans-serif;
        }
        .form-container h2 {
            margin-bottom: 20px;
            color: #5e4283;
        }
        .form-container label {
            font-weight: bold;
        }
        .form-container input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        .form-container a {
            display: inline-block;
            margin-top: 20px;
            color: #5e4283;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="form-container">
        <h2>➕ Adaugă Autoritate</h2>

        <?php if (isset($error)) echo "<p style='color: red; font-weight: bold;'>$error</p>"; ?>

        <form method="POST" action="manage_authorities.php">
            <label>Nume:</label>
            <input type="text" name="name" required>

            <label>Tip:</label>
            <input type="text" name="type" required>

            <label>Regiune:</label>
            <input type="text" name="region" required>

            <label>Persoană contact:</label>
            <input type="text" name="contact_person" required>

            <label>Date contact:</label>
            <input type="text" name="contact_details" required>

            <label>Status:</label>
            <label>Status:</label>
                <select name="status" required>
                    <option value="ACTIV" selected>ACTIV</option>
                    <option value="INACTIV">INACTIV</option>
                    <option value="SUSPENDAT">SUSPENDAT</option>
                </select>
            <button type="submit">Adaugă Autoritate</button>
        </form>

        <a href="view_authorities.php">⬅️ Înapoi la lista autorităților</a>
    </div>

<?php include 'footer.php'; ?>

</body>
</html>
