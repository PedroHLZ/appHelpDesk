<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>


    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <!-- Adicione isso dentro do seu HTML para mostrar a notificação -->
                <span class="badge badge-danger badge-counter" id="newMessageNotification">

                    <?php
                    // Consulta SQL para contar o número de mensagens associadas ao user_id
                    $sql_count_messages = "SELECT COUNT(*) AS message_count FROM messages WHERE user_id = ?";
                    $stmt_count_messages = $conn->prepare($sql_count_messages);
                    $stmt_count_messages->bind_param("i", $user_id);
                    $stmt_count_messages->execute();
                    $result_count_messages = $stmt_count_messages->get_result();
                    $row_count_messages = $result_count_messages->fetch_assoc();
                    $message_count = $row_count_messages['message_count'];

                    // Exibir o número de mensagens associadas ao user_id
                    echo  $message_count;
                    ?>
                </span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Alerta Chats
                </h6>

                <?php
                require_once "../config.php";

                // Verificar se o usuário está logado
                if (!isset($_SESSION['id'])) {
                    exit("Usuário não autenticado.");
                }

                $user_id = $_SESSION['id'];

                // Consulta para recuperar as 5 últimas mensagens associadas ao user_id, incluindo o ticket_id
                $sql = "SELECT m.chat_id, m.message, m.created_at, c.ticket_id 
                FROM messages m 
                JOIN chats c ON m.chat_id = c.id
                WHERE m.user_id = ? 
                ORDER BY m.created_at DESC 
                LIMIT 5";
        
        

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                // Verificar se foram encontradas mensagens para o usuário
                if ($result->num_rows > 0) {
                    // Iterar sobre as mensagens encontradas
                    while ($row = $result->fetch_assoc()) {
                        $chat_id = $row['chat_id'];
                        $message = $row['message'];
                        $created_at = $row['created_at'];
                        $ticket_id = $row['ticket_id'];

                ?>

                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="icon-circle ">
                                <i class="fas fa-comments fa-2x text-primary"></i>

                                </div>
                            </div>
                            <div>
                                <span class="font-weight-bold">
                                    <?php echo "Ticket ID: $ticket_id" ?>
                                </span><br>
                                <span class="font-weight-bold">
                                    <?php echo "Mensagem: $message" ?>
                                </span>
                                <span><br>
                                    <?php echo "Data: $created_at " ?>
                                </span>
                            </div>
                        </a>
                <?php   }
                } else {
                    // Se não houver mensagens para o usuário
                    echo "Nenhuma mensagem encontrada para o usuário com ID $user_id.";
                }

                // Fechar a consulta preparada
                $stmt->close();
                ?>
            </div>
        </li>



        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?php echo $nome_do_usuario; ?></span>
                <img class="img-profile rounded-circle" src="<?php echo $enderecodosite; ?>/user_img/<?php echo $foto_perfil; ?>">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="" data-toggle="modal" data-target="#perfil_usuario">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="settings" id="settings">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->

<?php
require_once "perfil_modal.php";
?>

<script>
    // Função para ativar o botão após 5 segundos
    function ativarBotao() {
        setTimeout(function() {
            // Seleciona o botão pelo ID
            var botaoSidebar = document.getElementById('sidebarToggleTop');
            // Adiciona a classe 'active' ao botão para ativá-lo
            botaoSidebar.click(); // Aciona o clique no botão
        }, 1000); // 5000 milissegundos = 5 segundos
    }

    // Chama a função para ativar o botão
    ativarBotao();
</script>


