<?php
define('MY_APP_CONFIG', true);
// Verificar se o formulário de registro foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Incluir o arquivo de configuração do banco de dados
  require_once "../config.php";

  // Definir variáveis para armazenar a mensagem de sucesso ou erro
  $success_message = "";
  $error_message = "";

  // Verificar se os campos obrigatórios estão definidos e não estão vazios
  if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"]) && isset($_POST["registration_code"])) {
    // Obter os dados do formulário
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $registration_code = $_POST["registration_code"];
    $sobrenome = isset($_POST["sobrenome"]) ? $_POST["sobrenome"] : "";
    $telefone = isset($_POST["telefone"]) ? $_POST["telefone"] : "";
    $endereco = isset($_POST["endereco"]) ? $_POST["endereco"] : "";
    $codigo_postal = isset($_POST["codigo_postal"]) ? $_POST["codigo_postal"] : "";

    // Verificar se as senhas coincidem
    if ($password === $confirm_password) {
      // Hash da senha
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      // Definir a foto de perfil padrão
      $default_photo = "undraw_profile.svg";

      // Preparar a consulta SQL para inserir um novo usuário no banco de dados
      $stmt = $conn->prepare("INSERT INTO users (username, email, password, registration_code, sobrenome, telefone, endereco, codigo_postal, foto_perfil) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

      // Verificar se a preparação da consulta foi bem-sucedida
      if ($stmt) {
        // Vincular os parâmetros e executar a consulta
        $stmt->bind_param("sssssssss", $username, $email, $hashed_password, $registration_code, $sobrenome, $telefone, $endereco, $codigo_postal, $default_photo);
        if ($stmt->execute()) {
          $success_message = "Cadastro realizado com sucesso!";
          // Redirecionar para a página index.php após 3 segundos
          header("Location: {$_SERVER['HTTP_REFERER']}");
        } else {
          // Definir uma mensagem de erro
          $error_message = "Erro ao cadastrar usuário. Por favor, tente novamente.";
        }
      } else {
        $error_message = "Erro ao preparar a consulta: " . $conn->error;
      }
    } else {
      $error_message = "As senhas não coincidem";
    }
  } else {
    $error_message = "Por favor, preencha todos os campos obrigatórios";
  }
} else {
  // Se o formulário não foi submetido por método POST, redirecione de volta à página de registro
  header("Location: {$_SERVER['HTTP_REFERER']}");
  exit;
}

// Fechar a conexão com o banco de dados
$conn->close();

// Exibir mensagem de sucesso ou erro
if (!empty($success_message)) {
  echo '<div class="alert alert-success" role="alert">' . $success_message . '</div>';
} elseif (!empty($error_message)) {
  echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
}
?>


