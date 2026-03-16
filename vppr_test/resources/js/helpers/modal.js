export function openModal(selector) {
    $(selector).removeClass('hidden');
}

export function closeModal(selector) {
    $(selector).addClass('hidden');
}

export function createModalHandlers(modalSelector, options = {}) {
    const {
        formSelector = null,
        errorSelector = null,
        onClose = null
    } = options;

    return {
        open: function() {
            if (errorSelector) $(errorSelector).addClass('hidden');
            if (formSelector) $(formSelector)[0]?.reset();
            $(modalSelector).removeClass('hidden');
        },
        close: function() {
            $(modalSelector).addClass('hidden');
            if (onClose) onClose();
        }
    };
}

export function setupEscapeClose(...closeFunctions) {
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            closeFunctions.forEach(fn => fn());
        }
    });
}

export function bindCloseEvents(selectors, closeFunction) {
    $(selectors.join(', ')).on('click', closeFunction);
}
