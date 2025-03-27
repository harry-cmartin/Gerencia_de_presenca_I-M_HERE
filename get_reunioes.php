<?php
header('Content-Type: application/json');

$dataFile = 'data.json';
$presences = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

// Extrair lista única de reuniões
$reunioes = array_unique(array_map(function($p) {
    return $p['reuniao'];
}, $presences));

// Ordenar alfabeticamente
sort($reunioes);

echo json_encode(array_values($reunioes));
