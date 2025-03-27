<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Registro de Presença</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container mt-5">
        <div class="text-center mb-5">
            <h1><i class="fas fa-clipboard-check me-2"></i>Sistema de Registro de Presença</h1>
            <h1 style="color:rgb(26, 193, 87)">I'M HERE</h1>
            <p class="text-muted">Gerencie presenças em reuniões e eventos de forma simples e eficiente</p>
        </div>

        <!-- Abas para navegação -->
        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="registro-tab" data-bs-toggle="tab" data-bs-target="#registro" type="button" role="tab">
                    <i class="fas fa-plus-circle me-2"></i>Novo Registro
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="lista-tab" data-bs-toggle="tab" data-bs-target="#lista" type="button" role="tab">
                    <i class="fas fa-list me-2"></i>Lista de Presenças
                </button>
            </li>
        </ul>

        <!-- Conteúdo das abas -->
        <div class="tab-content" id="myTabContent">
            <!-- Aba de Registro -->
            <div class="tab-pane fade show active" id="registro" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <form id="presenceForm" class="mb-4">
                            <div class="mb-4">
                                <label for="nome" class="form-label">
                                    <i class="fas fa-user me-2"></i>Nome do Participante
                                </label>
                                <input type="text" class="form-control" id="nome" name="nome" required
                                    placeholder="Digite o nome completo">
                            </div>
                            <div class="mb-4">
                                <label for="reuniao" class="form-label">
                                    <i class="fas fa-users me-2"></i>Reunião/Evento
                                </label>
                                <input type="text" class="form-control" id="reuniao" name="reuniao" required
                                    placeholder="Nome da reunião ou evento">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check me-2"></i>Registrar Presença
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Aba de Lista -->
            <div class="tab-pane fade" id="lista" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="flex-grow-1 me-3">
                                    <label for="filtroReuniao" class="form-label">
                                        <i class="fas fa-filter me-2"></i>Filtrar por Reunião
                                    </label>
                                    <select class="form-select" id="filtroReuniao">
                                        <option value="">Todas as reuniões</option>
                                    </select>
                                </div>
                                <div class="align-self-end">
                                    <button id="gerarRelatorio" class="btn btn-success">
                                        <i class="fas fa-file-pdf me-2"></i>Gerar Relatório
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-user me-2"></i>Nome</th>
                                        <th><i class="fas fa-users me-2"></i>Reunião</th>
                                        <th><i class="fas fa-clock me-2"></i>Data/Hora</th>
                                        <th><i class="fas fa-cog me-2"></i>Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="presenceList">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>