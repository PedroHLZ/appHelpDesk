<?php
define('MY_APP_CONFIG', true);
session_start();

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir o arquivo de configuração do banco de dados
    require_once "../config.php";

    // Definir variáveis para armazenar a mensagem de sucesso ou erro
    $success_message = "";
    $error_message = "";

    // Verificar se os campos obrigatórios estão definidos e não estão vazios
    if (isset($_POST["password"]) && isset($_POST["confirm_password"]) && isset($_POST["user_id"])) {
        // Obter os dados do formulário
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        $user_id = $_POST["user_id"];

        // Verificar se as senhas coincidem
        if ($password === $confirm_password) {
            // Hash da senha
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Preparar a consulta SQL para atualizar a senha do usuário logado no banco de dados
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");

            // Verificar se a preparação da consulta foi bem-sucedida
            if ($stmt) {
                // Vincular os parâmetros e executar a consulta
                $stmt->bind_param("si", $hashed_password, $user_id);
                if ($stmt->execute()) {
                    $success_message = "Senha atualizada com sucesso!";
                    // Redirecionar para a página index.php após 3 segundos
                    header("Location: {$_SERVER['HTTP_REFERER']}");
                } else {
                    // Definir uma mensagem de erro
                    $error_message = "Erro ao atualizar a senha. Por favor, tente novamente.";
                }
            } else {
                $error_message = "Erro ao preparar a consulta: " . $conn->error;
            }
        } else {
            $error_message = "As senhas não coincidem";
        }
    } else {
        $error_message = "Por favor, preencha todos os campos obrigatórios";
    }

    // Fechar a conexão com o banco de dados
    $conn->close();

    // Exibir mensagem de sucesso ou erro
    if (!empty($success_message)) {
        echo '<div class="alert alert-success" role="alert">' . $success_message . '</div>';
    } elseif (!empty($error_message)) {
        echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
    }
} else {
    // Se o formulário não foi submetido por método POST, redirecione de volta à página de registro
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
?>
