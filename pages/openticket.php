<?php
define('MY_APP_CONFIG', true);
// Verificar se o formulário de abertura de ticket foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Incluir o arquivo de configuração do banco de dados
  require_once "../config.php";

  // Obter os dados do formulário
  $categoria = $_POST["categoria"];
  $titulo = $_POST["titulo"];
  $descricao = $_POST["descricao"];
  $user_id = $_SESSION['id'];

  // Estabelecer a conexão com o banco de dados
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Verificar se houve algum erro na conexão
  if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
  }

  // Preparar a consulta SQL para inserir um novo ticket no banco de dados
  $stmt = $conn->prepare("INSERT INTO tickets (titulo, descricao, categoria, status, data_abertura, user_id) VALUES (?, ?, ?, 'Aberto', NOW(), ?)");

  // Verificar se a preparação da consulta foi bem-sucedida
  if ($stmt === false) {
    die("Erro na preparação da consulta: " . $conn->error);
  }

  // Vincular os parâmetros à consulta preparada e executar a consulta
  $stmt->bind_param("sssi", $titulo, $descricao, $categoria, $user_id);
  $stmt->execute();

  // Verificar se o ticket foi aberto com sucesso
  if ($stmt->affected_rows > 0) {
    // Inserir um registro na tabela chats associado ao ticket
    $ticket_id = $stmt->insert_id;
    $stmt_chat = $conn->prepare("INSERT INTO chats (ticket_id) VALUES (?)");
    $stmt_chat->bind_param("i", $ticket_id);
    $stmt_chat->execute();

    // Inserir uma mensagem inicial informando que o ticket foi aberto
    $chat_id = $stmt_chat->insert_id;
    $mensagem_inicial = "Ticket aberto pelo usuário.";
    $stmt_message = $conn->prepare("INSERT INTO messages (chat_id, user_id, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt_message->bind_param("iss", $chat_id, $user_id, $mensagem_inicial);
    $stmt_message->execute();

    // Fechar as consultas preparadas
    $stmt_chat->close();
    $stmt_message->close();

    // Fechar a conexão com o banco de dados
    $conn->close();

    // Após inserir o ticket com sucesso, chame a função JavaScript para exibir o modal
    echo '    <script>
    $(document).ready(function() {
        showSuccessModal();
    });
</script>';
  } else {
    // Em caso de falha ao abrir o ticket, redirecionar de volta para a página de abertura de ticket com uma mensagem de erro
    header("Location: openticket.php?error=Erro ao abrir o ticket");
    exit;
  }
}
?>


    <div class="row">
      <div class="col-lg-12 col-md-12 col-12">
        <div class="border-bottom pb-4 mb-4">
          <h3 class="mb-0 fw-bold">Abrir Novo Ticket</h3>
        </div>
      </div>
    </div>

   
        <div id="edit" class="card">
          <div class="card-body">
            <div class="mb-6">
              <form action="" method="post">
                <div class="form-group">
                  <label for="categoria" class="form-label">Categoria</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="bi bi-tag"></i></span>
                    </div>
                    <select id="categoria" name="categoria" class="form-control">
                      <option selected disabled>Selecione uma categoria</option>
                      <option>Criação Usuário</option>
                      <option>Impressora</option>
                      <option>Hardware</option>
                      <option>Software</option>
                      <option>Rede</option>
                    </select>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="titulo" class="form-label">Título</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                    </div>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="descricao" class="form-label">Descrição</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="bi bi-textarea-t"></i></span>
                    </div>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-plus"></i> Abrir Ticket</button>
              </form>
            </div>
          </div>
        </div>
     

