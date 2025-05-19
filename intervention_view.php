<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Intervenții înregistrate</title>
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
      max-width: 800px;
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
    input, textarea {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: none;
      margin-top: 5px;
      font-size: 16px;
      color: #000;
    }
    textarea {
      height: 100px;
      resize: vertical;
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
  <h1>Formular Intervenție</h1>
  <div class="container">
    <form id="interventionForm">
      <label>ID Caz (Formular)</label>
      <input type="number" id="form_id" placeholder="ex: 1" required>

      <label>Tip Intervenție</label>
      <input type="text" id="intervention_type" placeholder="Psihologică, Juridică etc." required>

      <label>Responsabil</label>
      <input type="text" id="responsible_person" placeholder="Nume persoană responsabilă">

      <label>Detalii</label>
      <textarea id="details" placeholder="Observații despre intervenție..."></textarea>

      <label>Status</label>
      <input type="text" id="status" placeholder="În desfășurare / Finalizată" required>

      <div class="btns">
        <button type="reset" class="red">Șterge câmpurile</button>
        <button type="submit" class="green">Salvează Intervenția</button>
      </div>
    </form>
  </div>

  <script>
    document.getElementById('interventionForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const data = {
        form_id: document.getElementById('form_id').value,
        intervention_type: document.getElementById('intervention_type').value,
        responsible_person: document.getElementById('responsible_person').value,
        details: document.getElementById('details').value,
        status: document.getElementById('status').value
      };

      fetch('save_intervention.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      })
      .then(r => r.json())
      .then(resp => alert(resp.message || 'Intervenție salvată!'))
      .catch(() => alert('Eroare la trimitere'));
    });
  </script>
</body>
</html>
