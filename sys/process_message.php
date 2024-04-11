<?php
define('MY_APP_CONFIG', true);
// Iniciar a sessão (se ainda não estiver iniciada)
session_start();

// Verificar se o usuário está logado e tem o nível de acesso adequado
if (!isset($_SESSION['id']) || $_SESSION['level'] < 1) {
    // Redirecionar para a página de login se o usuário não estiver logado ou não tiver acesso suficiente
    header("Location: ../index.php");
    exit;
}

// Incluir o arquivo de configuração do banco de dados
require_once "../config.php";

// Verificar se o formulário de envio de mensagem foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_message"])) {
    // Obter os dados do formulário
    $ticket_id = $_POST["ticket_id"];
    $message = $_POST["message"];

    // Estabelecer a conexão com o banco de dados
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Verificar se houve algum erro na conexão
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    // Verificar se o chat existe para o ticket atual
    $stmt_chat = $conn->prepare("SELECT id FROM chats WHERE ticket_id = ?");
    $stmt_chat->bind_param("i", $ticket_id);
    $stmt_chat->execute();
    $chat_result = $stmt_chat->get_result();

    if ($chat_result->num_rows > 0) {
        // O chat existe, obter o ID do chat
        $chat_row = $chat_result->fetch_assoc();
        $chat_id = $chat_row['id'];

        // Inserir a mensagem no banco de dados
        $stmt_message = $conn->prepare("INSERT INTO messages (chat_id, user_id, message, created_at) VALUES (?, ?, ?, NOW())");
        $stmt_message->bind_param("iis", $chat_id, $_SESSION['id'], $message);
        $stmt_message->execute();

        if ($stmt_message->affected_rows > 0) {
            // A mensagem foi inserida com sucesso
        } else {
            // Houve um erro ao inserir a mensagem
        }

        $stmt_message->close();
    } else {
        // Não foi possível encontrar o chat para este ticket
        echo "Não foi possível encontrar o chat para este ticket.";
    }

    $stmt_chat->close();
    $conn->close();
}
?>
