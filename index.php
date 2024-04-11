
<?php
define('MY_APP_CONFIG', true);
include 'config.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página Inicial do Help Desk">
    <meta name="author" content="Seu Nome">
    <title>App Help Desk - Página Inicial</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    <!-- CSS -->
    <link href="styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Inclua o jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>
    <!-- Bootstrap core JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js"></script>
    <!-- Ícones do Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />

</head>

<body class="d-flex flex-column h-100">
    <header>
        <!-- Barra de Navegação -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
            <div class="container px-5">
                <a class="navbar-brand" href="#">
                <i class="fas fa-life-ring me-2"></i>
                    <span class="fw-bolder text-primary">App Help Desk</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">
                        <li class="nav-item"><a class="nav-link" href="inicio"><i class="fas fa-home me-1"></i>Início</a></li>
                        <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#contactModal"><i class="fas fa-envelope me-1"></i>Contato</a></li>
                        <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#criarContaModal"><i class="fas fa-user-plus me-1"></i> Criar Conta</a></li>
                        <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fas fa-sign-in-alt me-1"></i> Entrar</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Fim da Barra de Navegação -->

        <!-- Cabeçalho -->
        <header class="py-5">
            <div class="container px-5 pb-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-12 col-lg-5">
                        <!-- Texto do Cabeçalho -->
                        <div class="text-center text-lg-start">
                            <div class="badge bg-gradient-primary-to-secondary text-white mb-4">
                                <div class="text-uppercase">Soluções de Help Desk</div>
                            </div>
                            <h1 class="display-3 fw-bolder mb-2"><span class="text-gradient d-inline">App Help Desk</span></h1>
                            <div class="fs-4 fw-light text-muted">Oferecendo suporte técnico excepcional.</div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-7">
                        <!-- Imagem do Cabeçalho -->
                        <div class="d-flex justify-content-center justify-content-lg-end mt-5 mt-lg-0">
                            <img src="img/imghome.svg" alt="Imagem de Help Desk" class="img-fluid" />
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </header>

    <main>
        <!-- Seção de Serviços -->
        <section class="bg-light py-5">
            <div class="container px-5">
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center">
                            <h2 class="fw-bolder">Nossos Serviços</h2>
                            <p class="text-muted fs-5 mb-4">Conheça os serviços que oferecemos para ajudar sua empresa.</p>
                        </div>
                    </div>
                </div>
                <div class="row gx-5">
                    <div class="col-lg-4 mb-5">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="fas fa-laptop fs-3"></i></div>
                        <h2 class="h4 fw-bolder">Suporte Técnico</h2>
                        <p class="text-muted mb-0">Oferecemos suporte técnico especializado para resolver seus problemas de TI.</p>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="fas fa-life-ring fs-3"></i></div>
                        <h2 class="h4 fw-bolder">Atendimento 24/7</h2>
                        <p class="text-muted mb-0">Estamos disponíveis 24 horas por dia, 7 dias por semana, para ajudá-lo sempre que precisar.</p>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="fas fa-users fs-3"></i></div>
                        <h2 class="h4 fw-bolder">Treinamento</h2>
                        <p class="text-muted mb-0">Oferecemos treinamento para sua equipe de TI para maximizar a eficiência e a produtividade.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Seção de Informações de Contato -->
        <section class="py-5">
            <div class="container px-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6 order-lg-2">
                        <div class="p-5">
                            <img src="img/contact_image.jpg" alt="Contato" class="img-fluid rounded-circle">
                        </div>
                    </div>
                    <div class="col-lg-6 order-lg-1">
                        <div class="p-5">
                            <h2 class="display-4 fw-bolder">Entre em Contato</h2>
                            <p class="text-muted fs-5 mb-4">Estamos aqui para ajudá-lo. Entre em contato conosco para obter suporte técnico.</p>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#contactModal" class="btn btn-primary btn-lg">Entre em Contato</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Seção de Solicitação de Suporte -->
        <section class="bg-light py-5">
            <div class="container px-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="p-5">
                            <img src="img/support_request_image.png" alt="Solicitação de Suporte" class="img-fluid rounded-circle">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <h2 class="display-4 fw-bolder">Solicitação de Suporte</h2>
                            <p class="text-muted fs-5 mb-4">Precisa de ajuda? Preencha nosso formulário de solicitação de suporte e entraremos em contato com você o mais breve possível.</p>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#contactModal" class="btn btn-primary btn-lg">Solicitar Suporte</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Rodapé -->
    <footer class="py-4 mt-auto bg-light">
        <div class="container px-5">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-4 text-center text-md-start">© <?php echo date("Y"); ?> App Help Desk. Todos os direitos reservados.</div>
                <div class="col-md-4 text-center">
                    <a class="btn btn-outline-primary btn-social mx-1" href="#!"><i class="fab fa-facebook"></i></a>
                    <a class="btn btn-outline-primary btn-social mx-1" href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
  <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
</svg></a>
                    <a class="btn btn-outline-primary btn-social mx-1" href="#!"><i class="fab fa-linkedin"></i></a>
                </div>
                <div class="col-md-4 text-center text-md-end">
                    <a class="text-decoration-none" href="#!">Política de Privacidade</a>
                    <span class="mx-2">&#xB7;</span>
                    <a class="text-decoration-none" href="#!">Termos de Uso</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modais -->


    <!-- Modal - Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary-to-secondary p-4">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Bem-vindo de volta!</h5>
                    <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulário de Login -->
                    <?php include "login.php"; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Novo modal para exibir mensagens de erro -->
    <div class="modal fade" id="erroModal" tabindex="-1" aria-labelledby="erroModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body text-center">
                    <i class="fas fa-exclamation-circle fa-5x text-danger"></i>
                    <?php
                    // Verificar se há uma mensagem de erro
                    if (isset($_GET['login']) && $_GET['login'] == 'erro' && isset($_GET['mensagem'])) {
                        echo '<div class="alert alert-danger mt-3" role="alert">' . $_GET['mensagem'] . '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Exibir o modal de erro quando houver uma mensagem de erro
        $(document).ready(function() {
            <?php if (isset($_GET['login']) && $_GET['login'] == 'erro' && isset($_GET['mensagem'])) : ?>
                $('#erroModal').modal('show');
            <?php endif; ?>
        });
    </script>

    <!-- Modal - Criar Conta -->
    <div class="modal fade" id="criarContaModal" tabindex="-1" aria-labelledby="criarContaModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary-to-secondary p-4">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Criar uma Conta</h5>
                    <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulário de Criação de Conta -->
                    <?php include "register.php"; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal - contact -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary-to-secondary p-4">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Entre em Contato</h5>
                    <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulário de Criação de Conta -->
                    <?php include "contact.php"; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js"></script>
    <!-- Outros Scripts -->
    <!-- Por exemplo: Analytics, Plugins personalizados, etc. -->
</body>

</html>