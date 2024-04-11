<?php
require_once "../config.php";

// Consulta SQL para obter os tickets fechados
$sql = "SELECT t.id, t.titulo, t.descricao, t.status, t.data_abertura, t.user_id, u.username 
        FROM tickets t 
        JOIN users u ON t.user_id = u.id
       ";
$result = $conn->query($sql);
?>


<div class="container-fluid">
    <div class="p-6 container-fluid">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="border-bottom pb-4 mb-4">
                    <h3 class="mb-0 fw-bold">Todos os Tickets</h3>
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
                                            <strong>Usuário:</strong> <?php echo $row['username']; ?> 
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h4 class="mb-1">
                                            <p class="card-text"><strong>Status:</strong> <?php echo $row['status']; ?></p>
                                            </h4>
                                            <p class="card-text"><strong>Data:</strong> <?php echo $row['data_abertura']; ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <p class="card-text"><strong>Título:</strong> <br><?php echo $row['titulo']; ?></p>
                                    <p class="card-text"><strong>Descrição:</strong><br> <?php echo $row['descricao']; ?></p>
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-end">
                                            <form action='historico.php' method='get'>
                                                <input type='hidden' name='ticket_id' value='<?php echo $row['id']; ?>'>
                                                <button type='submit' name='submit_close' class='btn btn-danger'>
                                                    <i class='fas fa-reply me-1'></i>Historico
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p class='text-muted'>Não há tickets.</p>";
            }
            ?>
        </div>
    </div>
</div>

<!-- ------------------------------------------------->






