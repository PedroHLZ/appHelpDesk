<?php
echo ' process_valida_login.php carregado';
session_start();

// Incluir o arquivo de configuração do banco de dados
require_once "../config.php";

// Inicializar mensagem de erro
$erro = "";

// Variável para armazenar o ID do usuário logado
$user_id = null;

// Verificar se o formulário de login foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter os dados do formulário
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Preparar a consulta SQL para buscar o usuário no banco de dados
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    // Executar a consulta
    $stmt->execute();

    // Obter o resultado da consulta
    $result = $stmt->get_result();

    // Verificar se o usuário foi encontrado
    if ($result->num_rows == 1) {
        // Obter os dados do usuário
        $usuario = $result->fetch_assoc();

        // Verificar se a senha está correta
        if (password_verify($senha, $usuario["password"])) {
            // Definir a sessão como autenticada
            $_SESSION["autenticado"] = "SIM";
            $_SESSION["id"] = $usuario["id"]; // Armazenar o ID do usuário na sessão
            $_SESSION["email"] = $usuario["email"];
            $_SESSION["level"] = $usuario["level"];
            
            // Armazenar o ID do usuário logado na variável
            $user_id = $usuario["id"];

            // Redirecionar com base no nível de acesso do usuário
            if ($usuario["level"] == 1) { // Se level for 1, é um usuário normal
                header("Location: $enderecodosite/dashboard
                ");
                exit();
            } elseif ($usuario["level"] == 2) { // Se level for 2, é um administrador
                header("Location: $enderecodosite/suportdashboard");
                exit();
            }
        } else {
            // Senha incorreta
            $erro = "Senha incorreta.";
        }
    } else {
        // Usuário não encontrado
        $erro = "Usuário não cadastrado.";
    }

    // Redirecionar para o index.php com mensagem de erro, se houver
    header("Location: ../index.php?login=erro&mensagem=" . urlencode($erro));
    exit();
} else {
    // Redirecionar para a página de login se o formulário não foi submetido
    header("Location: ../index.php");
    exit();
}
?>
