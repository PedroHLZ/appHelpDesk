<?php
define('MY_APP_CONFIG', true);
// Iniciar a sessão (se ainda não estiver iniciada)
session_start();

// Verificar se o usuário está logado e tem o nível de acesso adequado
if (!isset($_SESSION['id']) || $_SESSION['level'] < 1) {
    // Redirecionar para a página de login se o usuário não estiver logado ou não tiver acesso suficiente
    header("Location: login.php");
    exit;
}

// Incluir o arquivo de configuração do banco de dados
require_once "../config.php";

// Verificar se o formulário de abertura de ticket foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter os dados do formulário
    $titulo = $_POST["titulo"];
    $descricao = $_POST["descricao"];

    // Obter o ID do usuário da sessão
    $user_id = $_SESSION['id'];

    // Estabelecer a conexão com o banco de dados
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Verificar se houve algum erro na conexão
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    // Preparar a consulta SQL para inserir um novo ticket no banco de dados
    $stmt = $conn->prepare("INSERT INTO tickets (titulo, descricao, status, data_abertura, user_id) VALUES (?, ?, 'Aberto', NOW(), ?)");

    // Verificar se a preparação da consulta foi bem-sucedida
    if ($stmt === false) {
        // Se houver um erro na preparação da consulta, exibir uma mensagem de erro
        die("Erro na preparação da consulta: " . $conn->error);
    }

    // Vincular os parâmetros à consulta preparada e executar a consulta
    $stmt->bind_param("ssi", $titulo, $descricao, $user_id);
    $stmt->execute();

    // Verificar se o ticket foi aberto com sucesso
    if ($stmt->affected_rows > 0) {
        // Inserir um registro na tabela chats associado ao ID do ticket
        $ticket_id = $stmt->insert_id;
        $insert_chat_query = "INSERT INTO chats (ticket_id) VALUES ($ticket_id)";
        if ($conn->query($insert_chat_query) === true) {
            // Inserir uma mensagem inicial informando que o ticket foi aberto
            $message = "O ticket foi aberto.";
            $chat_id = $conn->insert_id;
            $insert_message_query = "INSERT INTO messages (chat_id, user_id, message, created_at) VALUES ($chat_id, $user_id, '$message', NOW())";
            $conn->query($insert_message_query);
            // Redirecionar para a página de usuário com uma mensagem de sucesso
            header("Location: userdashboard.php?message=Ticket aberto com sucesso.");
            exit;
        } else {
            // Se houver um erro ao inserir o registro de chat, exibir uma mensagem de erro
            header("Location: openticket.php?error=Erro ao abrir o ticket.");
            exit;
        }
    } else {
        // Se houver um erro ao abrir o ticket, exibir uma mensagem de erro
        header("Location: openticket.php?error=Erro ao abrir o ticket.");
        exit;
    }

    // Fechar a conexão com o banco de dados
    $conn->close();
} else {
    // Redirecionar de volta para a página de abertura de ticket se o formulário não foi submetido
    header("Location: openticket.php");
    exit;
}
?>
