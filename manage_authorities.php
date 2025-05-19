<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Autorități</title>
  <style>
    body {
      background-color: #005bbb;
      font-family: 'Segoe UI', sans-serif;
      color: white;
      padding: 30px;
    }
    h1 {
      text-align: center;
      margin-bottom: 30px;
    }
    .container {
      max-width: 900px;
      margin: auto;
      background-color: #003f88;
      padding: 30px;
      border-radius: 12px;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    input {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: none;
      margin-top: 5px;
      font-size: 16px;
      color: #000;
    }
    .btns {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }
    button {
      padding: 12px 20px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
    }
    .red { background-color: #ff4d4d; color: white; }
    .green { background-color: #ccff66; color: black; }
  </style>
</head>
<body>
  <h1>AUTORITĂȚI</h1>
  <div class="container">
    <form id="authorityForm">
      <label>ID Autoritate</label>
      <input type="text" id="authority_id" value="AUT-<?= date('Ymd') ?>-001">

      <label>Nume autoritate</label>
      <input type="text" id="name">

      <label>Tip Autoritate</label>
      <input type="text" id="type">

      <label>Regiune</label>
      <input type="text" id="region">

      <label>Detalii Contact</label>
      <input type="text" id="contact_details">

      <label>Responsabil</label>
      <input type="text" id="contact_person">

      <label>Status Colaborare</label>
      <input type="text" id="status">

      <div class="btns">
        <button type="reset" class="red">Șterge câmpurile</button>
        <button type="submit" class="green">Actualizează</button>
      </div>
    </form>
  </div>

  <script>
    document.getElementById('authorityForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const data = {
        authority_id: document.getElementById('authority_id').value,
        name: document.getElementById('name').value,
        type: document.getElementById('type').value,
        region: document.getElementById('region').value,
        contact_details: document.getElementById('contact_details').value,
        contact_person: document.getElementById('contact_person').value,
        status: document.getElementById('status').value
      };

      fetch('save_authority.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      })
      .then(r => r.json())
      .then(resp => alert(resp.message || 'Autoritate înregistrată!'))
      .catch(() => alert('Eroare la trimitere'));
    });
  </script>
</body>
</html>
