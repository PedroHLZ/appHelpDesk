<?php
define('MY_APP_CONFIG', true);
require_once "../config.php";

// Consulta SQL para selecionar todos os usuários com suas informações
$sql = "SELECT id, username, sobrenome, email, telefone, endereco, codigo_postal FROM users";
$result = $conn->query($sql);
?>


<div class="container-fluid">
    <div class="p-6 container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="border-bottom pb-4 mb-4">
                    <h3 class="mb-0 fw-bold">Editar Usuários</h3>
                </div>
            </div>
        </div>
        <div class="mb-4 row">
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="mb-4 col-xl-9 col-lg-8 col-md-12 col-12">
                        <div id="edit" class="card">
                            <div class="card-body">
                                <div class="mb-6">

                                    <div class="row">
                                        <h4 class="mb-1">Usuários</h4>
                                        <hr>
                                    </div>
                                    <form action="../sys/process_atualizar_usuario.php" method="post" onsubmit="return validateForm()">
                                        <div class="mb-3 row">
                                            <label for="user_id" class="col-sm-4 col-form-label form-label">ID</label>
                                            <div class="col-md-8 col-12">
                                                <input type="text" id="user_id" name="user_id" class="form-control" placeholder="user_id" autocomplete="name" value="<?php echo $row['id']; ?>" readonly>


                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="fullName" class="col-sm-4 col-form-label form-label">Nome Completo</label>
                                            <div class="col-sm-4 mb-3 mb-lg-0">
                                                <input type="text" id="fullName" name="username" class="form-control" placeholder="Nome" autocomplete="name" value="<?php echo $row['username']; ?>">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" id="lastName" name="sobrenome" class="form-control" placeholder="Sobrenome" autocomplete="lastName" value="<?php echo $row['sobrenome']; ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="email" class="col-sm-4 col-form-label form-label">Email</label>
                                            <div class="col-md-8 col-12">
                                                <input type="email" id="email" name="email" class="form-control" placeholder="Email" autocomplete="email" value="<?php echo $row['email']; ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-4 form-label" for="phone">Telefone <span class="text-muted">(Opcional)</span></label>
                                            <div class="col-md-8 col-12">
                                                <input type="text" id="phone" name="telefone" class="form-control" placeholder="Telefone" autocomplete="text" value="<?php echo $row['telefone']; ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-4 form-label" for="addressLine">Endereço:</label>
                                            <div class="col-md-8 col-12">
                                                <input type="text" id="addressLine" name="endereco" class="form-control" placeholder="Endereço" autocomplete="text" value="<?php echo $row['endereco']; ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-sm-4 form-label" for="zipcode">Código Postal<i class="fe fe-info fs-4 me-2 text-muted icon-xs"></i></label>
                                            <div class="col-md-8 col-12">
                                                <input type="text" id="zipcode" name="codigo_postal" class="form-control" placeholder="Código Postal" autocomplete="text" value="<?php echo $row['codigo_postal']; ?>">
                                            </div>
                                        </div>
                                        <div class="align-items-center row">
                                            <label class="col-sm-4 col-form-label form-label">Nível de Acesso</label>
                                            <div class="col-md-8 col-12">
                                                <select class="form-control" name="level">
                                                    <option value="1">Nível 1</option>
                                                    <option value="2">Nível 2</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mt-4 col-md-12 col-12 offset-md-4">
                                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                        </div>
                                    </form>

                                    <hr>
                                    <div class="mb-6">
                                        <div class="row">
                                            <h4 class="mb-1">Alterar sua senha</h4>
                                            <hr>
                                        </div>
                                        <form action="../sys/process_update_senha.php" method="post" onsubmit="return validateForm()">
                                            <div class="mb-3 row">
                                                <label class="col-sm-4 form-label" for="password">Nova senha</label>
                                                <div class="col-md-8 col-12">
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label class="col-sm-4 form-label" for="confirm_password">Confirme a nova senha</label>
                                                <div class="col-md-8 col-12">
                                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Repetir Senha" required>
                                                </div>
                                                <div class="mt-4 col-md-8 col-12 offset-md-4">
                                                    <input type="text" id="user_id" name="user_id" class="form-control" placeholder="user_id" autocomplete="name" value="<?php echo $row['id']; ?>" hidden>
                                                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
<hr>
                                    <div class="mb-6">
                                        <div class="row">
                                            <h4 class="mb-1">Excluir Conta</h4>
                                            <hr>
                                        </div>
                                   
                                        <div class="mb-3 row">
                                            <label class="col-sm-4 form-label" for="confirm_password">Confirme</label>
                                            <div class="col-md-8 col-12">
                                                <form action='../sys/process_excluir_usuario.php' method='post'>
                                                    <input type='hidden' name='user_id' value='<?php echo $row["id"]; ?>'>

                                                    <button type='submit' name='delete_user' class='btn btn-danger'><i class='fas fa-times'></i> Excluir Conta</button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p class='alert alert-danger'>Nenhum usuário encontrado.</p>";
            }
            ?>

        </div>
    </div>
</div>