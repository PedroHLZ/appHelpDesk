<?php
define('MY_APP_CONFIG', true);
require_once "../config.php";

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"], $_POST["username"], $_POST["sobrenome"], $_POST["email"], $_POST["telefone"], $_POST["endereco"], $_POST["codigo_postal"], $_POST["level"])) {
    // Obtém os dados do formulário
    $user_id = $_POST["user_id"];
    $username = $_POST["username"];
    $sobrenome = $_POST["sobrenome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $endereco = $_POST["endereco"];
    $codigo_postal = $_POST["codigo_postal"];
    $level = $_POST["level"];

    // Prepara a consulta SQL
    $sql = "UPDATE users SET username=?, sobrenome=?, email=?, telefone=?, endereco=?, codigo_postal=?, level=? WHERE id=?";

    // Prepara a instrução
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Vincula os parâmetros e executa a instrução
        $stmt->bind_param("ssssssii", $username, $sobrenome, $email, $telefone, $endereco, $codigo_postal, $level, $user_id);
        if ($stmt->execute()) {
            // Redireciona de volta para a página anterior
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        } else {
            echo "Erro ao executar a consulta: " . $stmt->error;
        }

        // Fecha a instrução
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }
} else {
    echo "Todos os campos são obrigatórios.";
}
?>
