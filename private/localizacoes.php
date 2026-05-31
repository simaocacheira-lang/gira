<?php
// chamar molde para trazer a Sidebar e a Topbar automáticas
require_once 'layout.php';

// Montar o topo da página com o título correto para a aba do browser
render_header("Gira - Gestão de Localizações");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Gestão de Localizações</h2>
        <p class="text-muted m-0 small">Controlo de blocos, pisos e salas onde os dispositivos médicos estão alocados.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm">
        <i class="fa-solid fa-location-plus me-2"></i> Nova Localização
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <div class="d-flex gap-2 flex-wrap">
        <button class="btn btn-light btn-sm rounded-pill px-3 active fw-bold">Todas as Áreas</button>
        <button class="btn btn-light btn-sm rounded-pill px-3 text-muted">Piso 0 (Urgências)</button>
        <button class="btn btn-light btn-sm rounded-pill px-3 text-muted">Piso 1 (Bloco Operatório)</button>
        <button class="btn btn-light btn-sm rounded-pill px-3 text-muted">Piso 2 (UCI)</button>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">

            <thead class="table-light">
                <tr class="text-muted fw-bold">
                    <th>Cód. Sala</th>
                    <th>Nome da Localização</th>
                    <th>Piso / Bloco</th>
                    <th>Equipamentos Alocados</th>
                    <th>Estado do Alerta</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td class="text-muted fw-mono">#LOC-UCI02</td>
                    <td>
                        <div class="fw-bold">Unidade de Cuidados Intensivos (UCI)</div>
                        <small class="text-muted">Sala 2 - Camas 5 a 8</small>
                    </td>
                    <td>Piso 2 - Bloco Central</td>
                    <td><span class="fw-bold text-primary">14 equipamentos</span></td>
                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Normal</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" title="Editar"><i class="fa-solid fa-pen text-muted"></i></button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" title="Eliminar"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>

                <tr>
                    <td class="text-muted fw-mono">#LOC-BO03</td>
                    <td>
                        <div class="fw-bold">Bloco Operatório (BO3)</div>
                        <small class="text-muted">Sala de Cirurgia Geral 3</small>
                    </td>
                    <td>Piso 1 - Bloco Cirúrgico</td>
                    <td><span class="fw-bold text-primary">22 equipamentos</span></td>
                    <td><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2">1 Crítico</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" title="Editar"><i class="fa-solid fa-pen text-muted"></i></button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" title="Eliminar"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>

                <tr>
                    <td class="text-muted fw-mono">#LOC-URG01</td>
                    <td>
                        <div class="fw-bold">Serviço de Urgência</div>
                        <small class="text-muted">Sala de Reanimação (Trauma 1)</small>
                    </td>
                    <td>Piso 0 - Entrada Norte</td>
                    <td><span class="fw-bold text-primary">9 equipamentos</span></td>
                    <td><span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2">1 Manutenção</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" title="Editar"><i class="fa-solid fa-pen text-muted"></i></button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" title="Eliminar"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

<script>
    //Iluminar "Localizações" na sidebar para indicar que estamos nessa secção
    // Remove o 'active' do link do Dashboard e coloca-o no link da Área Pública
    document.querySelectorAll('.sidebar-link').forEach(link => link.classList.remove('active'));
    // Procura o link que vai para o backoffice e ativa-o
    document.querySelector('a[href="localizacoes.php"]').classList.add('active');
</script>
<?php
// 3. chamar fim do molde para fechar as tags e aplicar os scripts automáticos
render_footer();
?>