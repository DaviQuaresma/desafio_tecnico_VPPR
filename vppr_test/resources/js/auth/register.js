import { register } from '../api/auth.js';
import { getErrorMessage } from '../api/index.js';
import { checkAuthRedirect, saveToken } from '../helpers/auth.js';
import { toastSuccess, toastError } from '../helpers/messages.js';
import { setRegisterLoading } from '../helpers/loading.js';
import { setupPasswordToggle, validatePassword, validatePasswordConfirmation } from '../helpers/password.js';

$(document).ready(function() {
    if (checkAuthRedirect()) return;

    setupPasswordToggle();

    $('#register-form').on('submit', async function(e) {
        e.preventDefault();

        const name = $('#name').val().trim();
        const email = $('#email').val().trim();
        const password = $('#password').val();
        const password_confirmation = $('#password_confirmation').val();

        if (!name || !email || !password || !password_confirmation) {
            toastError('Por favor, preencha todos os campos.');
            return;
        }

        const pwdValidation = validatePassword(password);
        if (!pwdValidation.valid) {
            toastError(pwdValidation.errors.join(' '));
            return;
        }

        const confirmValidation = validatePasswordConfirmation(password, password_confirmation);
        if (!confirmValidation.valid) {
            toastError(confirmValidation.error);
            return;
        }

        setRegisterLoading(true);

        try {
            const data = await register({ name, email, password, password_confirmation });
            
            if (data.token) {
                saveToken(data.token);
                toastSuccess('Conta criada com sucesso!');
                setTimeout(() => window.location.href = '/dashboard', 1000);
            }
        } catch (error) {
            toastError(getErrorMessage(error, 'Erro ao criar conta.'));
            setRegisterLoading(false);
        }
    });
});
