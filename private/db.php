<?php
// 1. Definir as "Coordenadas" da Base de Dados, ou seja, as informações necessárias para o PHP se conectar à base de dados
$host = '127.0.0.1';           // O endereço do teu servidor local (Laragon)
$dbname = 'gira_inventario';   // Nome da bd
$username = 'root';            // O utilizador padrão do Laragon
$password = '';                // O Laragon, por defeito, não tem palavra-passe definida

// 2. Tentar fazer a ligação (Try / Catch) - tenta (try) fazer a ligação. Se houver algum problema (por exemplo, o Laragon estar desligado), em vez de o site explodir com erros feios, apanha (catch) o erro e mostra uma mensagem limpa."
try {
    // Criar a nova ligação PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // 3. Configurações adicionais para a ligação PDO
    // Obrigar o PHP a mostrar-nos os erros da base de dados caso algo corra mal
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Definir que queremos receber os dados da base de dados num formato fácil de ler (Array Associativo)
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Se a ligação falhar, o código entra aqui e "morre" (die), mostrando o erro
    die("Erro crítico de ligação à base de dados: " . $e->getMessage());
}

// ============================================================================
// FUNÇÃO GLOBAL DE AUDITORIA (LOGS) - AGORA PREPARADA PARA SOFT DELETES!
// ============================================================================
function registar_log($pdo, $utilizador_id, $acao, $modulo, $tabela_afetada = null, $registo_id = null)
{
    // 1. Forçar o fuso horário de Portugal
    date_default_timezone_set('Europe/Lisbon');
    $agora = date('Y-m-d H:i:s');

    // 2. Apanhar IP
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Desconhecido';

    try {
        // Inserimos os novos campos tabela_afetada e registo_id para permitir o restauro
        $sql = "INSERT INTO logs_auditoria (data_hora, utilizador_id, acao, modulo, ip_origem, tabela_afetada, registo_id) 
                VALUES (:agora, :user, :acao, :mod, :ip, :tabela, :reg_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':agora'  => $agora,
            ':user'   => $utilizador_id,
            ':acao'   => $acao,
            ':mod'    => $modulo,
            ':ip'     => $ip,
            ':tabela' => $tabela_afetada,
            ':reg_id' => $registo_id
        ]);
    } catch (PDOException $e) {
        // Falha silenciosa
    }
}
function exibir_erros_modal($id_modal_alvo)
{
    // Verifica se há erros e se o modal que falhou é este
    if (isset($_SESSION['modal_aberto']) && $_SESSION['modal_aberto'] === $id_modal_alvo && !empty($_SESSION['erros'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">';
        echo '<i class="fa-solid fa-triangle-exclamation me-2 fs-5"></i><strong class="fs-6">Verifique os seguintes erros:</strong><ul class="mb-0 mt-2 fw-medium">';
        foreach ($_SESSION['erros'] as $erro) {
            echo '<li>' . htmlspecialchars($erro) . '</li>';
        }
        echo '</ul><button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button></div>';

        unset($_SESSION['erros']); // Limpa os erros após mostrar
    }
}

// ============================================================================
// FUNÇÕES GLOBAIS DE VALIDAÇÃO (Reutilizáveis em todo o projeto)
// ============================================================================

function validar_texto_obrigatorio($texto, $max_length, $nome_campo)
{
    $texto = trim($texto);
    if (empty($texto)) return "O campo '$nome_campo' é obrigatório.";
    if (strlen($texto) > $max_length) return "O '$nome_campo' excede o limite de $max_length caracteres.";
    return null; // Retorna null se estiver tudo bem
}

function validar_nif($nif)
{
    $nif = trim($nif);
    // Regex: Exatamente 9 dígitos numéricos
    if (!preg_match('/^\d{9}$/', $nif)) return "O NIF inserido é inválido (deve conter exatamente 9 números).";
    return null;
}

function validar_email_opcional($email)
{
    $email = trim($email);
    // O PHP faz o trabalho pesado de validar o e-mail sem precisarmos de Regex
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) return "O formato do e-mail inserido é inválido.";
    return null;
}
function validar_email_obrigatorio($email)
{
    $email = trim($email);
    if (empty($email)) {
        return "O E-mail de Suporte é um campo obrigatório.";
    }
    // O PHP tem uma função nativa maravilhosa para validar o formato de emails
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "O formato do e-mail inserido é inválido.";
    }
    return null;
}

