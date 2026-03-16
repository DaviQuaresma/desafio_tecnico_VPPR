export function setButtonLoading(loading, selectors, texts) {
    const $btn = $(selectors.button);
    const $text = $(selectors.text);
    const $spinner = $(selectors.spinner);

    if (loading) {
        $btn.prop('disabled', true);
        $text.text(texts.loading);
        $spinner.removeClass('hidden');
    } else {
        $btn.prop('disabled', false);
        $text.text(texts.normal);
        $spinner.addClass('hidden');
    }
}

export function createLoadingHandler(config) {
    const {
        buttonSelector = '#submit-btn',
        textSelector = '#btn-text',
        spinnerSelector = '#btn-spinner',
        loadingText = 'Carregando...',
        normalText = 'Enviar'
    } = config;

    return function(loading) {
        setButtonLoading(loading, {
            button: buttonSelector,
            text: textSelector,
            spinner: spinnerSelector
        }, {
            loading: loadingText,
            normal: normalText
        });
    };
}

export function setLoginLoading(loading) {
    setButtonLoading(loading, {
        button: '#submit-btn',
        text: '#btn-text',
        spinner: '#btn-spinner'
    }, {
        loading: 'Entrando...',
        normal: 'Entrar'
    });
}

export function setRegisterLoading(loading) {
    setButtonLoading(loading, {
        button: '#submit-btn',
        text: '#btn-text',
        spinner: '#btn-spinner'
    }, {
        loading: 'Criando conta...',
        normal: 'Criar conta'
    });
}

export function setResetPasswordLoading(loading) {
    setButtonLoading(loading, {
        button: '#submit-btn',
        text: '#btn-text',
        spinner: '#btn-spinner'
    }, {
        loading: 'Redefinindo...',
        normal: 'Redefinir senha'
    });
}

export function setSaveLoading(loading) {
    setButtonLoading(loading, {
        button: '#modal-submit',
        text: '#modal-submit-text',
        spinner: '#modal-submit-spinner'
    }, {
        loading: 'Salvando...',
        normal: 'Salvar'
    });
}

export function setDeleteLoading(loading) {
    setButtonLoading(loading, {
        button: '#modal-delete-confirm',
        text: '#delete-btn-text',
        spinner: '#delete-btn-spinner'
    }, {
        loading: 'Excluindo...',
        normal: 'Excluir'
    });
}
