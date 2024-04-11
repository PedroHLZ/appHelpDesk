<?php
define('DB_HOST', 'apphelpdesk');
define('DB_USER', 'apphelpdesk');
define('DB_PASSWORD', 'apphelpdesk'); // Considere armazenar a senha de forma mais segura
define('DB_NAME', 'apphelpdesk');

// Criar conexão
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Verificar conexão e tratar erros adequadamente
if ($conn->connect_error) {
    // Log de erro
    error_log("Erro na conexão com o banco de dados: " . $conn->connect_error);
    
    // Exibição de uma página de erro para o usuário
    header("Location: error.php");
    exit();
}
// Array de códigos de cadastro permitidos
$registration_codes = array("AI+xIEgiojT6hq0CvdWgS0w3bLnRmonvUWjWDh4Nu8E=", "Wi5ob5/RpTr/kCCP/7rFVfuD2Se2t1nNk9t/wdCoVZo=", "codigodecadastro");

$titulo_do_site = "Help Desk"; 

$enderecodosite = "http://apphelpdesk.com.br/";

$nome_do_site = "Help Desk";

$nome_fantasia = "App Help Desk";

$txt_home1 = "O App Help Desk é uma plataforma de suporte ao cliente projetada para ajudar você a gerenciar
 solicitações de suporte de forma eficiente. Com nossa interface intuitiva e recursos poderosos,
  você pode acompanhar tickets, responder a consultas de clientes e resolver problemas rapidamente.";

 $txt_home2 = "
Nossa equipe está comprometida em fornecer o melhor suporte possível e garantir que
 todas as suas necessidades sejam atendidas. Estamos aqui para ajudar a garantir que sua experiência com 
 o App Help Desk seja excelente.";


// Consulta para contar os tickets abertos
$sql_abertos = "SELECT COUNT(*) AS total_abertos FROM tickets WHERE status = 'Aberto'";
$result_abertos = $conn->query($sql_abertos);
$row_abertos = $result_abertos->fetch_assoc();
$total_abertos = $row_abertos['total_abertos'];

// Consulta para contar os tickets fechados
$sql_fechados = "SELECT COUNT(*) AS total_fechados FROM tickets WHERE status = 'Fechado'";
$result_fechados = $conn->query($sql_fechados);
$row_fechados = $result_fechados->fetch_assoc();
$total_fechados = $row_fechados['total_fechados'];

// Consulta para contar o total de tickets
$sql_total = "SELECT COUNT(*) AS total_tickets FROM tickets";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_tickets = $row_total['total_tickets'];


?>
