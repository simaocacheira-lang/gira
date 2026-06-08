<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Histórico de Atividades e Logs");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Histórico do Sistema</h2>
        <p class="text-muted m-0 small">Registo cronológico de operações, alterações de inventário e acessos de utilizadores para fins de auditoria.</p>
    </div>

    <button class="btn btn-light border rounded-3 fw-bold small px-3 py-2 text-danger shadow-sm">
        <i class="fa-solid fa-trash-can me-2"></i> Limpar Logs Antigos
    </button>
</div>

<?php
// 1. Definimos as colunas da tabela
$colunas = [
    ['label' => 'Cód. Registo', 'sort' => 'id_log'],
    ['label' => 'Data / Hora', 'sort' => 'data_hora'],
    ['label' => 'Utilizador', 'sort' => 'utilizador'],
    ['label' => 'Ação / Evento', 'sort' => 'acao'],
    ['label' => 'Módulo', 'sort' => 'modulo'],
    ['label' => 'IP de Origem', 'sort' => 'ip'],
    ['label' => 'Ações', 'align' => 'end']
];

// 2. Desenhamos a caixa exterior e os cabeçalhos automaticamente!
render_table_start($colunas);
?>

<tr>
    <td class="fw-bold text-secondary fw-mono">#LOG-88411</td>
    <td class="fw-mono text-dark">31/05/2026 14:30:02</td>
    <td>
        <div class="fw-bold">Eng. Sofia Cabral</div>
        <small class="text-muted">Administrador</small>
    </td>
    <td><span class="text-success fw-medium"><i class="fa-solid fa-right-to-bracket me-1"></i> Início de Sessão</span></td>
    <td><span class="badge bg-light text-dark border px-2">Autenticação</span></td>
    <td class="fw-mono text-secondary">192.168.1.101</td>
    <td class="text-end">
        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Detalhes do Log">
            <i class="fa-solid fa-circle-info text-primary"></i>
        </button>
    </td>
</tr>

<tr>
    <td class="fw-bold text-secondary fw-mono">#LOG-88410</td>
    <td class="fw-mono text-dark">31/05/2026 14:22:19</td>
    <td>
        <div class="fw-bold">Eng. Dinis Martins</div>
        <small class="text-muted">Técnico Biomédico</small>
    </td>
    <td><span class="text-danger fw-medium"><i class="fa-solid fa-trash me-1"></i> Eliminou Documento #DOC-9914</span></td>
    <td><span class="badge bg-light text-dark border px-2">Documentos</span></td>
    <td class="fw-mono text-secondary">192.168.1.115</td>
    <td class="text-end">
        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Detalhes do Log">
            <i class="fa-solid fa-circle-info text-primary"></i>
        </button>
    </td>
</tr>

<?php
// 3. Fechamos as tags da tabela automaticamente!
render_table_end();

// 4. Fechamos a página e injetamos os scripts
render_footer();
?>