<?php
// Start PHP tag, you can add session handling here if needed
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeAlert - Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1E3A8A;
            color: white;
            text-align: center;
            padding: 50px;
        }
        h1 {
            color: #FDE68A;
        }
        .menu-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 2px;
            cursor: pointer;
            border-radius: 8px;
        }
        .menu-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h1>SafeAlert - Dashboard</h1>
    <p>Acces rapid la formulare și intervenții!</p>

    <div>
        <a href="view_forms.php"><button class="menu-button">Vezi Formulare</button></a><br><br>
        <a href="view_interventions.php"><button class="menu-button">Vezi Intervenții</button></a><br><br>
        <a href="view_reports.php"><button class="menu-button">Vezi Rapoarte</button></a><br><br>
        <a href="view_authorities.php"><button class="menu-button">Vezi Autorități</button></a><br><br>
    </div>

</body>
</html>