function validar_telefone_opcional($telefone)
{
    $telefone = trim($telefone);
    if (empty($telefone)) return null; // Como é opcional, se estiver vazio passa.

    // Limpa os espaços para o caso de o utilizador escrever "912 345 678"
    $telefone_limpo = str_replace(' ', '', $telefone);

    // Regex: Aceita 9 dígitos numéricos, podendo ter ou não o prefixo +351
    if (!preg_match('/^(?:\+351)?\d{9}$/', $telefone_limpo)) {
        return "O contacto telefónico é inválido (deve conter 9 dígitos).";
    }
    return null;
}
function validar_telefone_obrigatorio($telefone)
{
    $telefone = trim($telefone);
    if (empty($telefone)) {
        return "O Contacto Telefónico é um campo obrigatório.";
    }
    // Expressão Regular (Regex) para garantir que são inseridos exatamente 9 números
    if (!preg_match('/^[0-9]{9}$/', $telefone)) {
        return "O telefone de suporte deve conter exatamente 9 dígitos numéricos.";
    }
    return null;
}
function validar_mac_opcional($mac)
{
    $mac = trim($mac);
    if (empty($mac)) return null;
    // Regex: Verifica se é um MAC Address válido (ex: 00:1A:2B:3C:4D:5E ou 00-1A-2B-3C-4D-5E)
    if (!preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', $mac)) {
        return "O Endereço MAC tem um formato inválido (Ex: 00:1A:2B:3C:4D:5E).";
    }
    return null;
}

function validar_password_forte($password)
{
    if (empty($password)) return "A palavra-passe é obrigatória.";
    if (strlen($password) < 6 || strlen($password) > 12) {
        return "A palavra-passe deve ter entre 6 e 12 caracteres.";
    }
    return null;
}
function validar_codigo_sala($codigo)
{
    $codigo = trim($codigo);
    if (empty($codigo)) {
        return "O Código da Sala é de preenchimento obrigatório.";
    }
    if (!preg_match('/^S-[0-9]{3}$/', $codigo)) {
        return "O Código da Sala tem um formato inválido. Deve seguir o padrão 'S-xxx' (Ex: S-014, S-999).";
    }
    return null;
}
function validar_nome_localizacao($nome)
{
    $nome = trim($nome);
    if (empty($nome)) {
        return "O Nome da Sala / Serviço é de preenchimento obrigatório.";
    }
    if (strlen($nome) > 100) {
        return "O Nome da Sala não pode ultrapassar os 100 caracteres.";
    }
    return null;
}
// ============================================================================
// VALIDAÇÕES DE DOMÍNIO - MANUTENÇÃO (Ordens de Trabalho)
// ============================================================================

function validar_selecao_equipamento($id_equipamento)
{
    if (empty($id_equipamento) || !is_numeric($id_equipamento) || $id_equipamento <= 0) {
        return "É obrigatório selecionar o equipamento alvo da intervenção.";
    }
    return null;
}

function validar_descricao_avaria($descricao)
{
    $descricao = trim($descricao);
    if (empty($descricao)) {
        return "A descrição dos sintomas / avaria é de preenchimento obrigatório.";
    }
    if (strlen($descricao) < 5) {
        return "A descrição da avaria é demasiado curta. Por favor, detalhe mais o problema.";
    }
    return null;
}

function validar_relatorio_tecnico($relatorio)
{
    $relatorio = trim($relatorio);
    if (empty($relatorio)) {
        return "O Relatório Técnico do trabalho realizado é obrigatório para fechar a O.T.";
    }
    return null;
}

