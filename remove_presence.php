<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

$id = $_POST['id'] ?? '';
if (empty($id)) {
    echo json_encode(['success' => false, 'message' => 'ID não fornecido']);
    exit;
}

$dataFile = 'data.json';
if (!file_exists($dataFile)) {
    echo json_encode(['success' => false, 'message' => 'Arquivo de dados não encontrado']);
    exit;
}

$presences = json_decode(file_get_contents($dataFile), true);

// Remover o registro com o ID especificado
$presences = array_filter($presences, function($p) use ($id) {
    return $p['id'] !== $id;
});

// Salvar arquivo atualizado
if (file_put_contents($dataFile, json_encode(array_values($presences), JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao salvar as alterações']);
}
