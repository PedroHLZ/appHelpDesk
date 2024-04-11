<?php
define('MY_APP_CONFIG', true);
// Incluindo informações comuns das páginas anteriores
require_once "config.php"; // Arquivo de configuração do banco de dados e outras configurações comuns

// Processar o formulário de contato quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturando os dados do formulário
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    // Validação básica (pode adicionar validações mais complexas conforme necessário)
    if (empty($name) || empty($email) || empty($message)) {
        // Mensagem de erro em caso de campos obrigatórios vazios
        $errorMessage = "Por favor, preencha todos os campos obrigatórios.";
    } else {
        // Se todos os campos estão preenchidos, processar o envio do formulário (exemplo simples)
        // Aqui você pode adicionar o código para enviar e armazenar os dados no banco de dados, enviar e-mail, etc.
        // Exemplo simples: redirecionamento após o envio bem-sucedido
        header("Location: contact.php?status=success");
        exit;
    }
}
?>



        <!-- Conteúdo da página-->
        <section class="py-2">
            <div class="container px-2">
                <!-- Formulário de contato-->
                <div class="bg-light rounded-4 py-2 px-md-2">
                    <div class="text-center mb-5">
                        <div class="feature bg-primary bg-gradient-primary-to-secondary text-white rounded-3 mb-3"><i class="bi bi-envelope"></i></div>
                        <h1 class="fw-bolder">Estamos aqui para ajudá-lo.</h1>
                        <p class="lead fw-normal text-muted mb-0">
                            Entre em contato conosco para obter suporte técnico.</p>
                    </div>
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-11 col-xl-11">
                            <!-- Formulário de Contato-->
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <!-- Campo: Nome -->
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="name" name="name" type="text" placeholder="Digite seu nome..." value="<?php echo isset($name) ? $name : ''; ?>" required />
                                    <label for="name">Nome Completo</label>
                                </div>
                                <!-- Campo: E-mail -->
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="email" name="email" type="email" placeholder="nome@example.com" value="<?php echo isset($email) ? $email : ''; ?>" required />
                                    <label for="email">Endereço de E-mail</label>
                                </div>
                                <!-- Campo: Telefone -->
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="phone" name="phone" type="tel" placeholder="(123) 456-7890" value="<?php echo isset($phone) ? $phone : ''; ?>" required />
                                    <label for="phone">Número de Telefone</label>
                                </div>
                                <!-- Campo: Mensagem -->
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" id="message" name="message" placeholder="Digite sua mensagem aqui..." style="height: 10rem" required><?php echo isset($message) ? $message : ''; ?></textarea>
                                    <label for="message">Mensagem</label>
                                </div>
                                <!-- Botão de Envio -->
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-lg" type="submit">Enviar</button>
                                </div>
                                <?php
                                // Exibir mensagem de erro se houver
                                if (isset($errorMessage)) {
                                    echo '<div class="text-danger mt-3">' . $errorMessage . '</div>';
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Scripts JS do tema -->
    <script src="js/scripts.js"></script>