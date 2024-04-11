<?php
define('MY_APP_CONFIG', true);
// Iniciar a sessão (se ainda não estiver iniciada)
session_start();

// Verificar se o usuário está logado e tem o nível de acesso adequado
if (!isset($_SESSION['id']) || $_SESSION['level'] < 1) {
    // Redirecionar para a página de login se o usuário não estiver logado ou não tiver acesso suficiente
    header("Location: ../404.html");
    exit;
}

// Verificar se o arquivo foi enviado corretamente
if (isset($_FILES["foto_perfil"]) && $_FILES["foto_perfil"]["error"] == UPLOAD_ERR_OK) {
    // Diretório onde as fotos de perfil serão armazenadas no servidor
    $diretorio = __DIR__ . "/../user_img/";

    // Nome do arquivo
    $nome_arquivo = $_SESSION['id'] . "_" . basename($_FILES["foto_perfil"]["name"]);

    // Caminho completo do arquivo no servidor
    $caminho_arquivo = $diretorio . $nome_arquivo;

    // Mover o arquivo para o diretório de destino
    if (move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $caminho_arquivo)) {
        // Incluir o arquivo de configuração do banco de dados
        require_once "../config.php";

        // Estabelecer a conexão com o banco de dados
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Verificar se houve algum erro na conexão
        if ($conn->connect_error) {
            die("Erro na conexão: " . $conn->connect_error);
        }

        // Atualizar o caminho da foto de perfil no banco de dados
        $id_usuario = $_SESSION['id'];
        $stmt = $conn->prepare("UPDATE users SET foto_perfil = ? WHERE id = ?");
        $stmt->bind_param("si", $nome_arquivo, $id_usuario);
        $stmt->execute();
        $stmt->close();

        // Redirecionar de volta para a página de perfil do usuário
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    } else {
        echo "Erro ao fazer o upload do arquivo.";
    }
} else {
    echo "Erro no upload do arquivo.";
}
?>
