<?php
define('MY_APP_CONFIG', true);
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_user"])) {
    // Verifica se os campos obrigatórios estão presentes e não estão vazios
    if (isset($_POST["user_id"]) && !empty($_POST["user_id"])) {
        // Obtém o ID do usuário a ser excluído
        $user_id = $_POST["user_id"];

        // Constrói a consulta SQL de exclusão
        $sql = "DELETE FROM users WHERE id = ?";

        // Prepara a consulta
        $stmt = $conn->prepare($sql);
        
        // Vincula o parâmetro do ID do usuário à consulta preparada
        $stmt->bind_param("i", $user_id);
        
        // Executa a consulta preparada
        if ($stmt->execute()) {
            // Redireciona de volta para a página anterior
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        } else {
            echo "Erro ao excluir o usuário: " . $stmt->error;
        }
        
        // Fecha a consulta preparada
        $stmt->close();
    } else {
        echo "O ID do usuário é obrigatório.";
    }
}
?>
