<?php
header('Content-Type: application/json');

$dataFile = 'data.json';
$presences = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

// Filtrar por reunião se especificado
if (isset($_GET['reuniao']) && !empty($_GET['reuniao'])) {
    $reuniao = $_GET['reuniao'];
    $presences = array_filter($presences, function($p) use ($reuniao) {
        return $p['reuniao'] === $reuniao;
    });
}

// Ordenar por data/hora (mais recente primeiro)
usort($presences, function($a, $b) {
    return strtotime($b['datetime']) - strtotime($a['datetime']);
});

echo json_encode(array_values($presences));
