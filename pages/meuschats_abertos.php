<?php
define('MY_APP_CONFIG', true);
session_start();
// Incluir o arquivo de configuração do banco de dados
require_once "../config.php";
require_once "../engine.php";

// Verificar se o usuário está logado e tem o nível de acesso adequado
if (!isset($_SESSION['id'])) {
    // Se não estiver logado, redirecione para a página de login
    header("Location: login.php");
    exit;
}

// Verificar o nível de acesso do usuário
if ($_SESSION['level'] == 1) {
    // Se o nível de acesso for 1, exibir o link para o Painel do Usuário
    $dashboard_link = "dashboard.php";
} elseif ($_SESSION['level'] == 2) {
    // Se o nível de acesso for 2, exibir o link para o Painel do Administrador
    $dashboard_link = "suportdashboard.php";
} else {
    // Se o nível de acesso for diferente de 1 ou 2, redirecione para uma página de erro ou exiba uma mensagem de erro
    exit("Nível de acesso inválido.");
}

// Recuperar todos os IDs de ticket associados ao usuário com status aberto
$user_id = $_SESSION['id'];
$stmt_tickets = $conn->prepare("SELECT id FROM tickets WHERE user_id = ? AND status = 'Aberto'");
$stmt_tickets->bind_param("i", $user_id);
$stmt_tickets->execute();
$tickets_result = $stmt_tickets->get_result();

// Verificar se há tickets com status aberto associados ao usuário
if ($tickets_result->num_rows > 0) {
    // Inicializar um array para armazenar os IDs dos chats
    $chat_ids = array();

    // Percorrer os resultados e armazenar os IDs dos chats
    while ($ticket = $tickets_result->fetch_assoc()) {
        $ticket_id = $ticket['id'];

        // Recuperar o ID do chat associado ao ticket
        $stmt_chat = $conn->prepare("SELECT id FROM chats WHERE ticket_id = ?");
        $stmt_chat->bind_param("i", $ticket_id);
        $stmt_chat->execute();
        $chat_result = $stmt_chat->get_result();

        // Verificar se o chat está associado ao ticket
        if ($chat_result->num_rows > 0) {
            $chat_data = $chat_result->fetch_assoc();
            $chat_ids[$ticket_id] = $chat_data['id']; // Armazenar o ID do chat com o ID do ticket correspondente
        }
    }

    // Fechar a consulta dos tickets
    $stmt_tickets->close();

    // Se houver chats associados aos tickets com status aberto, carregar os chats
    if (!empty($chat_ids)) {
        // Inicializar uma variável para armazenar as mensagens do chat
        $chat_messages = array();

        // Percorrer os IDs dos chats e recuperar as mensagens
        foreach ($chat_ids as $ticket_id => $chat_id) {
            // Recuperar as mensagens do chat ordenadas pela data de criação em ordem ascendente
            $stmt_messages = $conn->prepare("SELECT u.username, m.message, m.created_at FROM messages m INNER JOIN users u ON m.user_id = u.id WHERE m.chat_id = ? ORDER BY m.created_at ASC");
            $stmt_messages->bind_param("i", $chat_id);
            $stmt_messages->execute();
            $messages_result = $stmt_messages->get_result();

            // Verificar se há mensagens no chat
            if ($messages_result->num_rows > 0) {
                // Inicializar um array para armazenar as mensagens do chat
                $chat_messages[$ticket_id] = array();

                // Percorrer as mensagens e armazenar no array
                while ($message = $messages_result->fetch_assoc()) {
                    $chat_messages[$ticket_id][] = $message;
                }
            }

            // Fechar a consulta das mensagens
            $stmt_messages->close();
        }

        // Agora $chat_messages contém todas as mensagens dos chats associados aos tickets com status aberto do usuário logado
    } else {
        // Se não houver chats associados aos tickets, exibir uma mensagem
        exit("Não há chats associados aos tickets com status aberto.");
    }
} else {
    // Se não houver tickets com status aberto associados ao usuário, exibir uma mensagem
    exit("Não há tickets com status aberto associados ao usuário.");
}
?>
<div class="container">
    <div class="row">
        <div class="col-xl-12 col-lg-7">
        <div class="card shadow col-md-12 mb-4">
                <!-- Card Body -->
                <div class="card-body">
                    <div class="border-bottom pb-4 mb-4">
                        <h3 class="mb-0 fw-bold">
                            <i class="fas fa-comments text-primary me-2"></i> Chats dos Tickets Abertos
                        </h3>
                    </div>
                    <?php
                    // Verificar se há chats para exibir
                    if (!empty($chat_messages)) {
                        // Percorrer os chats e exibir as mensagens
                        foreach ($chat_messages as $ticket_id => $messages) {
                            echo '<div class="card shadow mb-4">';
                            echo '<div class="card-header">';
                            echo '<h5 class="mb-0">Chat do Ticket #' . $ticket_id . '</h5>';
                            echo '</div>';
                            echo '<div class="card-body">';
                            echo '<div id="chat-messages">';
                            // Percorrer as mensagens e exibir
                            foreach ($messages as $message) {
                                echo "<p><strong>{$message['username']}:</strong> {$message['message']} - {$message['created_at']}</p>";
                            }
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        // Se não houver chats para exibir, exibir uma mensagem
                        echo '<div class="alert alert-info" role="alert">';
                        echo 'Não há chats associados aos tickets com status aberto.';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
