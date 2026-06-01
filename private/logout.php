<?php
// 1. Inicia ou recupera a sessão existente para podermos manipulá-la
session_start();

// 2. Limpa todas as variáveis de sessão guardadas na memória do servidor
$_SESSION = array();

// 3. Se a aplicação utilizar cookies de sessão (padrão do PHP), destrói o cookie no browser do utilizador
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// 4. Destrói a sessão no servidor por completo
session_destroy();

// 5. Redireciona o utilizador de volta para a página de login pública
header("Location: ../public/login.php");
exit;
?>