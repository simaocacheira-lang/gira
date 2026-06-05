<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once 'layout.php';

// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Perfis e Grupos de Permissões");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Perfis de Acesso</h2>
        <p class="text-muted m-0 small">Configuração de grupos de utilizadores, níveis de autorização e politicas de segurança.</p>
    </div>

    <!-- Gatilho para abrir o Modal do Bootstrap -->
    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAdicionarPerfil">
        <i class="fa-solid fa-users-gear me-2"></i> Adicionar Perfil
    </button>
</div>

<?php
// 1. Definimos as colunas da tabela
$colunas = [
    ['label' => 'Nome do Perfil', 'sort' => 'nome_perfil'],
    ['label' => 'Descrição do Escopo', 'sort' => 'descricao'],
    ['label' => 'Nº Utilizadores', 'sort' => 'total_users'],
    ['label' => 'Nível de Permissão', 'sort' => 'nivel_acesso'],
    ['label' => 'Ações', 'align' => 'end']
];

// 2. Desenhamos a caixa exterior e os cabeçalhos automaticamente!
render_table_start($colunas);
?>

<!-- ==================== PERFIL 1 ==================== -->
<tr>
    <td class="fw-bold text-dark">Administrador</td>
    <td class="text-secondary">Acesso total e irrestrito a todos os módulos, configurações de sistema e logs de auditoria.</td>
    <td><span class="fw-bold text-primary">1 utilizador</span></td>
    <td><span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2"><i class="fa-solid fa-shield me-1"></i> Escrita Total</span></td>
    <td class="text-end">
        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Configurar Direitos do Grupo">
            <i class="fa-solid fa-key text-primary"></i>
        </button>
        <button class="btn btn-light btn-sm rounded-3 text-danger border disabled" data-bs-toggle="tooltip" data-bs-placement="top" title="Perfil de Sistema (Bloqueado)">
            <i class="fa-solid fa-lock"></i>
        </button>
    </td>
</tr>

<!-- ==================== PERFIL 2 ==================== -->
<tr>
    <td class="fw-bold text-dark">Eng. Biomédico</td>
    <td class="text-secondary">Gestão completa de inventário, localizações, fornecedores, documentos e abertura de O.T.</td>
    <td><span class="fw-bold text-primary">1 utilizador</span></td>
    <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2"><i class="fa-solid fa-pen-to-square me-1"></i> Modificação</span></td>
    <td class="text-end">
        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Configurar Direitos do Grupo">
            <i class="fa-solid fa-key text-primary"></i>
        </button>
        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Perfil">
            <i class="fa-solid fa-trash"></i>
        </button>
    </td>
</tr>

<!-- ==================== PERFIL 3 ==================== -->
<tr>
    <td class="fw-bold text-dark">Técnico Interno</td>
    <td class="text-secondary">Visualização do parque tecnológico e alteração/conclusão de ordens de trabalho atribuídas.</td>
    <td><span class="fw-bold text-primary">1 utilizador</span></td>
    <td><span class="badge bg-info bg-opacity-10 text-info border border-info-subtle px-2"><i class="fa-solid fa-wrench me-1"></i> Operação</span></td>
    <td class="text-end">
        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Configurar Direitos do Grupo">
            <i class="fa-solid fa-key text-primary"></i>
        </button>
        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Perfil">
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