function validar_tempo_gasto($tempo)
{
    if (empty($tempo) || !is_numeric($tempo) || $tempo <= 0) {
        return "O tempo gasto na intervenção tem de ser um valor superior a 0 horas.";
    }
    return null;
}
// ============================================================================
// VALIDAÇÕES DE DOMÍNIO - UTILIZADORES
// ============================================================================

function validar_nome_utilizador($nome)
{
    $nome = trim($nome);
    if (empty($nome)) {
        return "O Nome Completo é de preenchimento obrigatório.";
    }
    // Verifica se o nome contém algum dígito numérico (0 a 9)
    if (preg_match('/[0-9]/', $nome)) {
        return "O campo Nome não pode conter números (Validação Ficha 13).";
    }
    if (strlen($nome) > 100) {
        return "O Nome não pode exceder os 100 caracteres.";
    }
    return null;
}

function validar_cedula_opcional($cedula)
{
    $cedula = trim($cedula);
    if (empty($cedula)) return null;
    if (strlen($cedula) > 20) {
        return "A Cédula Profissional inserida é demasiado longa.";
    }
    return null;
}

function validar_selecao_perfil($perfil_id)
{
    if (empty($perfil_id) || !is_numeric($perfil_id) || $perfil_id <= 0) {
        return "É obrigatório selecionar um Perfil de Acesso válido para este utilizador.";
    }
    return null;
}
// ============================================================================
// VALIDAÇÕES DE DOMÍNIO - PERFIS DE ACESSO
// ============================================================================

function validar_nome_perfil($nome)
{
    $nome = trim($nome);
    if (empty($nome)) {
        return "O Nome do Perfil é de preenchimento obrigatório.";
    }
    if (strlen($nome) > 50) {
        return "O Nome do Perfil não pode exceder os 50 caracteres.";
    }
    return null;
}

function validar_nivel_acesso($nivel)
{
    $niveis_validos = [1, 2, 3];
    if (empty($nivel) || !in_array((int)$nivel, $niveis_validos)) {
        return "Deve selecionar um nível de acesso válido (1, 2 ou 3).";
    }
    return null;
}
// ============================================================================
// VALIDAÇÕES DE DOMÍNIO - DOCUMENTOS TÉCNICOS
// ============================================================================

function validar_nome_documento($nome)
{
    $nome = trim($nome);
    if (empty($nome)) {
        return "O Nome / Título do documento é de preenchimento obrigatório.";
    }
    if (strlen($nome) > 100) {
        return "O título do documento não pode exceder os 100 caracteres.";
    }
    return null;
}

function validar_tipo_documento($tipo)
{
    $tipos_validos = ['Manual Técnico', 'Certificado Conformidade (CE)', 'Guia de Calibração', 'Outro'];
    if (empty($tipo) || !in_array($tipo, $tipos_validos)) {
        return "Deve selecionar um Tipo de Documento válido.";
    }
    return null;
}
// ============================================================================
// VALIDAÇÕES DE DOMÍNIO - GARANTIAS
// ============================================================================

function validar_data_garantia($data)
{
    if (empty($data)) {
        return "A Data de Fim de Garantia é de preenchimento obrigatório.";
    }
    // Verifica se é uma data real reconhecida pelo PHP
    if (!strtotime($data)) {
        return "O formato da data inserida é inválido.";
    }
    return null;
}
// ============================================================================
// MODELOS DE EXTRAÇÃO DE DADOS (SEPARAÇÃO DE CAMADAS - MVC)
// ============================================================================

