// Tooltips
document.addEventListener("DOMContentLoaded", function () {
    // Inicializa todos os Tooltips (balões de ajuda) do Bootstrap automaticamente na página
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Modais

// Lógica para o Stepper do Modal de registo de equipamento
document.addEventListener('DOMContentLoaded', function () {
    let currentStep = 1;
    const totalSteps = 5;

    const btnNext = document.getElementById('btnStepperNext');
    const btnPrev = document.getElementById('btnStepperPrev');
    const btnSubmit = document.getElementById('btnStepperSubmit');
    const progressBar = document.getElementById('stepperProgressBar');

    // Se o modal não for aberto na dashboard, esta função evita erros de JS noutros elementos
    if (!btnNext) return;

    function updateStepper() {
        for (let i = 1; i <= totalSteps; i++) {
            document.getElementById(`step-${i}`).classList.add('d-none');
            let indicator = document.getElementById(`ind-step-${i}`);
            if (i <= currentStep) {
                indicator.classList.remove('bg-white', 'text-secondary', 'border');
                indicator.classList.add('bg-primary', 'text-white', 'shadow-sm');
            } else {
                indicator.classList.remove('bg-primary', 'text-white', 'shadow-sm');
                indicator.classList.add('bg-white', 'text-secondary', 'border');
            }
        }

        document.getElementById(`step-${currentStep}`).classList.remove('d-none');

        let progressPercentage = ((currentStep - 1) / (totalSteps - 1)) * 100;
        progressBar.style.width = progressPercentage + '%';

        if (currentStep === 1) {
            btnPrev.classList.add('d-none');
        } else {
            btnPrev.classList.remove('d-none');
        }

        if (currentStep === totalSteps) {
            btnNext.classList.add('d-none');
            btnSubmit.classList.remove('d-none');
        } else {
            btnNext.classList.remove('d-none');
            btnSubmit.classList.add('d-none');
        }
    }

    btnNext.addEventListener('click', function () {
        if (currentStep < totalSteps) {
            currentStep++;
            updateStepper();
        }
    });

    btnPrev.addEventListener('click', function () {
        if (currentStep > 1) {
            currentStep--;
            updateStepper();
        }
    });

    document.getElementById('modalRegistarEquipamento').addEventListener('hidden.bs.modal', function () {
        currentStep = 1;
        document.getElementById('formNovoEquipamento').reset();
        updateStepper();
    });
});

// ==============================================================================
// LÓGICA DE PERSONALIZAÇÃO DINÂMICA DAS AÇÕES RÁPIDAS (DASHBOARD)
// ==============================================================================

// 1. Mapeamento entre o ID de cada Checkbox e o ID de cada Botão de Ação
const mapeamentoAtalhos = {
    'favEq': 'btnAcaoEquipamentos',
    'favMan': 'btnAcaoManutencao',
    'favDoc': 'btnAcaoDocumentos',
    'favForn': 'btnAcaoFornecedores',
    'favGar': 'btnAcaoGarantias',
    'favLoc': 'btnAcaoLocalizacoes',
    'favRel': 'btnAcaoRelatorios',
    'favUtil': 'btnAcaoUtilizadores',
    'favPerf': 'btnAcaoPerfis',
    'favArm': 'btnAcaoArmazem'
};

// 2. Função que lê o estado de uma Checkbox e esconde/mostra o botão
function alternarAtalho(checkboxId, botaoid) {
    const checkbox = document.getElementById(checkboxId);
    const botao = document.getElementById(botaoid);

    if (!checkbox || !botao) return; // Salvaguarda caso os elementos não existam na página

    if (checkbox.checked) {
        botao.classList.remove('d-none');
    } else {
        botao.classList.add('d-none');
    }
}

// 3. Ouvir as mudanças em cada Checkbox do Dropdown
Object.keys(mapeamentoAtalhos).forEach(checkboxId => {
    const checkbox = document.getElementById(checkboxId);
    if (checkbox) {
        checkbox.addEventListener('change', function () {
            // Executa a alternância visual na hora
            alternarAtalho(checkboxId, mapeamentoAtalhos[checkboxId]);

            // BÓNUS PREMIUM: Guarda a escolha no LocalStorage do browser
            // Assim, mesmo que atualizes a página (F5), o hospital lembra-se da tua escolha!
            localStorage.setItem(`gira_atalho_${checkboxId}`, checkbox.checked);
        });
    }
});

// 4. Recuperar as preferências guardadas sempre que a Dashboard é carregada
Object.keys(mapeamentoAtalhos).forEach(checkboxId => {
    const estadoGuardado = localStorage.getItem(`gira_atalho_${checkboxId}`);
    const checkbox = document.getElementById(checkboxId);

    if (checkbox && estadoGuardado !== null) {
        // Converte a string do localStorage de volta para um Booleano (true/false)
        checkbox.checked = (estadoGuardado === 'true');
        // Aplica o estado visual inicial ao botão
        alternarAtalho(checkboxId, mapeamentoAtalhos[checkboxId]);
    }
});