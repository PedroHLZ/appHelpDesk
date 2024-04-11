<?php
define('MY_APP_CONFIG', true);
// Iniciar a sessão (se ainda não estiver iniciada)
session_start();
// Incluir o arquivo de configuração do banco de dados
require_once "../config.php";
require_once "../engine.php";

// Verificar se o usuário está logado e tem o nível de acesso adequado
if (!isset($_SESSION['id']) || $_SESSION['level'] < 1) {
    // Redirecionar para a página de login se o usuário não estiver logado ou não tiver acesso suficiente
    header("Location: login.php");
    exit;
}

// Recuperar o ID do usuário logado na sessão
$user_id = $_SESSION['id'];

// Estabelecer a conexão com o banco de dados
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Verificar se houve algum erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $titulo_do_site; ?> - Painel do Administrador</title>

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <!-- Fonte personalizada do Google-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

   <!-- styles -->
   <link href="../css/sb-admin-2.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        require_once "usersidebar.php";
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                require_once "usertopbar.php";
                ?>
                <!-- Begin Page Content -->

                <div class="container-fluid">
                    <div class="p-6 container-fluid">

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="border-bottom pb-4 mb-4">
                                    <h3 class="mb-0 fw-bold">Geral</h3>
                                </div>
                            </div>
                        </div>
                        <div class="mb-8 row">

                            <div class="mb-4 col-xl-9 col-lg-8 col-md-12 col-12">
                                <div id="edit" class="card">
                                    <div class="card-body">
                                        <div class="mb-6">
                                            <h4 class="mb-1">Configurações do perfil</h4>
                                            <hr>
                                        </div>

                                        <div class="mb-3 row">
                                            <div class="mb-3 mb-md-0 col-md-4 mt-md-3">
                                                <h5 class="mb-0">Avatar</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <img src="<?php echo $enderecodosite; ?>/user_img/<?php echo $foto_perfil; ?>" alt="" class="rounded-circle avatar avatar-lg" style="width: 50px; height: 50px;">
                                                    </div>
                                                    <div class="col-md-4">

                                                        <!--   ------------------------------------------->
                                                        <form id="uploadForm" action="../sys/process_upload_foto_perfil.php" method="post" enctype="multipart/form-data" class="mb-3"> <!-- Adiciona margem na parte inferior -->
                                                            <input type="file" name="foto_perfil" id="fotoPerfilInput" style="display: none;">
                                                            <label for="fotoPerfilInput" style="cursor: pointer;" class="me-2">Selecionar Foto</label> <!-- Adiciona margem à direita -->
                                                            <button type="submit" id="uploadButton" style="display: none;" class="ms-2">Upload</button> <!-- Adiciona margem à esquerda -->
                                                        </form>


                                                        <script>
                                                                // Verificar se o elemento existe antes de tentar adicionar o ouvinte de evento
                                                                var fotoPerfilInput = document.getElementById("fotoPerfilInput");
                                                                if (fotoPerfilInput) {
                                                                    fotoPerfilInput.addEventListener("change", function() {
                                                                        document.getElementById("uploadButton").click();
                                                                    }, {
                                                                        passive: true
                                                                    });
                                                                } else {
                                                                    console.error("Elemento fotoPerfilInput não encontrado");
                                                                }
                                                    
                                                        </script>


                                                        <!--   ------------------------------------------->

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div>

                                            <form action="../sys/process_update_conta.php" method="post" onsubmit="return validateForm()">
                                                <div class="mb-3 row">
                                                    <label for="fullName" class="col-sm-4 col-form-label form-label">Nome Completo</label>
                                                    <div class="col-sm-4 mb-3 mb-lg-0">
                                                        <input type="text" id="fullName" name="username" class="form-control" placeholder="Nome" autocomplete="name" value="<?php echo isset($nome_do_usuario) ? $nome_do_usuario : ''; ?>">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" id="lastName" name="sobrenome" class="form-control" placeholder="Sobrenome" value="<?php echo isset($sobrenome_do_usuario) ? $sobrenome_do_usuario : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="email" class="col-sm-4 col-form-label form-label">Email</label>
                                                    <div class="col-md-8 col-12">
                                                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" autocomplete="email" value="<?php echo isset($email_do_usuario) ? $email_do_usuario : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 form-label" for="phone">Telefone <span class="text-muted">(Opcional)</span></label>
                                                    <div class="col-md-8 col-12">
                                                        <input type="text" id="phone" name="telefone" class="form-control" placeholder="Telefone" autocomplete="text" value="<?php echo isset($telefone_do_usuario) ? $telefone_do_usuario : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 form-label" for="addressLine">Endereço:</label>
                                                    <div class="col-md-8 col-12">
                                                        <input type="text" id="addressLine" name="endereco" class="form-control" placeholder="Endereço" autocomplete="text" value="<?php echo isset($endereco_do_usuario) ? $endereco_do_usuario : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="align-items-center row">
                                                    <label class="col-sm-4 form-label" for="zipcode">Código Postal<i class="fe fe-info fs-4 me-2 text-muted icon-xs"></i></label>
                                                    <div class="col-md-8 col-12">
                                                        <input type="text" id="zipcode" name="codigo_postal" class="form-control" placeholder="Código Postal" autocomplete="text" value="<?php echo isset($codigo_postal_do_usuario) ? $codigo_postal_do_usuario : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="mt-4 col-md-12 col-12 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                                </div>
                                                <input type="text" id="user_id" name="user_id" class="form-control" placeholder="user_id" autocomplete="name" value="<?php echo isset($user_id) ? $user_id : ''; ?>" hidden>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-8 row">

                            <div class="mb-4 col-xl-9 col-lg-8 col-md-12 col-12">
                                <div id="edit" class="card">
                                    <div class="card-body">
                                        <div class="mb-6">
                                            <h4 class="mb-1">Alterar sua senha</h4>
                                            <hr>
                                        </div>
                                        <form action="../sys/process_update_senha.php" method="post" onsubmit="return validateForm()">
                                            <div class="mb-3 row">
                                                <label class="col-sm-4 form-label" for="password">Nova senha</label>
                                                <div class="col-md-8 col-12">
                                                    <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" placeholder="Senha" required>
                                                </div>
                                            </div>
                                            <div class="align-items-center row">
                                                <label class="col-sm-4 form-label" for="confirm_password">Confirme a nova senha</label>
                                                <div class="col-md-8 col-12">
                                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" autocomplete="new-password" placeholder="Repetir Senha" required>
                                                </div>
                                                <div class="mt-4 col-md-8 col-12 offset-md-4">
                                                    <h6 class="mb-1">Requisitos da senha:</h6>
                                                    <p>Certifique-se de que estes requisitos sejam cumpridos:</p>
                                                    <ul>
                                                        <li>Mínimo de 8 caracteres - quanto mais, melhor</li>
                                                        <li>Pelo menos um caractere minúsculo</li>
                                                        <li>Pelo menos um caractere maiúsculo</li>
                                                        <li>Pelo menos um número, símbolo ou caractere de espaço</li>
                                                    </ul>
                                                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                                </div>
                                            </div>
                                            <!-- Adicionado campo hidden para enviar o ID do usuário logado -->
                                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="mb-4 col-xl-9 col-lg-8 col-md-12 col-12">
                                <div class="mb-6 card">
                                    <div class="card-body">
                                        <div class="mb-6">
                                            <h4 class="mb-1">Zona de Perigo</h4>
                                            <hr>
                                        </div>
                                        <div>
                                            <p>Exclua todo o conteúdo que você possui como tickets, mensagens de chat. Permita que seu nome de usuário fique disponível para qualquer pessoa.</p>
                                            <a class="btn btn-danger" href="settings#">Excluir Conta</a>
                                            <p class="small mb-0 mt-3">Sinta-se à vontade para entrar em contato com qualquer dúvida <a href="settings#"></a>.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <!-- /.container-fluid -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; <?php echo $titulo_do_site; ?></span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

                <!-- Scroll to Top Button-->
                <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a>

                <!-- Custom scripts for all pages-->
                <script src="../js/sb-admin-2.min.js"></script>
                <script src="../js/conteudoPagina.js"></script>



</body>

</html>