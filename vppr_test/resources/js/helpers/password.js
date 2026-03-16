export function togglePasswordVisibility(inputSelector = '#password', eyeIconSelector = '#eye-icon', eyeOffIconSelector = '#eye-off-icon') {
    const $passwordInput = $(inputSelector);
    const $eyeIcon = $(eyeIconSelector);
    const $eyeOffIcon = $(eyeOffIconSelector);

    if ($passwordInput.attr('type') === 'password') {
        $passwordInput.attr('type', 'text');
        $eyeIcon.addClass('hidden');
        $eyeOffIcon.removeClass('hidden');
    } else {
        $passwordInput.attr('type', 'password');
        $eyeIcon.removeClass('hidden');
        $eyeOffIcon.addClass('hidden');
    }
}

export function setupPasswordToggle(buttonSelector = '#toggle-password', inputSelector = '#password', eyeIconSelector = '#eye-icon', eyeOffIconSelector = '#eye-off-icon') {
    $(buttonSelector).on('click', function() {
        togglePasswordVisibility(inputSelector, eyeIconSelector, eyeOffIconSelector);
    });
}

export function validatePassword(password) {
    const errors = [];
    
    if (!password) {
        errors.push('A senha é obrigatória.');
        return { valid: false, errors };
    }
    
    if (password.length < 6) {
        errors.push('A senha deve ter pelo menos 6 caracteres.');
    }
    
    return {
        valid: errors.length === 0,
        errors
    };
}

export function validatePasswordConfirmation(password, confirmation) {
    if (password !== confirmation) {
        return {
            valid: false,
            error: 'As senhas não conferem.'
        };
    }
    
    return { valid: true, error: null };
}
