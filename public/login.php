<?php
// 1. Iniciar a "Sessão" (para o servidor se lembrar de quem entrou)
session_start();

// Se o utilizador já estiver logado, redireciona logo para o dashboard (CAMINHO ABSOLUTO URL)
if (isset($_SESSION['user_id'])) {
    header("Location: /gira/private/dashboard.php");
    exit;
}

$erro = ""; // Variável para guardar mensagens de erro

// 2. Verificar se o formulário foi submetido (se clicaram no botão "Entrar")
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CAMINHO ABSOLUTO DE SERVIDOR PARA INCLUDES (Blindado)
    require_once __DIR__ . '/../private/db.php';

    // Apanhar o que foi escrito nos campos (com proteção contra espaços vazios)
    $email = trim($_POST['email'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    if (!empty($email) && !empty($pass)) {
        // 3. Procurar o utilizador na base de dados usando o EMAIL
        $sql = "SELECT id, email, password_hash, nome, estado FROM utilizadores WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $utilizador = $stmt->fetch();

        // 4. Se o utilizador existir, testar se a password bate certo com o Hash!
        if ($utilizador && password_verify($pass, $utilizador['password_hash'])) {

            // 5. BARREIRA DE SEGURANÇA: Verificar se a conta não está suspensa
            if ($utilizador['estado'] === 'Suspenso') {
                $erro = "Acesso negado. Esta conta encontra-se suspensa.";
            } else {
                // SUCESSO ABSOLUTO! Guardar os dados do utilizador na memória da sessão
                $_SESSION['user_id'] = $utilizador['id'];
                $_SESSION['email'] = $utilizador['email'];
                $_SESSION['nome'] = $utilizador['nome'];

                // Redirecionar para o Dashboard (CAMINHO ABSOLUTO URL)
                header("Location: /gira/private/dashboard.php");
                exit;
            }
        } else {
            $erro = "E-mail ou palavra-passe incorretos.";
        }
    } else {
        $erro = "Por favor, preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gira Inventory</title>

    <link rel="stylesheet" href="/gira/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/gira/assets/css/all.min.css">
    <link rel="stylesheet" href="/gira/assets/css/1241251.css">
</head>

<body class="vh-100 d-flex align-items-center justify-content-center login-bg">

    <div class="login-card p-3">
        <div class="text-center mb-4">
            <a href="/gira/public/index.html" class="text-decoration-none">
                <h1 class="fw-bold text-primary mb-1">
                    <i class="fa-solid fa-notes-medical me-2"></i>Gira
                </h1>
            </a>
            <p class="text-secondary small">Gestão de Inventário Hospitalar</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <h4 class="fw-bold text-dark mb-4 text-center">Acesso Restrito</h4>

                <form action="/gira/public/login.php" method="POST">
                    <?php if (!empty($erro)): ?>
                        <div class="alert alert-danger text-center small mb-3">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> <?php echo $erro; ?>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="email" class="form-label small fw-bold text-secondary">E-mail de Acesso *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                            <input type="email" class="form-control bg-light border-start-0" id="email" name="email" placeholder="nome@hospital.pt" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label small fw-bold text-secondary">Palavra-passe *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                            <input type="password" class="form-control bg-light border-start-0" id="password" name="password" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 mb-3 shadow-sm">
                        Entrar <i class="fa-solid fa-right-to-bracket ms-2"></i>
                    </button>

                    <div class="text-center">
                        <a href="/gira/public/index.html" class="text-decoration-none small text-muted">
                            <i class="fa-solid fa-arrow-left me-1"></i> Voltar à página inicial
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center mt-4">
            <p class="small text-muted">&copy; 2026 Gira Solutions. <br>Sistema de Apoio ao Inventário Hospitalar.</p>
        </div>
    </div>

    <script src="/gira/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/gira/assets/js/1241251.js"></script>
</body>

</html>