<?php
define('MY_APP_CONFIG', true);
require_once "../config.php";

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se o campo ticket_id está definido e não está vazio
    if (isset($_POST["ticket_id"]) && !empty($_POST["ticket_id"])) {
        $ticket_id = $_POST["ticket_id"];
        // Atualizar o status do ticket para 'Fechado' no banco de dados
        $sql = "UPDATE tickets SET status = 'Fechado' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        // Vincule o parâmetro ticket_id à instrução SQL
        $stmt->bind_param("i", $ticket_id);
        // Execute a instrução preparada
        if ($stmt->execute()) {
            // Redirecionar de volta para a página anterior
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            exit;
        } else {
            echo "<p class='alert alert-danger'>Erro ao fechar o ticket: " . $stmt->error . "</p>";
        }
        // Feche a instrução preparada
        $stmt->close();
    } else {
        echo "<p class='alert alert-danger'>ID do ticket não fornecido.</p>";
    }
}
?>
