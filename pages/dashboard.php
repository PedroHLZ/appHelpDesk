<?php
define('MY_APP_CONFIG', true);
// Iniciar a sessão (se ainda não estiver iniciada)
session_start();
// Verificar se o ID do usuário está presente na sessão
if (isset($_SESSION['id'])) {
}
// Incluir o arquivo de configuração do banco de dados
require_once "../config.php";
require_once "../engine.php";


// Verificar se o usuário está logado e tem o nível de acesso adequado
if (!isset($_SESSION['id']) || $_SESSION['level'] < 1) {
    // Redirecionar para a página de login se o usuário não estiver logado ou não tiver acesso suficiente
    header("Location: ../index.php");
    exit;
}



// Armazenar o ID do usuário logado em uma variável
$user_id = $_SESSION['id'];

$dashboard_link = "dashboard.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $titulo_do_site; ?> - Painel</title>


    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <!-- Fonte personalizada do Google-->

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css" rel="stylesheet">

  <!-- styles -->
  <link href="../css/sb-admin-2.css" rel="stylesheet">
  
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

                        <!-- Card Example -->
                        <?php


                        // Consulta SQL para obter o número total de tickets do usuário
                        $sql_total_tickets = "SELECT COUNT(*) AS total_tickets_do_usuario FROM tickets WHERE user_id = ?";
                        $stmt_total_tickets = $conn->prepare($sql_total_tickets);
                        $stmt_total_tickets->bind_param("i", $user_id);
                        $stmt_total_tickets->execute();
                        $result_total_tickets = $stmt_total_tickets->get_result();
                        $row_total_tickets = $result_total_tickets->fetch_assoc();
                        $total_tickets_do_usuario = $row_total_tickets['total_tickets_do_usuario'];

                        // Consulta SQL para obter o número total de tickets abertos do usuário
                        $sql_total_abertos = "SELECT COUNT(*) AS total_abertos_do_usuario FROM tickets WHERE user_id = ? AND status = 'Aberto'";
                        $stmt_total_abertos = $conn->prepare($sql_total_abertos);
                        $stmt_total_abertos->bind_param("i", $user_id);
                        $stmt_total_abertos->execute();
                        $result_total_abertos = $stmt_total_abertos->get_result();
                        $row_total_abertos = $result_total_abertos->fetch_assoc();
                        $total_abertos_do_usuario = $row_total_abertos['total_abertos_do_usuario'];

                        // Consulta SQL para obter o número total de chats do usuário (se aplicável, ajuste conforme sua lógica de negócios)
                        $total_chats_do_usuario = 0; // Ajuste conforme sua lógica

                        // Consulta SQL para obter o número total de tickets fechados do usuário
                        $sql_total_fechados = "SELECT COUNT(*) AS total_fechados_do_usuario FROM tickets WHERE user_id = ? AND status = 'Fechado'";
                        $stmt_total_fechados = $conn->prepare($sql_total_fechados);
                        $stmt_total_fechados->bind_param("i", $user_id);
                        $stmt_total_fechados->execute();
                        $result_total_fechados = $stmt_total_fechados->get_result();
                        $row_total_fechados = $result_total_fechados->fetch_assoc();
                        $total_fechados_do_usuario = $row_total_fechados['total_fechados_do_usuario'];

                        // Fechar as consultas preparadas
                        $stmt_total_tickets->close();
                        $stmt_total_abertos->close();
                        $stmt_total_fechados->close();

                        // Fechar a conexão MySQLi
                        $conn->close();
                        ?>


                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Todos os Tickets:</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_tickets_do_usuario; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Tickets Abertos:</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_abertos_do_usuario; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Tickets Fechados:</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_fechados_do_usuario; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-times fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Content Row -->

                    <div class="row">
                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <!-- Card Body -->
                                <div class="card-body">
                                    <?php
                                    require_once "openticket.php";
                                    ?>
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




        <!-- Modal de Sucesso -->
        <div class="modal fade rounded border-0" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered rounded border-0" role="document">
                <div class="modal-content rounded border-0">
                    <div class="modal-body bg-success text-white rounded border-0">
                        <div class="text-center">
                            <i class="fas fa-check-circle fa-4x mb-3"></i>
                            <p class="lead">Seu Ticket Foi Aberto Com Sucesso.</p>
                        </div>
                    </div>
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



</body>

</html>