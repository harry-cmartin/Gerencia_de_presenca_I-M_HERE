<?php
header('Content-Type: application/json');

// Set timezone to Brazil
date_default_timezone_set('America/Sao_Paulo');

// Verificar se o arquivo data.json existe, se não, criar um array vazio
$dataFile = 'data.json';
$presences = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $reuniao = $_POST['reuniao'] ?? '';
    
    if (empty($nome) || empty($reuniao)) {
        echo json_encode(['success' => false, 'message' => 'Nome e reunião são obrigatórios']);
        exit;
    }

    // Criar novo registro
    $newPresence = [
        'id' => uniqid(),
        'nome' => $nome,
        'reuniao' => $reuniao,
        'datetime' => date('Y-m-d H:i:s')
    ];

    // Adicionar ao array de presenças
    $presences[] = $newPresence;

    // Salvar no arquivo
    if (file_put_contents($dataFile, json_encode($presences, JSON_PRETTY_PRINT))) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar o registro']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
}
