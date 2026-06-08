<?php
// Ligar à Base de Dados
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. DETETOR DE FICHEIROS PESADOS (A causa invisível!)
    // Se o POST chegou vazio, mas existe um tamanho de conteúdo, o ficheiro era demasiado grande.
    if (empty($_POST) && empty($_FILES) && isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
        die("<div style='font-family: sans-serif; padding: 20px;'><h3>Ficheiro Demasiado Grande! 🐘</h3><p>O ficheiro que tentaste enviar ultrapassa o limite de peso do servidor (normalmente 2MB). O PHP bloqueou o upload por segurança.</p> <p><strong>Dica:</strong> Tenta anexar um PDF mais pequeno ou uma imagem de teste.</p><a href='javascript:history.back()'>Voltar atrás</a></div>");
    }

    // 2. BARREIRA DE SEGURANÇA NORMAL
    if (empty($_POST['id_equipamento'])) {
        die("<div style='font-family: sans-serif; padding: 20px;'><h3>Erro de Ligação</h3><p>O ID do equipamento não chegou ao servidor. O JavaScript não conseguiu preencher o campo escondido.</p><a href='javascript:history.back()'>Voltar atrás</a></div>");
    }

    $id_equipamento = (int) $_POST['id_equipamento'];
    $nome_doc = trim($_POST['nome_documento']);
    $tipo_doc = $_POST['tipo_documento'];

    // 3. Definir pasta de uploads
    $upload_dir = __DIR__ . '/uploads/documentos/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // 4. Processar o Ficheiro
    if (isset($_FILES['ficheiro']) && $_FILES['ficheiro']['error'] === UPLOAD_ERR_OK) {

        $extensao = strtolower(pathinfo($_FILES['ficheiro']['name'], PATHINFO_EXTENSION));
        $permitidos = ['pdf', 'jpg', 'jpeg', 'png'];

        if (!in_array($extensao, $permitidos)) {
            die("<h3>Erro de Formato</h3><p>Apenas PDF, JPG ou PNG.</p><a href='javascript:history.back()'>Voltar atrás</a>");
        }

        $novo_nome_ficheiro = 'EQ' . $id_equipamento . '_' . time() . '_' . rand(100, 999) . '.' . $extensao;
        $caminho_final = $upload_dir . $novo_nome_ficheiro;

        // 5. Mover ficheiro e gravar na BD
        if (move_uploaded_file($_FILES['ficheiro']['tmp_name'], $caminho_final)) {

            $caminho_db = 'uploads/documentos/' . $novo_nome_ficheiro;

            try {
                $sql = "INSERT INTO documentos_equipamento (equipamento_id, nome_documento, tipo_documento, caminho_ficheiro) 
                        VALUES (:id_eq, :nome, :tipo, :caminho)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':id_eq' => $id_equipamento,
                    ':nome'  => $nome_doc,
                    ':tipo'  => $tipo_doc,
                    ':caminho' => $caminho_db
                ]);

                // Sucesso! Volta e abre a aba dos documentos
                header("Location: /gira/private/equipamentos/detalhes_equipamento.php?id=" . $id_equipamento . "&sucesso=doc_adicionado&tab=documentos");
                exit;
            } catch (PDOException $e) {
                die("Erro na BD: " . $e->getMessage());
            }
        } else {
            die("Erro ao mover o ficheiro no servidor.");
        }
    } else {
        die("Erro no upload: Nenhuma imagem válida recebida ou ficheiro corrompido.");
    }
} else {
    header("Location: /gira/private/equipamentos/equipamentos.php");
    exit;
}
