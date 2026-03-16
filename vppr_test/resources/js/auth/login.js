$(document).ready(function() {
    const API_URL = '/api/auth/login';

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
            btnText.text('Entrando...');
            btnSpinner.removeClass('hidden');
        } else {
            submitBtn.prop('disabled', false);
            btnText.text('Entrar');
            btnSpinner.addClass('hidden');
        }
    }

    function saveToken(token, remember) {
        if (remember) {
            localStorage.setItem('auth_token', token);
        } else {
            sessionStorage.setItem('auth_token', token);
        }
    }

    function checkAuth() {
        const token = localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token');
        if (token) {
            window.location.href = '/dashboard';
        }
    }

    checkAuth();

    $('#login-form').on('submit', function(e) {
        e.preventDefault();
        hideMessages();
        setLoading(true);

        const email = $('#email').val().trim();
        const password = $('#password').val();
        const remember = $('#remember').is(':checked');

        if (!email || !password) {
            showError('Por favor, preencha todos os campos.');
            setLoading(false);
            return;
        }

        $.ajax({
            url: API_URL,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                email: email,
                password: password
            }),
            success: function(response) {
                if (response.token) {
                    saveToken(response.token, remember);
                    showSuccess('Login realizado com sucesso! Redirecionando...');
                    
                    setTimeout(function() {
                        window.location.href = '/dashboard';
                    }, 1500);
                } else {
                    showError('Resposta inválida do servidor.');
                    setLoading(false);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Erro ao realizar login. Tente novamente.';
                
                if (xhr.status === 401) {
                    errorMessage = 'E-mail ou senha incorretos.';
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

    $('#email, #password').on('input', function() {
        hideMessages();
    });
});