function obterTodosUtilizadores($pdo)
{
    $sql = "SELECT u.*, p.nome_perfil 
            FROM utilizadores u
            LEFT JOIN perfis_acesso p ON u.perfil_id = p.id
            WHERE u.apagado_em IS NULL
            ORDER BY u.id DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function obterTodosEquipamentos($pdo)
{
    $sql = "SELECT e.*, l.cod_sala, l.nome AS nome_localizacao, f.nome_empresa 
            FROM equipamentos e 
            LEFT JOIN localizacoes l ON e.localizacao_id = l.id 
            LEFT JOIN fornecedores f ON e.fornecedor_id = f.id 
            WHERE e.apagado_em IS NULL
            ORDER BY e.id DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}
function obterTodosArtigos($pdo)
{
    $sql = "SELECT a.*, f.nome_empresa 
            FROM artigos_armazem a 
            LEFT JOIN fornecedores f ON a.fornecedor_id = f.id 
            WHERE a.apagado_em IS NULL
            ORDER BY a.nome ASC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function obterTodosDocumentos($pdo)
{
    $sql = "SELECT d.*, e.codigo_ativo, e.nome AS equipamento_nome 
            FROM documentos_equipamento d
            LEFT JOIN equipamentos e ON d.equipamento_id = e.id
            WHERE d.apagado_em IS NULL
            ORDER BY d.data_upload DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function obterTodosFornecedores($pdo)
{
    $sql = "SELECT * FROM fornecedores WHERE apagado_em IS NULL ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}
function obterGarantias($pdo)
{
    $sql = "SELECT e.id, e.codigo_ativo, e.nome, e.modelo, e.fim_garantia, f.nome_empresa 
            FROM equipamentos e
            LEFT JOIN fornecedores f ON e.fornecedor_id = f.id
            WHERE e.fim_garantia IS NOT NULL AND e.apagado_em IS NULL
            ORDER BY e.fim_garantia ASC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function obterHistorico($pdo)
{
    $sql = "SELECT l.*, u.nome AS nome_utilizador, p.nome_perfil 
            FROM logs_auditoria l
            LEFT JOIN utilizadores u ON l.utilizador_id = u.id
            LEFT JOIN perfis_acesso p ON u.perfil_id = p.id
            ORDER BY l.data_hora DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function obterLocalizacoes($pdo)
{
    $sql = "SELECT * FROM localizacoes WHERE apagado_em IS NULL ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function obterOrdensTrabalho($pdo)
{
    $sql = "SELECT ot.*, e.nome AS equip_nome, e.modelo AS equip_modelo 
            FROM ordens_trabalho ot
            LEFT JOIN equipamentos e ON ot.equipamento_id = e.id
            WHERE ot.apagado_em IS NULL
            ORDER BY ot.id DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function obterRevisoesPreventivas($pdo)
{
    $sql = "SELECT e.id, e.codigo_ativo, e.nome, e.proxima_revisao, l.cod_sala 
            FROM equipamentos e 
            LEFT JOIN localizacoes l ON e.localizacao_id = l.id 
            WHERE e.proxima_revisao IS NOT NULL AND e.apagado_em IS NULL 
            ORDER BY e.proxima_revisao ASC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}
function obterMeuPerfil($pdo, $user_id)
{
    $sql = "SELECT u.*, p.nome_perfil, p.nivel_acesso 
            FROM utilizadores u 
            LEFT JOIN perfis_acesso p ON u.perfil_id = p.id 
            WHERE u.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $user_id]);
    return $stmt->fetch();
}

function obterTodosPerfis($pdo)
{
    $sql = "SELECT p.*, COUNT(u.id) as total_users 
            FROM perfis_acesso p
            LEFT JOIN utilizadores u ON p.id = u.perfil_id AND u.apagado_em IS NULL
            WHERE p.apagado_em IS NULL
            GROUP BY p.id
            ORDER BY p.nivel_acesso DESC, p.nome_perfil ASC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function obterConteudosSite($pdo)
{
    $stmt = $pdo->query("SELECT chave, texto FROM conteudos_site");
    $resultados = $stmt->fetchAll();

    $conteudos = [];
    foreach ($resultados as $row) {
        $conteudos[$row['chave']] = $row['texto'];
    }
    return $conteudos;
}
