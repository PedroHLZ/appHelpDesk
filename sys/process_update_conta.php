<?php
define('MY_APP_CONFIG', true);
session_start(); // Inicia a sessão para acessar o 'user_id'

// Verificar se o formulário de atualização foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir o arquivo de configuração do banco de dados
    require_once "../config.php";

    // Verificar se o 'user_id' está definido na sessão
    if (isset($_SESSION["id"])) {
        // Obter o 'user_id' da sessão
        $user_id = $_SESSION["id"];

        // Definir variáveis para armazenar a mensagem de sucesso ou erro
        $success_message = "";
        $error_message = "";

        // Verificar se os campos obrigatórios estão definidos e não estão vazios
        if (isset($_POST["username"]) && isset($_POST["email"])) {
            // Obter os dados do formulário
            $username = $_POST["username"];
            $email = $_POST["email"];
            $sobrenome = isset($_POST["sobrenome"]) ? $_POST["sobrenome"] : "";
            $telefone = isset($_POST["telefone"]) ? $_POST["telefone"] : "";
            $endereco = isset($_POST["endereco"]) ? $_POST["endereco"] : "";
            $codigo_postal = isset($_POST["codigo_postal"]) ? $_POST["codigo_postal"] : "";

            // Preparar a consulta SQL para atualizar as informações do usuário no banco de dados
            $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, sobrenome = ?, telefone = ?, endereco = ?, codigo_postal = ? WHERE id = ?");

            // Verificar se a preparação da consulta foi bem-sucedida
            if ($stmt) {
                // Vincular os parâmetros e executar a consulta
                $stmt->bind_param("ssssssi", $username, $email, $sobrenome, $telefone, $endereco, $codigo_postal, $user_id);
                if ($stmt->execute()) {
                    $success_message = "Informações de registro atualizadas com sucesso!";
                    // Redirecionar para a página de configurações após 3 segundos
                    header("Location: {$_SERVER['HTTP_REFERER']}");
                } else {
                    // Definir uma mensagem de erro
                    $error_message = "Erro ao atualizar as informações de registro. Por favor, tente novamente.";
                }
            } else {
                $error_message = "Erro ao preparar a consulta: " . $conn->error;
            }
        } else {
            $error_message = "Por favor, preencha todos os campos obrigatórios";
        }
    } else {
        $error_message = "Não foi possível obter o ID do usuário.";
    }
} else {
    // Se o formulário não foi submetido por método POST, redirecione de volta à página de configurações
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

// Fechar a conexão com o banco de dados
$conn->close();

// Exibir mensagem de sucesso ou erro
if (!empty($success_message)) {
    echo '<div class="alert alert-success" role="alert">' . $success_message . '</div>';
} elseif (!empty($error_message)) {
    echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
}
?>
