$(document).ready(function() {
    const API_URL = '/api/auth/reset-password';

    $('#toggle-password').on('click', function() {
        const passwordInput = $('#password');
        const eyeIcon = $('#eye-icon');
        const eyeOffIcon = $('#eye-off-icon');

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            eyeIcon.addClass('hidden');
            eyeOffIcon.removeClass('hidden');
        } else {
            passwordInput.attr('type', 'password');
            eyeIcon.removeClass('hidden');
            eyeOffIcon.addClass('hidden');
        }
    });

    function showError(message) {
        $('#error-text').text(message);
        $('#error-message').removeClass('hidden');
        $('#success-message').addClass('hidden');
    }

    function showSuccess(message) {
        $('#success-text').text(message);
        $('#success-message').removeClass('hidden');
        $('#error-message').addClass('hidden');
    }

    function hideMessages() {
        $('#error-message').addClass('hidden');
        $('#success-message').addClass('hidden');
    }

    function setLoading(loading) {
        const submitBtn = $('#submit-btn');
        const btnText = $('#btn-text');
        const btnSpinner = $('#btn-spinner');

        if (loading) {
            submitBtn.prop('disabled', true);
            btnText.text('Redefinindo...');
            btnSpinner.removeClass('hidden');
        } else {
            submitBtn.prop('disabled', false);
            btnText.text('Redefinir senha');
            btnSpinner.addClass('hidden');
        }
    }

    $('#forgot-password-form').on('submit', function(e) {
        e.preventDefault();
        hideMessages();

        const email = $('#email').val().trim();
        const password = $('#password').val();
        const passwordConfirmation = $('#password_confirmation').val();

        if (!email || !password || !passwordConfirmation) {
            showError('Por favor, preencha todos os campos.');
            return;
        }

        if (password.length < 6) {
            showError('A senha deve ter pelo menos 6 caracteres.');
            return;
        }

        if (password !== passwordConfirmation) {
            showError('As senhas não conferem.');
            return;
        }

        setLoading(true);

        $.ajax({
            url: API_URL,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                email: email,
                password: password,
                password_confirmation: passwordConfirmation
            }),
            success: function(response) {
                showSuccess('Senha redefinida com sucesso! Redirecionando para login...');
                
                setTimeout(function() {
                    window.location.href = '/login';
                }, 2000);
            },
            error: function(xhr) {
                let errorMessage = 'Erro ao redefinir senha. Tente novamente.';
                
                if (xhr.status === 404) {
                    errorMessage = 'E-mail não encontrado no sistema.';
                } else if (xhr.status === 422) {
                    const response = xhr.responseJSON;
                    if (response && response.errors) {
                        const errors = Object.values(response.errors).flat();
                        errorMessage = errors.join(' ');
                    } else if (response && response.message) {
                        errorMessage = response.message;
                    }
                } else if (xhr.status === 500) {
                    errorMessage = 'Erro interno do servidor. Tente novamente mais tarde.';
                } else if (xhr.status === 0) {
                    errorMessage = 'Não foi possível conectar ao servidor.';
                }

                showError(errorMessage);
                setLoading(false);
            }
        });
    });

    $('#email, #password, #password_confirmation').on('input', function() {
        hideMessages();
    });
});
