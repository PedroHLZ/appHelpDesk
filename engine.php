<?php
// Estabelecer a conexão com o banco de dados
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Verificar se houve algum erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verificar se o formulário de resposta de ticket foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_reply"])) {
    // Obter os dados do formulário
    $ticket_id = $_POST["ticket_id"];

    // Inserir um novo chat associado ao ticket
    $stmt = $conn->prepare("INSERT INTO chats (ticket_id) VALUES (?)");
    $stmt->bind_param("i", $ticket_id);
    $stmt->execute();

    // Verificar se a inserção foi bem-sucedida
    if ($stmt->affected_rows > 0) {
        // Redirecionar para o chat associado ao ticket
        header("Location: meuschats?ticket_id=$ticket_id");
        exit;
    } else {
        // Exibir uma mensagem de erro
    }

    // Fechar a consulta preparada
    $stmt->close();
}

// Verificar se o usuário está autenticado
if (!isset($_SESSION["autenticado"]) || $_SESSION["autenticado"] !== "SIM") {
    // Redirecionar para a página de login se o usuário não estiver autenticado
    header("Location: index.php");
    exit();
}



// Função para obter os dados do usuário logado
function obterDadosDoUsuario($id) {
    global $conn;
    
    // Preparar a consulta para obter todos os dados do usuário
    $stmt = $conn->prepare("SELECT username, email, password, foto_perfil, created_at, level, telefone, endereco, codigo_postal, sobrenome, registration_code FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar se os dados do usuário foram encontrados
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        return $usuario;
    } else {
        return null;
    }
}

// Obter os dados do usuário logado
$usuario = obterDadosDoUsuario($_SESSION['id']);

// Verificar se os dados do usuário foram obtidos com sucesso
if ($usuario) {
    // Exibir os dados do usuário
    $nome_do_usuario = $usuario["username"];
    $email_do_usuario = $usuario["email"];
    $senha_do_usuario = $usuario["password"];
    $foto_perfil = $usuario["foto_perfil"];
    $data_de_criacao = $usuario["created_at"];
    $nivel_do_usuario = $usuario["level"];
    $telefone_do_usuario = $usuario["telefone"];
    $endereco_do_usuario = $usuario["endereco"];
    $codigo_postal_do_usuario = $usuario["codigo_postal"];
    $sobrenome_do_usuario = $usuario["sobrenome"];
    $registration_code = $usuario["registration_code"];
} else {
    // Se os dados do usuário não puderem ser obtidos, redirecionar para a página de login
    header("Location: index.php");
    exit();
}




?>
