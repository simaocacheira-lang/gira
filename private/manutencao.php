<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once __DIR__ . '/layout.php';
// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Ordens de Trabalho e Manutenção");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Ordens de Trabalho e Manutenção</h2>
        <p class="text-muted m-0 small">Acompanhamento de avarias, intervenções corretivas e planos de manutenção preventiva do parque médico.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAbrirOT">
        <i class="fa-solid fa-circle-exclamation me-2"></i> Abrir Ordem de Trabalho
    </button>
</div>

<ul class="nav nav-tabs border-bottom mb-4" id="manutencaoTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="lista-tab" data-bs-toggle="tab" data-bs-target="#lista" type="button" role="tab">
            <i class="fa-solid fa-list-check me-2"></i>Intervenções Ativas (Corretivas)
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="calendario-tab" data-bs-toggle="tab" data-bs-target="#calendario" type="button" role="tab">
            <i class="fa-regular fa-calendar-days me-2"></i>Plano Preventivo (Calendário)
        </button>
    </li>
</ul>

<div class="tab-content" id="manutencaoTabsContent">

    <div class="tab-pane fade show active" id="lista" role="tabpanel" tabindex="0">
        <?php
        // 1. Definimos as colunas da tabela de Ordens de Trabalho
        $colunas = [
            ['label' => 'Nº O.T.', 'sort' => 'id_ot'],
            ['label' => 'Equipamento / Modelo', 'sort' => 'equipamento'],
            ['label' => 'Tipo de Intervenção', 'sort' => 'tipo_manutencao'],
            ['label' => 'Prioridade', 'sort' => 'prioridade'],
            ['label' => 'Abertura', 'sort' => 'data_abertura'],
            ['label' => 'Estado', 'sort' => 'status'],
            ['label' => 'Ações Técnicas', 'align' => 'end']
        ];

        // 2. Invocamos a função da tabela
        render_table_start($colunas);
        ?>

        <tr>
            <td class="fw-bold text-primary fw-mono">#OT-2026-102</td>
            <td>
                <div class="fw-bold">Ventilador Pulmonar de Alta Performance</div>
                <small class="text-muted">Urgências · Erro de fluxo de oxigénio</small>
            </td>
            <td><span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2">Corretiva (Avaria)</span></td>
            <td><span class="text-danger fw-bold"><i class="fa-solid fa-triangle-exclamation me-1"></i> Crítica</span></td>
            <td>31/05/2026</td>
            <td><span class="badge bg-danger text-white rounded-pill px-2">Pendente</span></td>
            <td class="text-end">
                <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Assumir Reparação">
                    <i class="fa-solid fa-wrench text-primary"></i>
                </button>
                <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar Ordem">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </td>
        </tr>

        <tr>
            <td class="fw-bold text-primary fw-mono">#OT-2026-098</td>
            <td>
                <div class="fw-bold">Sistema de Ultrassom / Ecógrafo</div>
                <small class="text-muted">Obstetrícia · Calibração semestral</small>
            </td>
            <td><span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-2">Preventiva Planeada</span></td>
            <td><span class="text-muted fw-medium">Média</span></td>
            <td>25/05/2026</td>
            <td><span class="badge bg-warning text-dark rounded-pill px-2">Em Curso</span></td>
            <td class="text-end">
                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Fechar Relatório Técnico">
                    <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="modal" data-bs-target="#modalFecharOT">
                        <i class="fa-solid fa-check text-success"></i>
                    </button>
                </span>
                <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar Ordem">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </td>
        </tr>

        <tr>
            <td class="fw-bold text-primary fw-mono">#OT-2026-085</td>
            <td>
                <div class="fw-bold">Monitor Multiparamétrico de Sinais Vitais</div>
                <small class="text-muted">UCI · Substituição de bateria afetada</small>
            </td>
            <td><span class="badge bg-info bg-opacity-10 text-info border border-info-subtle px-2">Verificação Técnica</span></td>
            <td><span class="text-warning fw-bold">Alta</span></td>
            <td>18/05/2026</td>
            <td><span class="badge bg-light text-muted border rounded-pill px-2">Concluída</span></td>
            <td class="text-end">
                <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar Histórico">
                    <i class="fa-solid fa-eye text-primary"></i>
                </button>
                <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Registo">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        </tr>

        <?php
        // 3. Fechamos as tags da tabela automaticamente
        render_table_end();
        ?>
    </div>

    <div class="tab-pane fade" id="calendario" role="tabpanel" tabindex="0">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-dark m-0">Maio 2026</h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-light border rounded-3 btn-sm"><i class="fa-solid fa-chevron-left"></i></button>
                    <button class="btn btn-light border rounded-3 fw-bold small text-secondary">Mês Atual</button>
                    <button class="btn btn-light border rounded-3 btn-sm"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>

            <div class="calendar-grid">
                <div class="calendar-header">Segunda</div>
                <div class="calendar-header">Terça</div>
                <div class="calendar-header">Quarta</div>
                <div class="calendar-header">Quinta</div>
                <div class="calendar-header">Sexta</div>
                <div class="calendar-header">Sábado</div>
                <div class="calendar-header">Domingo</div>

                <div class="calendar-day empty"></div>
                <div class="calendar-day empty"></div>
                <div class="calendar-day empty"></div>
                <div class="calendar-day empty"></div>

                <div class="calendar-day"><span class="day-number">1</span></div>
                <div class="calendar-day"><span class="day-number">2</span></div>
                <div class="calendar-day"><span class="day-number">3</span></div>

                <div class="calendar-day"><span class="day-number">4</span></div>
                <div class="calendar-day">
                    <span class="day-number">5</span>
                    <div class="event-badge bg-info bg-opacity-10 text-info border border-info-subtle" title="Calibração Mensal">
                        <i class="fa-solid fa-heart-pulse me-1"></i> 15 Monitores
                    </div>
                </div>
                <div class="calendar-day"><span class="day-number">6</span></div>
                <div class="calendar-day"><span class="day-number">7</span></div>
                <div class="calendar-day"><span class="day-number">8</span></div>
                <div class="calendar-day"><span class="day-number">9</span></div>
                <div class="calendar-day"><span class="day-number">10</span></div>

                <div class="calendar-day">
                    <span class="day-number">11</span>
                    <div class="event-badge bg-warning bg-opacity-10 text-dark border border-warning-subtle" title="Manutenção Semestral em Lote">
                        <i class="fa-solid fa-layer-group text-warning me-1"></i> 40 Ecógrafos (Dia 1/3)
                    </div>
                </div>
                <div class="calendar-day">
                    <span class="day-number">12</span>
                    <div class="event-badge bg-warning bg-opacity-10 text-dark border border-warning-subtle" title="Manutenção Semestral em Lote">
                        <i class="fa-solid fa-layer-group text-warning me-1"></i> 40 Ecógrafos (Dia 2/3)
                    </div>
                </div>
                <div class="calendar-day">
                    <span class="day-number">13</span>
                    <div class="event-badge bg-warning bg-opacity-10 text-dark border border-warning-subtle" title="Manutenção Semestral em Lote">
                        <i class="fa-solid fa-layer-group text-warning me-1"></i> 40 Ecógrafos (Dia 3/3)
                    </div>
                </div>
                <div class="calendar-day"><span class="day-number">14</span></div>
                <div class="calendar-day"><span class="day-number">15</span></div>
                <div class="calendar-day"><span class="day-number">16</span></div>
                <div class="calendar-day"><span class="day-number">17</span></div>

                <div class="calendar-day"><span class="day-number">18</span></div>
                <div class="calendar-day"><span class="day-number">19</span></div>
                <div class="calendar-day">
                    <span class="day-number today">20</span>
                    <div class="event-badge bg-primary bg-opacity-10 text-primary border border-primary-subtle" title="Inspeção Visual Anual">
                        <i class="fa-solid fa-bed me-1"></i> Camas Articuladas
                    </div>
                </div>
                <div class="calendar-day"><span class="day-number">21</span></div>
                <div class="calendar-day"><span class="day-number">22</span></div>
                <div class="calendar-day"><span class="day-number">23</span></div>
                <div class="calendar-day"><span class="day-number">24</span></div>

                <div class="calendar-day"><span class="day-number">25</span></div>
                <div class="calendar-day"><span class="day-number">26</span></div>
                <div class="calendar-day"><span class="day-number">27</span></div>
                <div class="calendar-day border-danger border-2 shadow-sm">
                    <span class="day-number text-danger">28</span>
                    <div class="event-badge bg-danger text-white shadow-sm" title="Revisão Obrigatória de Suporte de Vida">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i> Revisão Ventiladores BO
                    </div>
                </div>
                <div class="calendar-day"><span class="day-number">29</span></div>
                <div class="calendar-day"><span class="day-number">30</span></div>
                <div class="calendar-day"><span class="day-number">31</span></div>
            </div>

            <div class="d-flex align-items-center gap-4 mt-4 pt-3 border-top border-light">
                <span class="small fw-bold text-secondary"><i class="fa-solid fa-circle text-primary me-1" style="font-size: 0.5rem;"></i> Inspeção</span>
                <span class="small fw-bold text-secondary"><i class="fa-solid fa-circle text-warning me-1" style="font-size: 0.5rem;"></i> Intervenção em Lote</span>
                <span class="small fw-bold text-secondary"><i class="fa-solid fa-circle text-info me-1" style="font-size: 0.5rem;"></i> Calibração / Metrologia</span>
                <span class="small fw-bold text-secondary"><i class="fa-solid fa-circle text-danger me-1" style="font-size: 0.5rem;"></i> Revisão Crítica (Prioritária)</span>
            </div>
        </div>
    </div>
</div>

<?php
// Fechamos a página e injetamos os scripts
render_footer();
?>