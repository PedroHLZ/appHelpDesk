<?php
define('MY_APP_CONFIG', true);
session_start();

// Verificar se o formulário de abertura de ticket foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter os dados do formulário
    $titulo = $_POST["titulo"];
    $descricao = $_POST["descricao"];
    $user_id = $_SESSION['id'];

    // Incluir o arquivo de configuração do banco de dados
    require_once "config.php";

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
        die("Erro na preparação da consulta: " . $conn->error);
    }

    // Vincular os parâmetros à consulta preparada e executar a consulta
    $stmt->bind_param("ssi", $titulo, $descricao, $user_id);
    $stmt->execute();

    // Verificar se o ticket foi aberto com sucesso
    if ($stmt->affected_rows > 0) {
        // Obtém o ID do ticket inserido
        $ticket_id = $stmt->insert_id;

        // Insere um registro na tabela chats associado ao ID do ticket
        $stmt_chat = $conn->prepare("INSERT INTO chats (ticket_id) VALUES (?)");
        $stmt_chat->bind_param("i", $ticket_id);
        $stmt_chat->execute();
        
        // Redireciona para a página de tickets ou exibe uma mensagem de sucesso
        header("Location: tickets.php");
        exit();
    } else {
        // Se houver um erro ao abrir o ticket, redireciona para a página de abertura de ticket com uma mensagem de erro
        header("Location: openticket.php?error=Erro ao abrir o ticket.");
        exit();
    }

    // Fechar as consultas preparadas e a conexão com o banco de dados
    $stmt->close();
    $stmt_chat->close();
    $conn->close();
} else {
    // Se o formulário não foi submetido, redireciona para a página de abertura de ticket
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
?>
