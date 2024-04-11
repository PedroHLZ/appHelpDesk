<?php
require_once "../config.php";

// Processamento para fechar o ticket
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_close"])) {
    // Verifique se o campo ticket_id está definido e não está vazio
    if (isset($_POST["ticket_id"]) && !empty($_POST["ticket_id"])) {
        $ticket_id = $_POST["ticket_id"];
        // Atualize o status do ticket para 'Fechado' no banco de dados
        $sql = "UPDATE tickets SET status = 'Fechado' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        // Vincule o parâmetro ticket_id à instrução SQL
        $stmt->bind_param("i", $ticket_id);
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

// Consulta SQL para obter os tickets abertos
$sql = "SELECT t.id, t.titulo, t.descricao, t.status, t.data_abertura, t.user_id, t.categoria , u.username 
        FROM tickets t 
        INNER JOIN users u ON t.user_id = u.id 
        WHERE t.status = 'Aberto'";
$result = $conn->query($sql);
?>

<div class="container-fluid">
    <div class="p-6 container-fluid">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="border-bottom pb-4 mb-4">
                    <h3 class="mb-0 fw-bold">Ticket Abertos</h3>
                </div>
            </div>
        </div>
        <div class="mb-8 row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="mb-4 col-xl-9 col-lg-8 col-md-12 col-12">
                        <div id="edit" class="card">
                            <div class="card-body">
                                <div class="mb-6">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h4 class="mb-1">
                                                <strong>Ticket ID:</strong> <?php echo $row['id']; ?>
                                            </h4>
                                            <p class="card-text"><strong>Data:</strong> <?php echo $row['data_abertura']; ?></p>
                                            <strong>Usuário:</strong> <?php echo $row['username']; ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h4 class="mb-1">
                                                <strong>Status:</strong> <?php echo $row['status']; ?>
                                               
                                            </h4>

                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="card-text">
                                                <strong>Categoria:</strong> <?php echo $row['categoria']; ?>

                                                <br>
                                                <strong>Título:</strong> <?php echo $row['titulo']; ?>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="card-text">

                                                <strong>Descrição:</strong> <?php echo $row['descricao']; ?>
                                            </p>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-end">
                                            <form action='' method='post' class='me-2'>
                                                <input type='hidden' name='ticket_id' value='<?php echo $row['id']; ?>'>
                                                <button type='submit' name='submit_reply' class='btn btn-success me-2' style='margin-right: 1rem;'><i class='fas fa-share'></i> Responder</button>
                                            </form>
                                            <form action='../sys/process_close_ticket.php' method='post'>
                                                <input type='hidden' name='ticket_id' value='<?php echo $row['id']; ?>'>
                                                <button type='submit' name='submit_close' class='btn btn-danger' style='margin-left: 1rem;'><i class='fas fa-times'></i> Fechar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var i = <?php echo $row['id']; ?>;
                            var statusElement = document.getElementById("statusText_" + i);

                            // Itera enquanto houver elementos com o ID "statusText_" + i
                            while (statusElement) {
                                var status = statusElement.innerText.trim(); // Obtém o texto do elemento e remove espaços em branco em excesso

                                // Remove todas as classes de cor do elemento
                                statusElement.classList.remove("bg-success", "bg-danger");

                                // Verifica se o texto contém "Aberto" (ignorando maiúsculas/minúsculas) e adiciona a classe apropriada
                                if (status.toLowerCase().includes("aberto")) {
                                    statusElement.classList.add("bg-success");
                                } else {
                                    statusElement.classList.add("bg-danger");
                                }

                                // Incrementa o contador para verificar o próximo elemento
                                i++;
                                statusElement = document.getElementById("statusText_" + i);
                            }
                        });
                    </script>

            <?php
                }
            } else {
                echo "<p class='text-muted'>Não há tickets abertos.</p>";
            }
            ?>
        </div>
    </div>
</div>