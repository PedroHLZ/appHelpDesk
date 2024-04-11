<?php
define('MY_APP_CONFIG', true);
session_start();
// Incluir o arquivo de configuração do banco de dados
require_once "../config.php";
require_once "../engine.php";

// Definir o status padrão do botão
$button_disabled = '';

// Verificar se o ID do ticket foi passado via GET
if (isset($_GET['ticket_id'])) {
    $ticket_id = $_GET['ticket_id'];

    // Recuperar o status do ticket
    $stmt_ticket_status = $conn->prepare("SELECT status FROM tickets WHERE id = ?");
    $stmt_ticket_status->bind_param("i", $ticket_id);
    $stmt_ticket_status->execute();
    $ticket_status_result = $stmt_ticket_status->get_result();

    if ($ticket_status_result->num_rows > 0) {
        $ticket_status_data = $ticket_status_result->fetch_assoc();
        $ticket_status = $ticket_status_data['status'];

        // Desabilitar o formulário se o status do ticket for 'fechado'
        if ($ticket_status == 'fechado') {
            $button_disabled = 'disabled';
        }

        // Fechar a consulta do status do ticket
        $stmt_ticket_status->close();
    } else {
        // Ticket não encontrado
        exit("Ticket não encontrado.");
    }

    // Recuperar o ID do chat associado ao ticket
    $stmt_chat = $conn->prepare("SELECT id FROM chats WHERE ticket_id = ?");
    $stmt_chat->bind_param("i", $ticket_id);
    $stmt_chat->execute();
    $chat_result = $stmt_chat->get_result();

    if ($chat_result->num_rows > 0) {
        $chat_data = $chat_result->fetch_assoc();
        $chat_id = $chat_data['id'];

        // Processar o envio da mensagem se o botão não estiver desabilitado
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_message"]) && empty($button_disabled)) {
            $message = $_POST["message"];
            $user_id = $_SESSION["id"];

            // Inserir a mensagem no banco de dados
            $stmt_insert_message = $conn->prepare("INSERT INTO messages (chat_id, user_id, message, created_at) VALUES (?, ?, ?, NOW())");
            $stmt_insert_message->bind_param("iis", $chat_id, $user_id, $message);
            $stmt_insert_message->execute();

            // Redirecionar para evitar envio duplo
            header("Location: meuschats?ticket_id=$ticket_id");
            exit;
        }

        // Recuperar as mensagens do chat ordenadas pela data de criação em ordem ascendente
        $stmt_messages = $conn->prepare("SELECT u.username, m.message, m.created_at FROM messages m INNER JOIN users u ON m.user_id = u.id WHERE m.chat_id = ? ORDER BY m.created_at ASC");
        $stmt_messages->bind_param("i", $chat_id);
        $stmt_messages->execute();
        $messages_result = $stmt_messages->get_result();

        // Fechar as consultas
        $stmt_chat->close();
        $stmt_messages->close();
    } else {
        // Não foi encontrado nenhum chat para este ticket
        exit("Não foi possível encontrar o chat para este ticket.");
    }
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

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Chat do Ticket #<?php echo $ticket_id; ?></title>


    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <!-- Fonte personalizada do Google-->

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- styles -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <script src="../js/scripts.js"></script>
    <!-- Adicione isso no cabeçalho para incluir o jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        require_once "usersidebar.php";
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                require_once "usertopbar.php";
                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid" id="conteudoPagina">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Gerar Relatório</a>

                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header" id="card-header">
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
                                            <textarea name="message" rows="4" cols="50" class="form-control" aria-label="Mensagem" <?php echo $button_disabled; ?>></textarea>
                                            <button type="submit" name="submit_message" class="btn btn-success" <?php echo $button_disabled; ?>>
                                                <i class="fas fa-paper-plane"></i> Enviar Mensagem
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright &copy; <?php echo $titulo_do_site; ?></span>
                            </div>
                        </div>
                    </footer>
                    <!-- End of Footer -->
                </div>
            </div>
        </div>

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Custom scripts for all pages-->
        <script src="../js/sb-admin-2.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../js/conteudoPaginaUser.js"></script>

        <!-- Script JavaScript para desabilitar o botão do formulário se o ticket estiver fechado -->
        <script>
            $(document).ready(function() {
                <?php if ($ticket_status == 'Fechado') { ?>
                    $('textarea[name="message"]').prop('disabled', true);
                    $('button[name="submit_message"]').prop('disabled', true);
                <?php } ?>
            });
        </script>
    </body>

</html>
