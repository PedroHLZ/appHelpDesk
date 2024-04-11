<div class="container">
    <div class="p-6">
        <div class="row">
            <div class="col-lg-12">
                <div class="border-bottom pb-4 mb-4">
                    <h3 class="mb-0 fw-bold">Criar uma Conta!</h3>
                </div>
            </div>
        </div>
        <div class="mb-4 row">
            <div class="col-xl-9 col-lg-8">
                <div id="edit" class="card">
                    <div class="card-body">
                        <div class="mb-6">
                            <div class="row">
                                <h4 class="mb-1">Novo Usuário</h4>
                                <hr>
                            </div>
                            <form action="../sys/process_registeradm.php" method="post" onsubmit="return validateForm()">
                                <div class="mb-3 row">
                                    <label for="username" class="col-sm-4 col-form-label form-label">Nome</label>
                                    <div class="col-md-4 col-12">
                                        <input type="text" id="username" class="form-control" name="username" placeholder="Nome" autocomplete="name" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="sobrenome" placeholder="Sobrenome">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="email" class="col-sm-4 col-form-label form-label">Email</label>
                                    <div class="col-md-8 col-12">
                                        <input type="email" id="email" class="form-control" name="email" placeholder="Email" autocomplete="email" required>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="password" class="col-sm-4 col-form-label form-label">Senha</label>
                                    <div class="col-md-8 col-12">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Senha" required>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="confirm_password" class="col-sm-4 col-form-label form-label">Repetir Senha</label>
                                    <div class="col-md-8 col-12">
                                        <input type="password" class="form-control form-control-user" id="confirm_password" name="confirm_password" placeholder="Repetir Senha" required>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="telefone" class="col-sm-4 col-form-label form-label">Telefone</label>
                                    <div class="col-md-8 col-12">
                                        <input type="text" class="form-control" name="telefone" placeholder="Digite o Telefone">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="endereco" class="col-sm-4 col-form-label form-label">Endereço</label>
                                    <div class="col-md-8 col-12">
                                        <input type="text" class="form-control" name="endereco" placeholder="Digite o Endereço">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="codigo_postal" class="col-sm-4 col-form-label form-label">Código Postal</label>
                                    <div class="col-md-8 col-12">
                                        <input type="text" class="form-control" name="codigo_postal" placeholder="Digite o Código Postal">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="registration_code" class="col-sm-4 col-form-label form-label">Código de Cadastro</label>
                                    <div class="col-md-8 col-12">
                                        <input type="text" class="form-control form-control-user" id="registration_code" name="registration_code" placeholder="Código de Cadastro:" required>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-8 col-12 offset-md-4">
                                        <button type="submit" class="btn btn-success">Criar Conta</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>