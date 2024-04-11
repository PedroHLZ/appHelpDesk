<div class="p-5">
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Criar uma Conta!</h1>
    </div>

    <form id="registrationForm" action="sys/process_register.php" method="post">
        <div class="mb-3 row">
            <div class="col-sm-6 mb-3 mb-lg-0">
                <input type="text" id="username" class="form-control" name="username" placeholder="Nome" autocomplete="name" required>
                <div id="username_error" style="color: red;"></div>
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Sobrenome">
                <div id="sobrenome_error" style="color: red;"></div>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-md-12 col-12">
                <input name="email" type="email" class="form-control form-control-user" placeholder="E-mail" autocomplete="email" required>
                <div id="email_error" style="color: red;"></div>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-md-12 col-12">
                <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Senha" autocomplete="new-password" required>
                <div id="password_error" style="color: red;"></div>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-md-12 col-12">
                <input type="password" class="form-control form-control-user" id="confirm_password" name="confirm_password" placeholder="Repetir Senha" autocomplete="new-password" required>
                <div id="confirm_password_error" style="color: red;"></div>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-md-12 col-12">
                <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="Digite o Telefone">
                <div id="telefone_error" style="color: red;"></div>
            </div>
        </div>

        <div class="mb-3 row">
            <div class="col-md-12 col-12">
                <input type="text" class="form-control" name="endereco" placeholder="Digite o Endereço">
                <div id="endereco_error" style="color: red;"></div>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-md-12 col-12">
                <input type="text" class="form-control" name="codigo_postal" placeholder="Digite o Código Postal">
                <div id="codigo_postal_error" style="color: red;"></div>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-md-12 col-12">
                <input type="text" class="form-control form-control-user" id="registration_code" name="registration_code" placeholder="Código de Cadastro:" required>
                <div id="registration_code_error" style="color: red;"></div>

            </div>
        </div>
        <div class="mt-4 col-md-12 col-12 offset-md-4">
            <button type="submit" class="btn btn-success">Criar Conta</button>
        </div>
    </form>
    <hr>
    <div class="text-center">
        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fas fa-sign-in-alt me-1"></i> Esqueceu a Senha?</a>
    </div>
    <div class="text-center">
        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fas fa-sign-in-alt me-1"></i> Já tem uma conta? Faça login!</a>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registrationForm');

        const showError = (input, message) => {
            const errorElement = document.getElementById(input.id + '_error');
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
            errorElement.textContent = message;
        };

        const showSuccess = (input) => {
            const errorElement = document.getElementById(input.id + '_error');
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            errorElement.textContent = '';
        };

        const checkUsername = () => {
            const username = document.getElementById('username');
            if (username.value.trim().length < 4) {
                showError(username, 'Username deve ter pelo menos 4 caracteres');
            } else {
                showSuccess(username);
            }
        };

        const checkSobrenome = () => {
            const sobrenome = document.getElementById('sobrenome');
            if (sobrenome.value.trim().length < 4) {
                showError(sobrenome, 'Sobrenome deve ter pelo menos 4 caracteres');
            } else {
                showSuccess(sobrenome);
            }
        };

        function checkEmail() {
            const emailInput = document.getElementsByName('email')[0]; // Correção aqui
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const errorElement = document.getElementById('email_error');

            if (!emailRegex.test(emailInput.value)) {
                emailInput.classList.add('is-invalid');
                if (errorElement) {
                    errorElement.textContent = "O endereço de e-mail inserido não é válido.";
                }
                return false;
            } else {
                emailInput.classList.remove('is-invalid');
                emailInput.classList.add('is-valid');
                if (errorElement) {
                    errorElement.textContent = "";
                }
                return true;
            }
        }


        const checkPassword = () => {
            const password = document.getElementById('password');
            if (password.value.length < 6) {
                showError(password, 'Senha deve ter pelo menos 6 caracteres');
            } else {
                showSuccess(password);
            }
        };

        const checkConfirmPassword = () => {
            const confirmPassword = document.getElementById('confirm_password');
            const password = document.getElementById('password');
            if (confirmPassword.value !== password.value) {
                showError(confirmPassword, 'As senhas não correspondem');
            } else {
                showSuccess(confirmPassword);
            }
        };

        function checkTelefone() {
            const telefoneInput = document.getElementById('telefone');
            const telefoneValue = telefoneInput.value.replace(/\D/g, ''); // Remove todos os caracteres que não são dígitos
            const telefoneRegex = /^(\d{2})(\d{1})(\d{4})(\d{4})$/;

            if (!telefoneRegex.test(telefoneValue)) {
                telefoneInput.classList.add('is-invalid');
                document.getElementById('telefone_error').innerText = "Formato de telefone inválido. Use o formato (99) - 9 - 9999-9999";
                return false;
            } else {
                // Aplica o formato correto
                const telefoneFormatado = '(' + telefoneValue.substring(0, 2) + ') - ' +
                    telefoneValue.substring(2, 3) + ' - ' +
                    telefoneValue.substring(3, 7) + '-' +
                    telefoneValue.substring(7);
                telefoneInput.value = telefoneFormatado;

                telefoneInput.classList.remove('is-invalid');
                telefoneInput.classList.add('is-valid');
                document.getElementById('telefone_error').innerText = "";
                return true;
            }
        }

        const checkEndereco = () => {
            const endereco = document.getElementsByName('endereco')[0];
            const enderecoRegex = /^[\w\s]+, \d+, [\w\s]+, [\w\s]+-[\w\s]+$/;

            if (!enderecoRegex.test(endereco.value)) {
                endereco.classList.add('is-invalid');
                document.getElementById('endereco_error').innerText = "Formato de endereço inválido. Use o formato: Nome, Numero, Bairro , Cidade - Estado";
                return false;
            } else {
                endereco.classList.remove('is-invalid');
                endereco.classList.add('is-valid');
                document.getElementById('endereco_error').innerText = "";
                return true;
            }
        };


        function checkCodigoPostal() {
            const codigoPostalInput = document.getElementsByName('codigo_postal')[0];
            const codigoPostalRegex = /^\d{2}\.\d{3}-\d{3}$/;

            if (!codigoPostalRegex.test(codigoPostalInput.value)) {
                codigoPostalInput.classList.add('is-invalid');
                document.getElementById('codigo_postal_error').innerText = "Formato de código postal inválido. Use o formato 00.000-000";
                return false;
            } else {
                codigoPostalInput.classList.remove('is-invalid');
                codigoPostalInput.classList.add('is-valid');
                document.getElementById('codigo_postal_error').innerText = "";
                return true;
            }
        }
        // Função para validar o código de cadastro
        const checkRegistrationCode = () => {
            const registrationCode = document.getElementById('registration_code').value;
            if (registrationCode.length < 4) {
                document.getElementById('registration_code_error').innerText = "O código de cadastro deve ter no mínimo 4 caracteres";
                return false;
            } else {
                document.getElementById('registration_code_error').innerText = "";
                return true;
            }
        };

        // Adicionar um event listener para o evento input no campo de código de cadastro
        document.getElementById('registration_code').addEventListener('input', function() {
            checkRegistrationCode();
        });



        // Adicionar listeners para eventos de mudança
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            checkUsername();
            checkSobrenome();
            checkEmail();
            checkPassword();
            checkConfirmPassword();
            checkTelefone();
            checkEndereco();
            checkCodigoPostal();

            // Verifique se há algum campo inválido antes de enviar o formulário
            if (
                document.querySelectorAll('.is-invalid').length === 0 &&
                document.querySelectorAll('.form-control:invalid').length === 0
            ) {
                form.submit();
            } else {
                // Se houver campos inválidos, role a página até o topo para exibir os erros
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });

        document.querySelectorAll('.form-control').forEach((input) => {
            input.addEventListener('focus', () => {
                input.classList.remove('is-invalid', 'is-valid');
                const errorElement = document.getElementById(input.id + '_error');
                if (errorElement) {
                    errorElement.textContent = '';
                }
            });
        });

        // Adicionar listeners para eventos de entrada para verificação em tempo real
        document.getElementById('username').addEventListener('input', checkUsername);
        document.getElementById('sobrenome').addEventListener('input', checkSobrenome);
        document.getElementsByName('email')[0].addEventListener('input', checkEmail);
        document.getElementById('password').addEventListener('input', checkPassword);
        document.getElementById('confirm_password').addEventListener('input', checkConfirmPassword);
        document.getElementsByName('telefone')[0].addEventListener('input', checkTelefone);
        document.getElementsByName('endereco')[0].addEventListener('input', checkEndereco);
        document.getElementsByName('codigo_postal')[0].addEventListener('input', checkCodigoPostal);
    });



    // Adicionar um listener de evento 'input' ao campo de telefone
    document.getElementById('telefone').addEventListener('input', function(event) {
        // Obter o valor atual do campo de telefone
        let telefone = event.target.value;

        // Remover todos os caracteres não numéricos do número de telefone
        telefone = telefone.replace(/\D/g, '');

        // Se o número de telefone não tiver exatamente 11 dígitos, não faça nada
        if (telefone.length !== 11) {
            return;
        }

        // Formatar o número de telefone com parênteses e hífen
        telefone = '(' + telefone.substring(0, 2) + ') - ' + telefone.substring(2, 3) + '-' + telefone.substring(3, 7) + '-' + telefone.substring(7, 11);

        // Atualizar o valor do campo de telefone com a formatação
        event.target.value = telefone;
    });


    function formatarCodigoPostal(input) {
        // Remove todos os caracteres não numéricos
        let codigoPostal = input.value.replace(/\D/g, '');

        // Formatação do código postal
        if (codigoPostal.length > 5) {
            codigoPostal = codigoPostal.replace(/^(\d{2})(\d{3})(\d{3})/, '$1.$2-$3');
        }

        // Atualiza o valor do campo
        input.value = codigoPostal;
    }

    document.getElementsByName('codigo_postal')[0].addEventListener('input', function() {
        formatarCodigoPostal(this);
    });

    // Função para capitalizar a primeira letra de cada palavra
    const capitalizeWords = (str) => {
        return str.toLowerCase().replace(/(?:^|\s)\S/g, function(a) {
            return a.toUpperCase();
        });
    };

    // Adicionar um event listener para o evento input no campo de endereço
    document.getElementsByName('endereco')[0].addEventListener('input', function() {
        // Obter o valor atual do campo de endereço
        let enderecoValue = this.value;
        // Capitalizar a primeira letra de cada palavra no valor do campo de endereço
        enderecoValue = capitalizeWords(enderecoValue);
        // Atualizar o valor do campo de endereço com as letras capitalizadas
        this.value = enderecoValue;
    });
</script>