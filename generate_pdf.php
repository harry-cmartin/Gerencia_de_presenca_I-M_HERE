<?php
require 'vendor/autoload.php';

// Set timezone to Brazil
date_default_timezone_set('America/Sao_Paulo');

// Check if a specific meeting was requested
$requestedMeeting = isset($_GET['reuniao']) ? $_GET['reuniao'] : null;

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Relatorio de Presencas', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Get data from data.json
$jsonData = file_get_contents('data.json');
$data = json_decode($jsonData, true);

// Filter data by meeting if specified
if ($requestedMeeting && $requestedMeeting !== '') {
    $data = array_filter($data, function($entry) use ($requestedMeeting) {
        return $entry['reuniao'] === $requestedMeeting;
    });
}

// Group participants by meeting
$meetings = [];
foreach ($data as $entry) {
    if (!isset($meetings[$entry['reuniao']])) {
        $meetings[$entry['reuniao']] = [];
    }
    $meetings[$entry['reuniao']][] = $entry;
}

// Create PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

foreach ($meetings as $meetingName => $participants) {
    // Meeting name
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, "Reuniao: " . $meetingName, 0, 1);
    $pdf->Ln(5);
    
    // Table header
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(80, 10, 'Nome', 1);
    $pdf->Cell(60, 10, 'Data', 1);
    $pdf->Cell(50, 10, 'Hora', 1);
    $pdf->Ln();
    
    // Table content
    $pdf->SetFont('Arial', '', 12);
    foreach ($participants as $participant) {
        $datetime = new DateTime($participant['datetime']);
        $datetime->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        $date = $datetime->format('d/m/Y');
        $time = $datetime->format('H:i:s');
        
        $pdf->Cell(80, 10, utf8_decode($participant['nome']), 1);
        $pdf->Cell(60, 10, $date, 1);
        $pdf->Cell(50, 10, $time, 1);
        $pdf->Ln();
    }
    
    // Total participants
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, "Total de participantes: " . count($participants), 0, 1);
    $pdf->Ln(10);
}

// Output PDF
$pdf->Output('D', 'relatorio_presencas.pdf');
