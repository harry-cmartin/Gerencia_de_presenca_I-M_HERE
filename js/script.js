document.addEventListener('DOMContentLoaded', function() {
    const presenceForm = document.getElementById('presenceForm');
    const presenceList = document.getElementById('presenceList');
    const filtroReuniao = document.getElementById('filtroReuniao');
    const gerarRelatorioBnt = document.getElementById('gerarRelatorio');

    // Carregar presenças ao iniciar
    loadPresences();
    updateReunioesList();

    // Adicionar nova presença
    presenceForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(presenceForm);
        fetch('register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                presenceForm.reset();
                loadPresences();
                updateReunioesList();
                // Mostrar mensagem de sucesso
                showAlert('Presença registrada com sucesso!', 'success');
            } else {
                showAlert('Erro ao registrar presença: ' + data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            showAlert('Erro ao registrar presença', 'danger');
        });
    });

    // Filtrar por reunião
    filtroReuniao.addEventListener('change', function() {
        if (gerarRelatorioBnt) {
            gerarRelatorioBnt.disabled = !this.value;
        }
        loadPresences();
    });

    // Handle PDF generation
    if (gerarRelatorioBnt) {
        gerarRelatorioBnt.addEventListener('click', function() {
            const reuniaoSelecionada = document.getElementById('filtroReuniao').value;
            const url = `generate_pdf.php${reuniaoSelecionada ? `?reuniao=${encodeURIComponent(reuniaoSelecionada)}` : ''}`;
            window.open(url, '_blank');
        });
    }

    // Carregar lista de presenças
    function loadPresences() {
        const reuniao = filtroReuniao.value;
        fetch(`get_presences.php${reuniao ? '?reuniao=' + encodeURIComponent(reuniao) : ''}`)
            .then(response => response.json())
            .then(data => {
                presenceList.innerHTML = '';
                data.forEach(presence => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${presence.nome}</td>
                        <td>${presence.reuniao}</td>
                        <td>${formatDateTime(presence.datetime)}</td>
                        <td>
                            <button class="btn-remove" onclick="removePresence('${presence.id}')">
                                <i class="fas fa-trash-alt"></i>
                                Remover
                            </button>
                        </td>
                    `;
                    presenceList.appendChild(row);
                });

                if (data.length === 0) {
                    presenceList.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                                Nenhum registro encontrado
                            </td>
                        </tr>
                    `;
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                showAlert('Erro ao carregar presenças', 'danger');
            });
    }

    // Atualizar lista de reuniões no filtro
    function updateReunioesList() {
        fetch('get_reunioes.php')
            .then(response => response.json())
            .then(data => {
                const currentValue = filtroReuniao.value;
                filtroReuniao.innerHTML = '<option value="">Todas as reuniões</option>';
                data.forEach(reuniao => {
                    const option = document.createElement('option');
                    option.value = reuniao;
                    option.textContent = reuniao;
                    if (reuniao === currentValue) {
                        option.selected = true;
                    }
                    filtroReuniao.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erro:', error);
                showAlert('Erro ao carregar lista de reuniões', 'danger');
            });
    }
});

// Formatar data e hora
function formatDateTime(datetime) {
    const date = new Date(datetime);
    return date.toLocaleDateString('pt-BR') + ' ' + 
           date.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
}

// Remover presença
function removePresence(id) {
    if (confirm('Tem certeza que deseja remover este registro?')) {
        fetch('remove_presence.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('Registro removido!', 'success');
                document.querySelector(`[onclick="removePresence('${id}')"]`).closest('tr').remove();
            } else {
                showAlert('Erro ao remover presença: ' + data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            showAlert('Erro ao remover presença', 'danger');
        });
    }
}

// Mostrar alertas
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    alertDiv.style.zIndex = '1050';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    document.body.appendChild(alertDiv);

    // Remover alerta após 3 segundos
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}