<?php
define('MY_APP_CONFIG', true);
session_start();
require_once "../config.php";

// Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
  echo "<p class='alert alert-danger'>Você precisa estar logado para visualizar os tickets.</p>";
  exit();
}

// Recuperar o ID do usuário da sessão
$user_id = $_SESSION['id'];

// Processamento para fechar o ticket
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_close"])) {
  // Verificar se o campo ticket_id está definido e não está vazio
  if (isset($_POST["ticket_id"]) && !empty($_POST["ticket_id"])) {
    $ticket_id = $_POST["ticket_id"];
    // Atualize o status do ticket para 'Fechado' no banco de dados
    $sql = "UPDATE tickets SET status = 'Fechado' WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    // Vincule os parâmetros ticket_id e user_id à instrução SQL
    $stmt->bind_param("ii", $ticket_id, $user_id);
    // Execute a instrução preparada
    if ($stmt->execute()) {
      echo "<p class='alert alert-success'>Ticket fechado com sucesso.</p>";
    } else {
      echo "<p class='alert alert-danger'>Erro ao fechar o ticket: " . $stmt->error . "</p>";
    }
    // Feche a instrução preparada
    $stmt->close();
  } else {
    echo "<p class='alert alert-danger'>ID do ticket não fornecido.</p>";
  }
}

// Consulta SQL para obter os tickets abertos do usuário logado
$sql = "SELECT t.id, t.titulo, t.descricao, t.status, t.data_abertura, t.user_id, t.categoria , u.username 
        FROM tickets t 
        INNER JOIN users u ON t.user_id = u.id 
         AND t.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container">
  <div class="row">

  <div class="card shadow col-md-12 mb-4">
        <!-- Card Body -->
        <div class="card-body">
          <div class="border-bottom pb-4 mb-4">
            <h3 class="mb-0 fw-bold">
            <i class="fas fa-ticket-alt me-1"></i> Todos os Tickets 
            </h3>
          </div>


          <div class="row">
            <?php
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
            ?>
                <div class="col-md-6 mb-4">
                  <div class="card shadow border-bottom-primary">
                    <div class="card-header bg-primary text-white">
                      <h5 class="card-title mb-0">Ticket #<?php echo $row['id']; ?></h5>
                    </div>
                    <div class="card-body">
                      <p><strong>Data:</strong> <?php echo $row['data_abertura']; ?></p>
                      <p><strong>Usuário:</strong> <?php echo $row['username']; ?></p>
                      <hr>
                      <p><strong>Status:</strong> <span class="badge bg-<?php echo ($row['status'] == 'Aberto') ? 'success' : 'danger'; ?> text-white"><?php echo $row['status']; ?></span></p>
                      <p><strong>Categoria:</strong> <?php echo $row['categoria']; ?></p>
                      <p><strong>Título:</strong> <?php echo $row['titulo']; ?></p>
                      <p><strong>Descrição:</strong> <?php echo $row['descricao']; ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 d-flex justify-content-end">
                      <form action='' method='post' style='margin-right: 1rem;'>
                        <input type='hidden' name='ticket_id' value='<?php echo $row['id']; ?>'>
                        <button type='submit' name='submit_reply' class='btn btn-outline-success'><i class='fas fa-reply'></i> Histórico</button>
                      </form>

                    </div>
                  </div>
                </div>
            <?php
              }
            } else {
              echo "<div class='col-md-12'><p class='text-muted'>Não há tickets abertos.</p></div>";
            }
            ?>
          </div>
        </div>