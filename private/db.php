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
    // Se a ligação falhar, o código entra aqui e "morre" (die), mostrando o erro exato
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
