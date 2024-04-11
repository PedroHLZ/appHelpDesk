<?php
// Iniciar a sessão (se ainda não estiver iniciada)
session_start();
// Incluir o arquivo de configuração do banco de dados
require_once "../config.php";
require_once "../engine.php";


// Verificar se o usuário está logado e tem o nível de acesso adequado
if (!isset($_SESSION['id']) || $_SESSION['level'] < 2) {
    // Redirecionar para a página de login se o usuário não estiver logado ou não tiver acesso suficiente
    header("Location: login.php");
    exit;
}



// Verifica se a conexão com o banco de dados foi estabelecida com sucesso
if ($conn === false) {
    die("Erro de conexão com o banco de dados: " . mysqli_connect_error());
}

// Consulta SQL para calcular o número total de tickets abertos por dia nos últimos 30 dias
$sql_new_tickets = "SELECT DAY(data_abertura) AS dia, COUNT(id) AS total_tickets 
                    FROM tickets 
                    WHERE data_abertura >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                    GROUP BY dia";

$result_new_tickets = $conn->query($sql_new_tickets);

// Consulta SQL para calcular o número total de tickets fechados por dia nos últimos 30 dias
$sql_closed_tickets = "SELECT DAY(data_fechamento) AS dia, COUNT(id) AS total_tickets 
                       FROM tickets 
                       WHERE data_fechamento >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                       GROUP BY dia";

$result_closed_tickets = $conn->query($sql_closed_tickets);

// Criando arrays para armazenar os dados do mês
$dates_new_tickets = [];
$new_tickets_data = [];
$closed_tickets_data = [];

// Obtendo o número total de dias no mês atual
$num_days_in_month = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));

// Preenchendo os arrays com os dias do mês e os dados correspondentes (0 por padrão)
for ($day = 1; $day <= $num_days_in_month; $day++) {
    $dates_new_tickets[] = $day;
    // Se houver dados disponíveis para este dia, insira-os; caso contrário, insira 0
    if ($result_new_tickets->num_rows > 0) {
        $new_tickets_data[$day] = 0;
    }
    if ($result_closed_tickets->num_rows > 0) {
        $closed_tickets_data[$day] = 0;
    }
}

// Preenchendo os arrays com os dados reais
while ($row = $result_new_tickets->fetch_assoc()) {
    $new_tickets_data[$row['dia']] = $row['total_tickets'];
}

while ($row = $result_closed_tickets->fetch_assoc()) {
    $closed_tickets_data[$row['dia']] = $row['total_tickets'];
}








// Consulta SQL para recuperar os dados da coluna "categoria"
$sql = "SELECT categoria, COUNT(*) AS count FROM tickets GROUP BY categoria";

$result = $conn->query($sql);

$data = array();

// Verificar se há resultados da consulta
if ($result->num_rows > 0) {
    // Saída de dados de cada linha
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();

$dashboard_link = "suportdashboard.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $titulo_do_site; ?> - Painel do Administrador</title>

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <!-- Fonte personalizada do Google-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- styles -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        require_once "Sidebar.php";
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                require_once "Topbar.php";
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
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total de Tickets:</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_tickets; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Tickets Abertos:</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_abertos; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Chats Abertos:</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_abertos; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Tickets Fechados: :</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_fechados; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                            <div class="card shadow mb-4 border-bottom-primary  ">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Tickets Abertos e Fechados No Periodo de 1 Mês</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">

                                    <div id="linechart"></div>
                                    <script type="text/javascript">
                                        google.charts.load('current', {
                                            'packages': ['corechart']
                                        });
                                        google.charts.setOnLoadCallback(drawChart);

                                        function drawChart() {
                                            // Converter os dados para o formato adequado para o gráfico
                                            var data = new google.visualization.DataTable();
                                            data.addColumn('string', 'Day');
                                            data.addColumn('number', 'New Tickets');
                                            data.addColumn('number', 'Closed Tickets');

                                            <?php
                                            // Loop para adicionar dados ao DataTable
                                            for ($i = 1; $i <= $num_days_in_month; $i++) {
                                                echo "data.addRow(['$i', " . (isset($new_tickets_data[$i]) ? $new_tickets_data[$i] : 0) . ", " . (isset($closed_tickets_data[$i]) ? $closed_tickets_data[$i] : 0) . "]);";
                                            }
                                            ?>

                                            // Configurar as opções do gráfico
                                            var options = {
                                                legend: {
                                                    position: 'bottom'
                                                },
                                                animation: {
                                                    startup: true,
                                                    duration: 1000,
                                                    easing: 'out',
                                                }
                                            };

                                            // Criar e desenhar o gráfico de linha
                                            var chart = new google.visualization.LineChart(document.getElementById('linechart'));
                                            chart.draw(data, options);
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                        <!-- Area Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4 border-bottom-info">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Categoria dos Tickets</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">

                                    <div id="piechart"></div>
                                    <script type="text/javascript">
                                        google.charts.load('current', {
                                            'packages': ['corechart']
                                        });
                                        google.charts.setOnLoadCallback(drawChart);

                                        function drawChart() {
                                            // Converter os dados para o formato adequado para o gráfico
                                            var dataArray = [];
                                            dataArray.push(['Category', 'Frequency']);
                                            <?php foreach ($data as $row) : ?>
                                                dataArray.push(['<?php echo $row['categoria']; ?>', <?php echo $row['count']; ?>]);
                                            <?php endforeach; ?>

                                            // Criar o objeto de dados do Google Charts
                                            var data = google.visualization.arrayToDataTable(dataArray);

                                            // Configurar as opções do gráfico
                                            var options = {
                                                animation: {
                                                    startup: true,
                                                    duration: 1000,
                                                    easing: 'out',
                                                },
                                                legend: 'bottom' // Exibe a legenda na parte inferior do gráfico
                                            };

                                            // Criar e desenhar o gráfico
                                            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                                            chart.draw(data, options);
                                        }
                                    </script>
                                </div>
                            </div>
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
    <!-- /.container-fluid -->

   

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="../js/conteudoPagina.js"></script>

</body>

</html>