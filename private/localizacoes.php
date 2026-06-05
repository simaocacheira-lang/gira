<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once 'layout.php';

// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Gestão de Localizações");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Gestão de Localizações Hospitalares</h2>
        <p class="text-muted m-0 small">Mapeamento de blocos, pisos e salas para rastreabilidade dos dispositivos médicos.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovaLocalizacao">
        <i class="fa-solid fa-location-dot me-2"></i> Nova Localização
    </button>
</div>

<?php
// 1. Definimos as colunas da tabela
$colunas = [
    ['label' => 'Cód. Espaço', 'sort' => 'id_localizacao'],
    ['label' => 'Designação / Serviço', 'sort' => 'nome'],
    ['label' => 'Edifício / Bloco'],
    ['label' => 'Equip. Alocados'],
    ['label' => 'Estado da Sala'],
    ['label' => 'Ações', 'align' => 'end']
];

// 2. Desenhamos a caixa exterior e os cabeçalhos automaticamente!
render_table_start($colunas);
?>
<tr>
    <td class="fw-bold text-primary fw-mono">#LOC-C04</td>
    <td>
        <div class="fw-bold">Bloco Operatório Central</div>
        <small class="text-muted">Sala de Cirurgia Geral 4</small>
    </td>
    <td class="text-secondary">Piso 2 · Edifício Principal</td>
    <td><span class="fw-bold text-primary">14 equipamentos</span></td>
    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Operacional</span></td>
    <td class="text-end">
        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Espaço/Sala">
            <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="modal" data-bs-target="#modalEditarLocalizacao">
                <i class="fa-solid fa-pen text-primary"></i>
            </button>
        </span>

        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Remover Localização">
            <i class="fa-solid fa-trash"></i>
        </button>
    </td>
</tr>

<tr>
    <td class="fw-bold text-primary fw-mono">#LOC-URG01</td>
    <td>
        <div class="fw-bold">Serviço de Urgência Hospitalar</div>
        <small class="text-muted">Sala de Reanimação (Trauma 1)</small>
    </td>
    <td class="text-secondary">Piso 0 · Entrada Norte</td>
    <td><span class="fw-bold text-primary">9 equipamentos</span></td>
    <td><span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2">1 Manutenção</span></td>
    <td class="text-end">
        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Espaço/Sala">
            <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="modal" data-bs-target="#modalEditarLocalizacao">
                <i class="fa-solid fa-pen text-primary"></i>
            </button>
        </span>

        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Remover Localização">
            <i class="fa-solid fa-trash"></i>
        </button>
    </td>
</tr>

<?php
// 3. Fechamos as tags da tabela automaticamente!
render_table_end();

// 4. Fechamos a página e injetamos os scripts centrais
render_footer();
?>