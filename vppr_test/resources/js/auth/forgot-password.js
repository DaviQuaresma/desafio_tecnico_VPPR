import { resetPassword } from '../api/auth.js';
import { getErrorMessage } from '../api/index.js';
import { toastSuccess, toastError } from '../helpers/messages.js';
import { setResetPasswordLoading } from '../helpers/loading.js';
import { setupPasswordToggle, validatePassword, validatePasswordConfirmation } from '../helpers/password.js';

$(document).ready(function() {
    setupPasswordToggle();

    $('#forgot-password-form').on('submit', async function(e) {
        e.preventDefault();

        const email = $('#email').val().trim();
        const password = $('#password').val();
        const password_confirmation = $('#password_confirmation').val();

        if (!email || !password || !password_confirmation) {
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

        setResetPasswordLoading(true);

        try {
            await resetPassword(email, password, password_confirmation);
            toastSuccess('Senha redefinida com sucesso!');
            setTimeout(() => window.location.href = '/login', 1500);
        } catch (error) {
            const msg = error.response?.status === 404 
                ? 'E-mail não encontrado.' 
                : getErrorMessage(error, 'Erro ao redefinir senha.');
            toastError(msg);
            setResetPasswordLoading(false);
        }
    });
});
