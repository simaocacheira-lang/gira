<?php
// 1. Ligar à Base de Dados e carregar o Molde
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

render_header("Gira - Inventário de Equipamentos Médicos");

// ============================================================================
// CONFIGURAÇÕES DA PESQUISA E PAGINAÇÃO (Ficha 11)
// ============================================================================
$limite_por_pagina = 5; // Mostrar apenas 5 equipamentos por página

// Descobrir em que página estamos (se não houver página no URL, assume a 1)
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_atual < 1) $pagina_atual = 1;

// Calcular o OFFSET (quantos registos saltar)
$offset = ($pagina_atual - 1) * $limite_por_pagina;

// Descobrir se o utilizador pesquisou alguma coisa
$termo_pesquisa = isset($_GET['pesquisa']) ? trim($_GET['pesquisa']) : '';

try {
    // PASSO A: Contar quantos equipamentos existem no total para desenhar os botões
    $sql_count = "SELECT COUNT(*) FROM equipamentos WHERE nome LIKE :pesquisa OR modelo LIKE :pesquisa OR codigo_ativo LIKE :pesquisa";
    $stmt_count = $pdo->prepare($sql_count);
    $stmt_count->execute([':pesquisa' => '%' . $termo_pesquisa . '%']);
    $total_registos = $stmt_count->fetchColumn();

    // Matemática: Arredondar para cima (ex: 11 registos / 5 = 3 páginas)
    $total_paginas = ceil($total_registos / $limite_por_pagina);

    // PASSO B: Ir buscar APENAS os equipamentos desta página exata
    $sql = "SELECT * FROM equipamentos 
            WHERE nome LIKE :pesquisa OR modelo LIKE :pesquisa OR codigo_ativo LIKE :pesquisa 
            ORDER BY data_aquisicao DESC 
            LIMIT :limite OFFSET :offset";

    $stmt = $pdo->prepare($sql);
    // Usamos bindValue para garantir que o LIMIT e OFFSET vão como números inteiros (segurança do PDO)
    $stmt->bindValue(':pesquisa', '%' . $termo_pesquisa . '%', PDO::PARAM_STR);
    $stmt->bindValue(':limite', $limite_por_pagina, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $lista_equipamentos = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao carregar a base de dados: " . $e->getMessage());
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Inventário de Dispositivos Médicos</h2>
        <p class="text-muted m-0 small">Registo, controlo técnico e classificação de risco do parque tecnológico.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalRegistarEquipamento">
        <i class="fa-solid fa-plus me-2"></i> Registar Equipamento
    </button>
</div>

<div class="row mb-4">
    <div class="col-md-5">
        <form action="" method="GET" class="d-flex gap-2">
            <input type="text" name="pesquisa" class="form-control bg-white border rounded-3" placeholder="Pesquisar por nome, modelo ou código..." value="<?php echo htmlspecialchars($termo_pesquisa); ?>">
            <button type="submit" class="btn btn-primary rounded-3"><i class="fa-solid fa-magnifying-glass"></i></button>

            <?php if (!empty($termo_pesquisa)): ?>
                <a href="/sibdas/1241251/gira/private/equipamentos/equipamentos.php" class="btn btn-light border rounded-3 text-danger"><i class="fa-solid fa-xmark"></i></a>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php
$colunas = [
    ['label' => 'Cód. Ativo', 'sort' => 'id'],
    ['label' => 'Equipamento / Modelo', 'sort' => 'nome'],
    ['label' => 'Nº Série / Património'],
    ['label' => 'Estado', 'sort' => 'estado'],
    ['label' => 'Ações', 'align' => 'end']
];

render_table_start($colunas);

// Desenhar as linhas da tabela
foreach ($lista_equipamentos as $eq):
    $cor_badge = 'success';
    if ($eq['estado'] == 'Inoperacional') $cor_badge = 'danger';
    elseif ($eq['estado'] == 'Manutenção') $cor_badge = 'warning';
?>
    <tr>
        <td class="fw-bold text-primary fw-mono"><?php echo htmlspecialchars($eq['codigo_ativo']); ?></td>
        <td>
            <div class="fw-bold"><?php echo htmlspecialchars($eq['nome']); ?></div>
            <small class="text-muted"><?php echo htmlspecialchars($eq['modelo']); ?></small>
        </td>
        <td class="fw-mono text-secondary"><?php echo htmlspecialchars($eq['num_serie']); ?></td>
        <td>
            <span class="badge bg-<?php echo $cor_badge; ?> bg-opacity-10 text-<?php echo $cor_badge; ?> rounded-pill px-2">
                <?php echo htmlspecialchars($eq['estado']); ?>
            </span>
        </td>
        <td class="text-end">
            <a href="/sibdas/1241251/gira/private/equipamentos/detalhes_equipamento.php?id=<?php echo $eq['id']; ?>" class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Consultar Equipamento">
                <i class="fa-solid fa-eye text-primary"></i>
            </a>
            <a href="/sibdas/1241251/gira/private/equipamentos/eliminar_equipamento.php?id=<?php echo $eq['id']; ?>"
                class="btn btn-light btn-sm rounded-3 border""
                data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Equipamento"
                onclick="return confirm('⚠️ ATENÇÃO: Tens a certeza absoluta que queres eliminar permanentemente o dispositivo <?php echo htmlspecialchars($eq['codigo_ativo']); ?>? Esta ação não pode ser desfeita!');">
                <i class="fa-solid fa-trash text-danger"></i>
            </a>
        </td>
    </tr>
<?php
endforeach;

if (count($lista_equipamentos) === 0):
?>
    <tr>
        <td colspan="5" class="text-center text-muted py-5">
            <i class="fa-solid fa-microscope fs-1 text-light mb-3"></i><br>
            Nenhum equipamento encontrado com a pesquisa "<b><?php echo htmlspecialchars($termo_pesquisa); ?></b>".
        </td>
    </tr>
<?php
endif;

render_table_end();
?>

<?php if ($total_paginas > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo ($pagina_atual <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link shadow-sm" href="?pagina=<?php echo $pagina_atual - 1; ?>&pesquisa=<?php echo urlencode($termo_pesquisa); ?>">Anterior</a>
            </li>

            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <li class="page-item <?php echo ($pagina_atual == $i) ? 'active' : ''; ?>">
                    <a class="page-link shadow-sm" href="?pagina=<?php echo $i; ?>&pesquisa=<?php echo urlencode($termo_pesquisa); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?php echo ($pagina_atual >= $total_paginas) ? 'disabled' : ''; ?>">
                <a class="page-link shadow-sm" href="?pagina=<?php echo $pagina_atual + 1; ?>&pesquisa=<?php echo urlencode($termo_pesquisa); ?>">Seguinte</a>
            </li>
        </ul>
    </nav>
<?php endif; ?>

<?php
render_footer();
?>