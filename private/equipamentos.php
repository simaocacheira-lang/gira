<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once 'layout.php';

// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Inventário de Equipamentos Médicos");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Inventário de Dispositivos Médicos</h2>
        <p class="text-muted m-0 small">Registo, controlo técnico e classificação de risco do parque tecnológico do hospital.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalRegistarEquipamento">
        <i class="fa-solid fa-plus me-2"></i> Registar Equipamento
    </button>
</div>

<?php
// 1. Definimos as colunas da tabela
$colunas = [
    ['label' => 'Cód. Ativo', 'sort' => 'id'],
    ['label' => 'Equipamento / Modelo', 'sort' => 'nome'],
    ['label' => 'Nº Série / Património'],
    ['label' => 'Estado', 'sort' => 'estado'],
    ['label' => 'Ações', 'align' => 'end']
];

// 2. Desenhamos a caixa exterior e os cabeçalhos automaticamente!
render_table_start($colunas);
?>

<tr>
    <td class="fw-bold text-primary fw-mono">#EQ-2026-001</td>
    <td>
        <div class="fw-bold">Monitor Multiparamétrico de Sinais Vitais</div>
        <small class="text-muted">Mindray · BeneVision N17</small>
    </td>
    <td class="fw-mono text-secondary">MR-MN-77119</td>
    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Operacional</span></td>
    <td class="text-end">
        <a href="detalhes_equipamento.php" class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Consultar Equipamento">
            <i class="fa-solid fa-eye text-primary"></i>
        </a>
        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Equipamento">
            <i class="fa-solid fa-trash"></i>
        </button>
    </td>
</tr>

<tr>
    <td class="fw-bold text-primary fw-mono">#EQ-2026-002</td>
    <td>
        <div class="fw-bold">Bomba de Infusão Volumétrica</div>
        <small class="text-muted">B. Braun · Infusomat Space</small>
    </td>
    <td class="fw-mono text-secondary">BB-IV-44210</td>
    <td><span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2">Aguardar Calibração</span></td>
    <td class="text-end">
        <a href="detalhes_equipamento.php" class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Consultar Equipamento">
            <i class="fa-solid fa-eye text-primary"></i>
        </a>
        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Equipamento">
            <i class="fa-solid fa-trash"></i>
        </button>
    </td>
</tr>

<tr>
    <td class="fw-bold text-primary fw-mono">#EQ-2026-003</td>
    <td>
        <div class="fw-bold">Ventilador de Cuidados Intensivos</div>
        <small class="text-muted">Dräger · Evita V800</small>
    </td>
    <td class="fw-mono text-secondary">DR-VT-99302</td>
    <td><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2">Inoperacional</span></td>
    <td class="text-end">
        <a href="detalhes_equipamento.php" class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Consultar Equipamento">
            <i class="fa-solid fa-eye text-primary"></i>
        </a>
        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Equipamento">
            <i class="fa-solid fa-trash"></i>
        </button>
    </td>
</tr>

<?php
// 3. Fechamos as tags da tabela automaticamente!
render_table_end();

// 4. Fechamos a página e injetamos os scripts
render_footer();
?>