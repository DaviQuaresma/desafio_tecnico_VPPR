import { login } from '../api/auth.js';
import { checkAuthRedirect, saveToken } from '../helpers/auth.js';
import { toastSuccess, toastError } from '../helpers/messages.js';
import { setLoginLoading } from '../helpers/loading.js';
import { setupPasswordToggle } from '../helpers/password.js';

$(document).ready(function() {
    if (checkAuthRedirect()) return;

    setupPasswordToggle();

    $('#login-form').on('submit', async function(e) {
        e.preventDefault();
        
        const email = $('#email').val().trim();
        const password = $('#password').val();
        const remember = $('#remember').is(':checked');

        if (!email || !password) {
            toastError('Por favor, preencha todos os campos.');
            return;
        }

        setLoginLoading(true);

        try {
            const data = await login(email, password);
            
            if (data.token) {
                saveToken(data.token, remember);
                toastSuccess('Login realizado com sucesso!');
                setTimeout(() => window.location.href = '/dashboard', 1000);
            }
        } catch (error) {
            const msg = error.response?.status === 401 
                ? 'E-mail ou senha incorretos.' 
                : 'Erro ao realizar login.';
            toastError(msg);
            setLoginLoading(false);
        }
    });
});
