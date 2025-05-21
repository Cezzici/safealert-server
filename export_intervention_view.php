<?php
require_once 'db.php';
require_once 'fpdf.php'; // sau 'libs/fpdf/fpdf.php' dacă e pus în subfolder

$intervention_id = $_GET['intervention_id'] ?? null;

if (!$intervention_id) {
    die("ID intervenție lipsă.");
}

// Căutăm intervenția și codul formularului
$stmt = $conn->prepare("
    SELECT i.*, f.code AS form_code 
    FROM interventions i 
    LEFT JOIN forms f ON i.form_id = f.form_id 
    WHERE i.intervention_id = ?
");
$stmt->bind_param("i", $intervention_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Intervenția nu a fost găsită.");
}

$interv = $result->fetch_assoc();

// Inițializare PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(94, 66, 131); // Violet branding SafeAlert

$pdf->Cell(0, 10, 'Interventie SafeAlert', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0);

// Conținut
$pdf->Cell(50, 10, 'Cod formular:', 0, 0);
$pdf->Cell(0, 10, $interv['form_code'], 0, 1);

$pdf->Cell(50, 10, 'Tip intervenție:', 0, 0);
$pdf->Cell(0, 10, $interv['intervention_type'], 0, 1);

$pdf->Cell(50, 10, 'Responsabil:', 0, 0);
$pdf->Cell(0, 10, $interv['responsible_person'], 0, 1);

$pdf->Cell(50, 10, 'Status:', 0, 0);
$pdf->Cell(0, 10, $interv['status'], 0, 1);

$pdf->Cell(50, 10, 'Dată:', 0, 0);
$pdf->Cell(0, 10, $interv['created_at'], 0, 1);

$pdf->Ln(5);
$pdf->Cell(0, 10, 'Detalii:', 0, 1);
$pdf->MultiCell(0, 8, $interv['details']);

$pdf->Output("I", "interventie_" . $intervention_id . ".pdf");
exit();
