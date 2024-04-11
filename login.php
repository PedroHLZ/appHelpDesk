<div class="p-5">
    <div class="text-center">
        <h3 class="h4 text-gray-900 mb-4">Faça Login na sua Conta</h3>
    </div>
    <form action="sys/process_valida_login.php" method="post">
        <div class="form-group mb-3">
            <input name="email" id="email" type="email" class="form-control form-control-user" placeholder="E-mail" autocomplete="email" required>
        </div>
        <div class="form-group mb-3">
            <input name="senha" id="senha" type="password" class="form-control form-control-user" placeholder="Senha" autocomplete="current-password" required>
        </div>
        <div class="form-group text-center">
            <?php if (isset($_GET['login']) && $_GET['login'] == 'erro') { ?>
                <div class="text-danger">
                    Usuário ou senha inválido(s)
                </div>
            <?php } ?>
            <button class="btn btn-primary btn-user btn-block" type="submit">Entrar</button>
        </div>
    </form>
    <hr>
    <div class="text-center">
        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#esqueceuSenhaModal"><i class="fas fa-sign-in-alt me-1"></i> Esqueceu a Senha?</a>
    </div>
    <div class="text-center">
        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#criarContaModal"><i class="fas fa-sign-in-alt me-1"></i> Já tem uma conta? Faça login!</a>
    </div>
</div>
