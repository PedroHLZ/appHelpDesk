<?php
define('MY_APP_CONFIG', true);
session_start();
require_once "../config.php";

// Verificar se o ID do ticket foi passado via GET
if (isset($_GET['ticket_id'])) {
    $ticket_id = $_GET['ticket_id'];

    // Recuperar o ID do chat associado ao ticket
    $stmt_chat = $conn->prepare("SELECT id FROM chats WHERE ticket_id = ?");
    $stmt_chat->bind_param("i", $ticket_id);
    $stmt_chat->execute();
    $chat_result = $stmt_chat->get_result();

    if ($chat_result->num_rows > 0) {
        $chat_data = $chat_result->fetch_assoc();
        $chat_id = $chat_data['id'];

        // Processar o envio da mensagem
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_message"])) {
            $message = $_POST["message"];
            $user_id = $_SESSION["id"];

            // Inserir a mensagem no banco de dados
            $stmt_insert_message = $conn->prepare("INSERT INTO messages (chat_id, user_id, message, created_at) VALUES (?, ?, ?, NOW())");
            $stmt_insert_message->bind_param("iis", $chat_id, $user_id, $message);
            $stmt_insert_message->execute();

            // Redirecionar para evitar envio duplo
            header("Location: chat.php?ticket_id=$ticket_id");
            exit;
        }

// Recuperar as mensagens do chat ordenadas pela data de criação em ordem ascendente
$stmt_messages = $conn->prepare("SELECT u.username, m.message, m.created_at FROM messages m INNER JOIN users u ON m.user_id = u.id WHERE m.chat_id = ? ORDER BY m.created_at ASC");
$stmt_messages->bind_param("i", $chat_id);
$stmt_messages->execute();
$messages_result = $stmt_messages->get_result();


        if ($messages_result->num_rows > 0) {
            // Debug: Imprimir o número de mensagens recuperadas
             "Número de mensagens recuperadas: " . $messages_result->num_rows;
        } else {
            // Debug: Mensagem se nenhuma mensagem for recuperada
             "Nenhuma mensagem recuperada.";
        }
    } else {
        // Não foi encontrado nenhum chat para este ticket
        exit("Não foi possível encontrar o chat para este ticket.");
    }

    $stmt_chat->close();
    $stmt_messages->close();
} else {
    // ID do ticket não fornecido
    exit("ID do ticket não fornecido.");
}

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
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat do Ticket #<?php echo $ticket_id; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        #card-header {
            padding: 0.5rem 1rem;
            margin-bottom: 0;
            background-color: #19875470;
            border-bottom: 1px solid #198754;
        }
        nav ul li {
            display: flex;
            margin-right: 10px;
            flex-direction: column-reverse;
            align-items: flex-end;
        }
        form {
            margin-top: 20px;
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .card-header {
            padding: 0.5rem 1rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, .03);
            border-bottom: 1px solid rgba(0, 0, 0, .125);
            text-align: -webkit-center;
        }
        .link {
  text-decoration: none; /* Remove sublinhado */
  color: #fff; /* Altere para a cor desejada ao passar o mouse */
}
.link:hover {
  color: #fff; /* Altere para a cor desejada ao passar o mouse */
  text-decoration: none; /* Remove sublinhado */
}
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">
            </i> <a href ='index.php' class="link"><i class="fas fa-life-ring me-2"></i><?php echo $nome_do_site; ?></a>
        </span>
        <div class="text-center mt-3">
            <a href="<?php echo $dashboard_link; ?>" class="btn btn-success btn-sm"><i class="fas fa-arrow-left me-1"></i>Voltar</a>
            <a href="logout.php" class="btn btn-secondary btn-sm"><i class="fas fa-sign-out-alt me-1"></i>Sair</a>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header"  id="card-header">
                    <h1>Chat do Ticket #<?php echo $ticket_id; ?></h1>
                </div>
                <div class="card-body">
                    <div id="chat-messages">
                        <?php
                        if ($messages_result->num_rows > 0) {
                            while ($row = $messages_result->fetch_assoc()) {
                                echo "<p><strong>{$row['username']}:</strong> {$row['message']} - {$row['created_at']}</p>";
                            }
                        } else {
                            echo "<p>Nenhuma mensagem neste chat ainda.</p>";
                        }
                        ?>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="chat_id" value="<?php echo $chat_id; ?>">
                        <div class="input-group mb-3">
                            <textarea name="message" rows="4" cols="50" class="form-control" aria-label="Mensagem"></textarea>
                            <button type="submit" name="submit_message" class="btn btn-success">
                                <i class="fas fa-paper-plane"></i> Enviar Mensagem
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Scripts do Bootstrap e FontAwesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
